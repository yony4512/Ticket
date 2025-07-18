<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'home']);
    }

    /**
     * Display the home page with statistics and featured events.
     */
    public function home()
    {
        // Estadísticas para la página de inicio
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalTickets = Ticket::count();
        
        // Eventos destacados (los más recientes y activos)
        $events = Event::with('user')
            ->active()
            ->upcoming()
            ->latest('event_date')
            ->take(6)
            ->get();
        
        return view('welcome', compact('events', 'totalUsers', 'totalEvents', 'totalTickets'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('user')->active()->upcoming();
        
        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }
        
        $events = $query->latest('event_date')->paginate(12);
        $categories = Event::categories();
        
        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display a listing of the user's events.
     */
    public function myEvents()
    {
        $events = Event::where('user_id', Auth::id())
                      ->with('user')
                      ->latest()
                      ->paginate(12);
        
        // Si es administrador y no tiene eventos, mostrar mensaje especial
        if (Auth::user()->hasRole('admin') && $events->isEmpty()) {
            return view('events.my-events', compact('events'))->with('info', 'Como administrador, no puedes crear eventos. Solo puedes gestionar eventos de otros usuarios desde el panel de administración.');
        }
        
        return view('events.my-events', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Los administradores no pueden crear eventos
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('events.index')
                ->with('error', 'Los administradores no pueden crear eventos. Solo pueden gestionar eventos existentes.');
        }
        
        $categories = Event::categories();
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Los administradores no pueden crear eventos
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('events.index')
                ->with('error', 'Los administradores no pueden crear eventos. Solo pueden gestionar eventos existentes.');
        }
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date|after:now',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active';
        
        $event = Event::create($validated);

        // Crear notificación para el usuario que creó el evento
        $user = Auth::user();
        $user->createNotification(
            'event_created',
            'Evento creado exitosamente',
            "Has creado el evento '{$event->title}' exitosamente. Ya está disponible para la venta de tickets.",
            [
                'event_id' => $event->id,
                'event_title' => $event->title,
                'event_date' => $event->event_date,
                'location' => $event->location
            ]
        );

        // Notificar a todos los administradores
        $admins = \App\Models\User::whereHas('roles', function($q){ $q->where('name', 'admin'); })->get();
        foreach ($admins as $admin) {
            $admin->createNotification(
                'event_created',
                'Nuevo evento creado',
                "El usuario '{$user->name}' ha creado el evento '{$event->title}'.",
                [
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'event_date' => $event->event_date,
                    'location' => $event->location,
                    'created_by' => $user->name,
                    'created_by_id' => $user->id
                ]
            );
        }

        return redirect()->route('events.show', $event)
            ->with('success', '¡Evento creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user');
        
        // Verificar si el usuario ya tiene tickets para este evento
        $userTicket = null;
        if (Auth::check()) {
            $userTicket = Auth::user()->tickets()
                ->where('event_id', $event->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();
        }

        return view('events.show', compact('event', 'userTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        
        // Verificar si el evento ya fue editado una vez
        if (!$event->canBeEdited()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Este evento ya ha sido editado una vez y no puede ser modificado nuevamente.');
        }
        
        $categories = Event::categories();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        // Verificar si el evento ya fue editado una vez
        if (!$event->canBeEdited()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Este evento ya ha sido editado una vez y no puede ser modificado nuevamente.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $path = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $path;
        }

        $event->update($validated);
        
        // Marcar el evento como editado
        $event->markAsEdited();

        return redirect()->route('events.show', $event)
            ->with('success', '¡Evento actualizado exitosamente! Esta es la única vez que puedes editar este evento.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', '¡Evento eliminado exitosamente!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Role;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // Estadísticas generales
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalTickets = Ticket::count();
        $totalRevenue = Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price');
        $activeEvents = Event::where('event_date', '>', now())->count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $ticketsThisMonth = Ticket::where('created_at', '>=', now()->startOfMonth())->count();
        $revenueThisMonth = Ticket::whereIn('status', ['confirmed', 'used'])
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total_price');

        // Eventos recientes
        $recentEvents = Event::with('user')->latest()->take(5)->get();

        // Tickets recientes
        $recentTickets = Ticket::with(['user', 'event'])->latest()->take(5)->get();

        // Usuarios recientes
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalEvents', 
            'totalTickets', 
            'totalRevenue', 
            'activeEvents', 
            'newUsersThisMonth', 
            'ticketsThisMonth', 
            'revenueThisMonth',
            'recentEvents', 
            'recentTickets',
            'recentUsers'
        ));
    }

    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function userShow(User $user)
    {
        $user->load(['events', 'tickets.event', 'roles']);
        
        $stats = [
            'total_events' => $user->events()->count(),
            'total_tickets' => $user->tickets()->count(),
            'total_spent' => $user->total_spent,
            'active_tickets' => $user->active_tickets_count,
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function userEdit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ]);

        // Actualizar roles
        $user->roles()->detach();
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function sendMessageToUser(Request $request, User $user)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Mensaje enviado exitosamente al usuario.');
    }

    public function events(Request $request)
    {
        $query = Event::with(['user', 'tickets']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Estadísticas para las tarjetas
        $activeEvents = Event::where('event_date', '>', now())->count();
        $totalTickets = Ticket::count();

        return view('admin.events.index', compact('events', 'activeEvents', 'totalTickets'));
    }

    public function eventShow(Event $event)
    {
        $event->load(['user', 'tickets.user']);
        
        $stats = [
            'total_tickets' => $event->tickets()->count(),
            'confirmed_tickets' => $event->tickets()->whereIn('status', ['pending', 'confirmed'])->count(),
            'total_revenue' => $event->tickets()->whereIn('status', ['confirmed', 'used'])->sum('total_price'),
            'available_capacity' => $event->available_capacity,
        ];

        return view('admin.events.show', compact('event', 'stats'));
    }

    public function eventEdit(Event $event)
    {
        $categories = Event::categories();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function eventUpdate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', array_keys(Event::categories())),
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive,cancelled'
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Evento actualizado exitosamente');
    }

    public function tickets(Request $request)
    {
        $query = Ticket::with(['user', 'event']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($uq) use ($request) {
                      $uq->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('event', function($eq) use ($request) {
                      $eq->where('title', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->event) {
            $query->where('event_id', $request->event);
        }

        $tickets = $query->latest('created_at')->paginate(15);
        
        // Estadísticas para las tarjetas
        $activeTickets = Ticket::where('status', 'active')->count();
        $usedTickets = Ticket::where('status', 'used')->count();
        $totalRevenue = Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price');
        $confirmedTickets = Ticket::where('status', 'confirmed')->count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        
        // Lista de eventos para el filtro
        $events = Event::select('id', 'title')->get();

        return view('admin.tickets.index', compact('tickets', 'activeTickets', 'usedTickets', 'totalRevenue', 'events', 'confirmedTickets', 'pendingTickets'));
    }

    public function ticketShow(Ticket $ticket)
    {
        $ticket->load(['user', 'event']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function ticketUpdate(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,used',
            'notes' => 'nullable|string'
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.show', $ticket)
            ->with('success', 'Ticket actualizado exitosamente');
    }

    public function reports()
    {
        // Reporte de usuarios
        $userStats = [
            'total' => User::count(),
            'this_month' => User::whereMonth('created_at', now()->month)->count(),
            'with_events' => User::whereHas('events')->count(),
            'with_tickets' => User::whereHas('tickets')->count(),
        ];

        // Reporte de eventos
        $eventStats = [
            'total' => Event::count(),
            'active' => Event::where('status', 'active')->count(),
            'upcoming' => Event::upcoming()->count(),
            'past' => Event::past()->count(),
            'by_category' => Event::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get()
        ];

        // Reporte de tickets
        $ticketStats = [
            'total' => Ticket::count(),
            'confirmed' => Ticket::where('status', 'confirmed')->count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'cancelled' => Ticket::where('status', 'cancelled')->count(),
            'used' => Ticket::where('status', 'used')->count(),
            'total_revenue' => Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price'),
            'monthly_revenue' => Ticket::whereIn('status', ['confirmed', 'used'])
                ->whereMonth('purchased_at', now()->month)
                ->sum('total_price')
        ];

        // Gráfico de ventas mensuales
        $monthlySales = Ticket::whereIn('status', ['confirmed', 'used'])
            ->selectRaw('MONTH(purchased_at) as month, SUM(total_price) as total')
            ->whereYear('purchased_at', now()->year)
            ->groupBy('month')
            ->get();

        // Top eventos por ventas
        $topEvents = Event::withCount(['tickets as total_tickets'])
            ->withSum(['tickets as total_revenue' => function($query) {
                $query->whereIn('status', ['confirmed', 'used']);
            }], 'total_price')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        return view('admin.reports', compact('userStats', 'eventStats', 'ticketStats', 'monthlySales', 'topEvents'));
    }

    public function messages()
    {
        $messages = Message::where('to_user_id', Auth::id())
            ->with('fromUser')
            ->latest()
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function messageShow(Message $message)
    {
        if ($message->to_user_id !== Auth::id()) {
            abort(403);
        }

        if ($message->isUnread()) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function showEvent(Event $event)
    {
        $event->load(['user', 'tickets.user']);
        return view('admin.events.show', compact('event'));
    }

    public function editEvent(Event $event)
    {
        $categories = Event::categories();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'category' => 'required|in:' . implode(',', array_keys(Event::categories())),
            'status' => 'required|in:active,inactive,cancelled'
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado correctamente');
    }

    public function showTicket(Ticket $ticket)
    {
        $ticket->load(['user', 'event']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function showMessage(Message $message)
    {
        // Marcar como leído
        if (!$message->read_at) {
            $message->update(['read_at' => now()]);
        }
        
        $message->load('fromUser');
        return view('admin.messages.show', compact('message'));
    }

    public function replyMessage(Request $request, Message $message)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Crear respuesta
        Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $message->from_user_id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'read_at' => null
        ]);

        return redirect()->route('admin.messages.index')->with('success', 'Respuesta enviada correctamente');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status']
        ]);

        // Actualizar rol
        $user->roles()->detach();
        $role = Role::where('name', $validated['role'])->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return redirect()->route('admin.users.show', $user)->with('success', 'Usuario actualizado correctamente');
    }

    public function userDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    public function eventCreate()
    {
        $categories = Event::categories();
        return view('admin.events.create', compact('categories'));
    }

    public function eventStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', array_keys(Event::categories())),
            'description' => 'required|string',
            'location' => 'required|string',
            'event_date' => 'required|date|after:today',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive'
        ]);

        $validated['user_id'] = Auth::id();
        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento creado exitosamente');
    }

    public function eventDestroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado exitosamente');
    }

    public function ticketMarkAsUsed(Ticket $ticket)
    {
        $ticket->update(['status' => 'used']);
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket marcado como usado');
    }

    public function ticketCancel(Ticket $ticket)
    {
        $ticket->update(['status' => 'cancelled']);
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket cancelado exitosamente');
    }

    public function settingsUpdate(Request $request)
    {
        // Aquí puedes implementar la lógica para actualizar configuraciones
        return redirect()->route('admin.settings')->with('success', 'Configuración actualizada exitosamente');
    }

    public function settingsEmailUpdate(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_username' => 'required|email',
            'smtp_password' => 'required|string|min:6'
        ]);

        // Aquí puedes implementar la lógica para actualizar la configuración de email
        // Por ejemplo, guardar en la base de datos o en archivos de configuración
        
        return redirect()->route('admin.settings')->with('success', 'Configuración de email actualizada exitosamente');
    }
} 
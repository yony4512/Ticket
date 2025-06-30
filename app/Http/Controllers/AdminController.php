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
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function sendMessageToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        $user = User::findOrFail($request->user_id);

        $newMessage = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        // Cargar la relación fromUser para la notificación
        $newMessage->load('fromUser');

        // Crear notificación para el usuario destinatario
        $user->notifyNewMessage($newMessage);

        return redirect()->back()->with('success', 'Mensaje enviado exitosamente al usuario.');
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
        $replyMessage = Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $message->from_user_id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'read_at' => null
        ]);

        // Cargar la relación fromUser para la notificación
        $replyMessage->load('fromUser');

        // Crear notificación para el usuario que recibió la respuesta
        $recipient = User::find($message->from_user_id);
        if ($recipient) {
            $recipient->notifyMessageReply($replyMessage);
        }

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

    public function downloadReport($type)
    {
        switch ($type) {
            case 'general':
                return $this->generateGeneralReport();
            case 'events':
                return $this->generateEventsReport();
            case 'top_events':
                return $this->generateTopEventsReport();
            default:
                abort(404);
        }
    }

    private function generateGeneralReport()
    {
        // Estadísticas generales
        $userStats = [
            'total' => User::count(),
            'this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $eventStats = [
            'total' => Event::count(),
            'active' => Event::where('event_date', '>', now())->count(),
            'by_category' => Event::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get()
        ];

        $ticketStats = [
            'total' => Ticket::count(),
            'pending' => Ticket::where('status', 'pending')->count(),
            'confirmed' => Ticket::where('status', 'confirmed')->count(),
            'used' => Ticket::where('status', 'used')->count(),
            'cancelled' => Ticket::where('status', 'cancelled')->count(),
            'total_revenue' => Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price'),
            'monthly_revenue' => Ticket::whereIn('status', ['confirmed', 'used'])
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('total_price')
        ];

        $pdf = PDF::loadView('admin.reports.pdf.general', compact('userStats', 'eventStats', 'ticketStats'));
        return $pdf->download('reporte-general-' . now()->format('Y-m-d') . '.pdf');
    }

    private function generateEventsReport()
    {
        $events = Event::with(['user', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('admin.reports.pdf.events', compact('events'));
        return $pdf->download('reporte-eventos-' . now()->format('Y-m-d') . '.pdf');
    }

    private function generateTopEventsReport()
    {
        $topEvents = Event::with('user')
            ->withCount(['tickets as total_tickets' => function($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'used']);
            }])
            ->withSum(['tickets as total_revenue' => function($query) {
                $query->whereIn('status', ['confirmed', 'used']);
            }], 'total_price')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        $pdf = PDF::loadView('admin.reports.pdf.top_events', compact('topEvents'));
        return $pdf->download('top-eventos-' . now()->format('Y-m-d') . '.pdf');
    }

    // --- FUNCIONES DE RESPALDO DEL SISTEMA ---
    public function backupCreate()
    {
        // Aquí deberías implementar la lógica real de respaldo (ejecutar un comando Artisan, etc)
        // Por ahora solo simula éxito
        return redirect()->route('admin.settings')->with('success', 'Respaldo creado exitosamente.');
    }

    public function backupRestore(Request $request)
    {
        // Aquí deberías implementar la lógica real de restauración (subir archivo, restaurar, etc)
        // Por ahora solo simula éxito
        return redirect()->route('admin.settings')->with('success', 'Respaldo restaurado exitosamente.');
    }

    public function backupHistory()
    {
        // Aquí deberías mostrar el historial real de respaldos
        // Por ahora solo muestra una vista simple
        return view('admin.backup-history');
    }

    // --- ESTADÍSTICAS DEL ADMINISTRADOR ---
    public function statistics()
    {
        // Estadísticas generales del sistema
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalTickets = Ticket::count();
        $totalRevenue = Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price');
        
        // Estadísticas por mes
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $usersThisMonth = User::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $eventsThisMonth = Event::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $ticketsThisMonth = Ticket::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $revenueThisMonth = Ticket::whereIn('status', ['confirmed', 'used'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');
        
        // Estadísticas de eventos por categoría
        $eventsByCategory = Event::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
        
        // Estadísticas de tickets por estado
        $ticketsByStatus = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        // Top 5 eventos más populares
        $topEvents = Event::withCount(['tickets as total_tickets' => function($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'used']);
            }])
            ->withSum(['tickets as total_revenue' => function($query) {
                $query->whereIn('status', ['confirmed', 'used']);
            }], 'total_price')
            ->orderByDesc('total_tickets')
            ->take(5)
            ->get();
        
        // Gráfico de ventas mensuales (últimos 6 meses)
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $sales = Ticket::whereIn('status', ['confirmed', 'used'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');
            
            $monthlySales[] = [
                'month' => $date->format('M Y'),
                'sales' => $sales
            ];
        }
        
        // Usuarios más activos
        $topUsers = User::withCount(['events as total_events', 'tickets as total_tickets'])
            ->orderByDesc('total_events')
            ->take(5)
            ->get();
        
        return view('admin.statistics', compact(
            'totalUsers', 'totalEvents', 'totalTickets', 'totalRevenue',
            'usersThisMonth', 'eventsThisMonth', 'ticketsThisMonth', 'revenueThisMonth',
            'eventsByCategory', 'ticketsByStatus', 'topEvents', 'monthlySales', 'topUsers'
        ));
    }

    public function downloadStatistics()
    {
        // Obtener las mismas estadísticas que en la vista
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalTickets = Ticket::count();
        $totalRevenue = Ticket::whereIn('status', ['confirmed', 'used'])->sum('total_price');
        
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $usersThisMonth = User::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $eventsThisMonth = Event::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $ticketsThisMonth = Ticket::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        $revenueThisMonth = Ticket::whereIn('status', ['confirmed', 'used'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');
        
        $eventsByCategory = Event::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
        
        $ticketsByStatus = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        $topEvents = Event::withCount(['tickets as total_tickets' => function($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'used']);
            }])
            ->withSum(['tickets as total_revenue' => function($query) {
                $query->whereIn('status', ['confirmed', 'used']);
            }], 'total_price')
            ->orderByDesc('total_tickets')
            ->take(5)
            ->get();
        
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $sales = Ticket::whereIn('status', ['confirmed', 'used'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_price');
            
            $monthlySales[] = [
                'month' => $date->format('M Y'),
                'sales' => $sales
            ];
        }
        
        $topUsers = User::withCount(['events as total_events', 'tickets as total_tickets'])
            ->orderByDesc('total_events')
            ->take(5)
            ->get();
        
        $pdf = PDF::loadView('admin.statistics-pdf', compact(
            'totalUsers', 'totalEvents', 'totalTickets', 'totalRevenue',
            'usersThisMonth', 'eventsThisMonth', 'ticketsThisMonth', 'revenueThisMonth',
            'eventsByCategory', 'ticketsByStatus', 'topEvents', 'monthlySales', 'topUsers'
        ));
        
        return $pdf->download('estadisticas-sistema-' . now()->format('Y-m-d') . '.pdf');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkoutForm(Request $request, Event $event)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $request->quantity;

        // Verificar disponibilidad
        if (!$event->canPurchase($quantity)) {
            return back()->withErrors(['quantity' => 'No hay suficientes entradas disponibles.']);
        }

        // Verificar que el evento no haya pasado
        if ($event->event_date->isPast()) {
            return back()->withErrors(['event' => 'Este evento ya ha pasado.']);
        }

        return view('tickets.checkout', compact('event', 'quantity'));
    }

    public function checkout(Request $request, Event $event)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $request->quantity;

        // Verificar disponibilidad
        if (!$event->canPurchase($quantity)) {
            return back()->withErrors(['quantity' => 'No hay suficientes entradas disponibles.']);
        }

        // Verificar que el evento no haya pasado
        if ($event->event_date->isPast()) {
            return back()->withErrors(['event' => 'Este evento ya ha pasado.']);
        }

        return view('tickets.checkout', compact('event', 'quantity'));
    }

    public function purchase(Request $request, Event $event)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'payment_method' => 'required|in:card,transfer',
            'card_number' => 'required_if:payment_method,card',
            'card_holder' => 'required_if:payment_method,card',
            'expiry_month' => 'required_if:payment_method,card',
            'expiry_year' => 'required_if:payment_method,card',
            'cvv' => 'required_if:payment_method,card',
            'billing_name' => 'required',
            'billing_email' => 'required|email',
            'billing_address' => 'required',
            'notes' => 'nullable|string|max:500'
        ]);

        $quantity = $request->quantity;

        // Verificar disponibilidad
        if (!$event->canPurchase($quantity)) {
            return back()->withErrors(['quantity' => 'No hay suficientes entradas disponibles.']);
        }

        // Verificar que el evento no haya pasado
        if ($event->event_date->isPast()) {
            return back()->withErrors(['event' => 'Este evento ya ha pasado.']);
        }

        try {
            DB::beginTransaction();

            // Calcular precio total con comisión
            $subtotal = $event->price * $quantity;
            $commission = $subtotal * 0.02; // 2% de comisión
            $total = $subtotal + $commission;

            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'ticket_code' => Ticket::generateTicketCode(),
                'quantity' => $quantity,
                'total_price' => $total,
                'subtotal' => $subtotal,
                'commission' => $commission,
                'payment_method' => $request->payment_method,
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_address' => $request->billing_address,
                'status' => $request->payment_method === 'transfer' ? 'pending' : 'confirmed',
                'purchased_at' => now(),
                'notes' => $request->notes
            ]);

            // Crear notificación para el usuario
            $user = Auth::user();
            $status = $request->payment_method === 'transfer' ? 'pendiente' : 'confirmado';
            $user->createNotification(
                'ticket_purchased',
                'Ticket comprado exitosamente',
                "Has comprado {$quantity} entrada(s) para '{$event->title}'. Estado: {$status}",
                [
                    'ticket_id' => $ticket->id,
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'quantity' => $quantity,
                    'total_price' => $total,
                    'status' => $ticket->status
                ]
            );

            DB::commit();

            if ($request->payment_method === 'transfer') {
                return redirect()->route('tickets.pending', $ticket)
                    ->with('success', '¡Pedido creado exitosamente! Completa el pago por transferencia bancaria.');
            }

            return redirect()->route('tickets.success', $ticket)
                ->with('success', '¡Pago procesado exitosamente! Tus entradas están confirmadas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar la compra. Inténtalo de nuevo.']);
        }
    }

    public function success(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        
        return view('tickets.success', compact('ticket'));
    }

    public function pending(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        
        return view('tickets.pending', compact('ticket'));
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        
        return view('tickets.show', compact('ticket'));
    }

    public function index()
    {
        $tickets = Auth::user()->tickets()
            ->with('event')
            ->latest('purchased_at')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function cancel(Ticket $ticket)
    {
        $this->authorize('cancel', $ticket);

        if (!$ticket->canBeCancelled()) {
            return back()->withErrors(['ticket' => 'No se puede cancelar este ticket.']);
        }

        $ticket->update(['status' => 'cancelled']);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket cancelado exitosamente.');
    }

    public function download(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        // Aquí podrías generar un PDF del ticket
        // Por ahora solo redirigimos a la vista
        return view('tickets.download', compact('ticket'));
    }
} 
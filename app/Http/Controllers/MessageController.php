<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Auth::user()->receivedMessages()
            ->with('fromUser')
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        // Verificar que el usuario puede ver este mensaje
        if ($message->to_user_id !== Auth::id() && $message->from_user_id !== Auth::id()) {
            abort(403);
        }

        // Marcar como leído si el usuario es el destinatario
        if ($message->to_user_id === Auth::id() && $message->isUnread()) {
            $message->markAsRead();
        }

        return view('messages.show', compact('message'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return redirect()->route('messages.index')
            ->with('success', 'Mensaje enviado exitosamente.');
    }

    public function sent()
    {
        $messages = Auth::user()->sentMessages()
            ->with('toUser')
            ->latest()
            ->paginate(15);

        return view('messages.sent', compact('messages'));
    }

    public function destroy(Message $message)
    {
        // Solo el remitente o destinatario puede eliminar el mensaje
        if ($message->from_user_id !== Auth::id() && $message->to_user_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('messages.index')
            ->with('success', 'Mensaje eliminado exitosamente.');
    }
}

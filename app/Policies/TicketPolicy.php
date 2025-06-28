<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    /**
     * Determine whether the user can cancel the ticket.
     */
    public function cancel(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id && $ticket->canBeCancelled();
    }

    /**
     * Determine whether the user can download the ticket.
     */
    public function download(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }
} 
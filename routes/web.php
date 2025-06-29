<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;

Route::get('/', [EventController::class, 'home'])->name('home');

Route::resource('events', EventController::class);

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/reclamaciones', function () {
    return view('reclamaciones');
})->name('reclamaciones');

Route::middleware('auth')->group(function () {
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my-events');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Rutas de tickets
    Route::get('/events/{event}/checkout', [TicketController::class, 'checkoutForm'])->name('tickets.checkout.form');
    Route::post('/events/{event}/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
    Route::post('/events/{event}/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/success', [TicketController::class, 'success'])->name('tickets.success');
    Route::get('/tickets/{ticket}/pending', [TicketController::class, 'pending'])->name('tickets.pending');
    Route::delete('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
    
    // Rutas de mensajes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    
    // Rutas de notificaciones
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecentNotifications'])->name('notifications.recent');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas del administrador
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Rutas de usuarios
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
    Route::post('/users/{user}/send-message', [AdminController::class, 'sendMessageToUser'])->name('users.send-message');
    Route::post('/users/send-message', [AdminController::class, 'sendMessageToUser'])->name('users.send-message-general');
    
    // Rutas de eventos
    Route::get('/events', [AdminController::class, 'events'])->name('events.index');
    Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('events.create');
    Route::post('/events', [AdminController::class, 'eventStore'])->name('events.store');
    Route::get('/events/{event}', [AdminController::class, 'eventShow'])->name('events.show');
    Route::get('/events/{event}/edit', [AdminController::class, 'eventEdit'])->name('events.edit');
    Route::put('/events/{event}', [AdminController::class, 'eventUpdate'])->name('events.update');
    Route::delete('/events/{event}', [AdminController::class, 'eventDestroy'])->name('events.destroy');
    
    // Rutas de tickets
    Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminController::class, 'ticketShow'])->name('tickets.show');
    Route::patch('/tickets/{ticket}', [AdminController::class, 'ticketUpdate'])->name('tickets.update');
    Route::patch('/tickets/{ticket}/mark-as-used', [AdminController::class, 'ticketMarkAsUsed'])->name('tickets.mark-as-used');
    Route::patch('/tickets/{ticket}/cancel', [AdminController::class, 'ticketCancel'])->name('tickets.cancel');
    
    // Rutas de mensajes
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages.index');
    Route::get('/messages/{message}', [AdminController::class, 'messageShow'])->name('messages.show');
    Route::post('/messages/{message}/reply', [AdminController::class, 'replyMessage'])->name('messages.reply');
    
    // Rutas de reportes y configuración
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/download/{type}', [AdminController::class, 'downloadReport'])->name('reports.download');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    Route::put('/settings/email', [AdminController::class, 'settingsEmailUpdate'])->name('settings.email');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
    // Rutas de backup
    Route::post('/backup/create', [AdminController::class, 'backupCreate'])->name('backup.create');
    Route::post('/backup/restore', [AdminController::class, 'backupRestore'])->name('backup.restore');
    Route::get('/backup/history', [AdminController::class, 'backupHistory'])->name('backup.history');
});

require __DIR__.'/auth.php';

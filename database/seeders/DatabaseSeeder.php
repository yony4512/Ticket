<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Role;
use App\Models\Message;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'display_name' => 'Administrador',
            'description' => 'Acceso total al sistema',
        ]);
        $userRole = Role::firstOrCreate([
            'name' => 'user',
        ], [
            'display_name' => 'Usuario',
            'description' => 'Usuario estándar',
        ]);

        // Crear usuarios de prueba
        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->assignRole($userRole);
        }

        // Crear eventos de prueba
        $categories = array_keys(\App\Models\Event::categories());
        
        foreach ($users as $user) {
            // Crear 2-4 eventos por usuario
            $eventCount = rand(2, 4);
            
            for ($i = 0; $i < $eventCount; $i++) {
                $event = \App\Models\Event::create([
                    'user_id' => $user->id,
                    'title' => fake()->sentence(3),
                    'category' => $categories[array_rand($categories)],
                    'description' => fake()->paragraph(3),
                    'location' => fake()->address(),
                    'event_date' => fake()->dateTimeBetween('now', '+2 months'),
                    'price' => fake()->randomFloat(2, 10, 200),
                    'capacity' => fake()->optional(0.7)->numberBetween(20, 100),
                    'status' => 'active',
                ]);

                // Crear algunos tickets para algunos eventos
                if (rand(0, 1)) {
                    $ticketCount = rand(1, 3);
                    for ($j = 0; $j < $ticketCount; $j++) {
                        $buyer = $users->random();
                        if ($buyer->id !== $user->id) { // No comprar tus propios eventos
                            Ticket::create([
                                'user_id' => $buyer->id,
                                'event_id' => $event->id,
                                'ticket_code' => Ticket::generateTicketCode(),
                                'quantity' => rand(1, 3),
                                'total_price' => $event->price * rand(1, 3),
                                'status' => fake()->randomElement(['pending', 'confirmed', 'used']),
                                'purchased_at' => fake()->dateTimeBetween('-1 month', 'now'),
                                'used_at' => fake()->optional(0.3)->dateTimeBetween('-1 month', 'now'),
                                'notes' => fake()->optional(0.4)->sentence(),
                            ]);
                        }
                    }
                }
            }
        }

        // Crear un usuario específico para pruebas y hacerlo admin
        $testUser = User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $testUser->assignRole($adminRole);

        // Crear un usuario normal para pruebas
        $normalUser = User::create([
            'name' => 'Usuario Normal',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole($userRole);

        // Crear algunos eventos para el usuario de prueba
        for ($i = 0; $i < 3; $i++) {
            \App\Models\Event::create([
                'user_id' => $testUser->id,
                'title' => 'Evento de Prueba ' . ($i + 1),
                'category' => $categories[array_rand($categories)],
                'description' => 'Este es un evento de prueba para demostrar las funcionalidades del sistema.',
                'location' => 'Cusco, Perú',
                'event_date' => fake()->dateTimeBetween('now', '+1 month'),
                'price' => fake()->randomFloat(2, 25, 150),
                'capacity' => rand(30, 80),
                'status' => 'active',
            ]);
        }

        // Crear algunos mensajes de prueba
        foreach ($users as $user) {
            // Mensaje del admin a algunos usuarios
            if (rand(0, 1)) {
                \App\Models\Message::create([
                    'from_user_id' => $testUser->id,
                    'to_user_id' => $user->id,
                    'subject' => 'Bienvenido a nuestro sistema de eventos',
                    'message' => 'Hola ' . $user->name . ', te damos la bienvenida a nuestro sistema de gestión de eventos. Esperamos que disfrutes de todas las funcionalidades disponibles.',
                    'status' => fake()->randomElement(['unread', 'read']),
                    'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
                ]);
            }

            // Mensaje de algunos usuarios al admin
            if (rand(0, 1)) {
                \App\Models\Message::create([
                    'from_user_id' => $user->id,
                    'to_user_id' => $testUser->id,
                    'subject' => 'Consulta sobre eventos',
                    'message' => 'Hola administrador, tengo una consulta sobre los eventos disponibles. ¿Podrías ayudarme?',
                    'status' => fake()->randomElement(['unread', 'read']),
                    'created_at' => fake()->dateTimeBetween('-1 week', 'now'),
                ]);
            }
        }
    }
}

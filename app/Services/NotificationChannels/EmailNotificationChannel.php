<?php

namespace App\Services\NotificationChannels;

use Illuminate\Support\Facades\Log;

class EmailNotificationChannel
{
    public function send(string $email, string $message): void
    {
        Log::info("Correo enviado a {$email}: {$message}");
    }
}

<?php

namespace App\Services\NotificationChannels;

use Illuminate\Support\Facades\Log;

class WhatsAppNotificationChannel
{
    public function sendText(string $phone, string $message): void
    {
        Log::info("WhatsApp (Texto) enviado a {$phone}: {$message}");
    }

    public function sendWithAttachment(string $phone, string $message, string $fileUrl): void
    {
        Log::info("WhatsApp (Con adjunto) enviado a {$phone}: {$message}, Archivo: {$fileUrl}");
    }

    public function sendAudio(string $phone, string $audioUrl): void
    {
        Log::info("WhatsApp (Audio) enviado a {$phone}: Archivo: {$audioUrl}");
    }
}

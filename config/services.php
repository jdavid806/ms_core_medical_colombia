<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'webhooks' => [
        'n8n-seguimiento-cronico' => env('N8N_SEGUIMIENTO_CRONICO_URL', 'https://hooks.medicalsoft.ai/webhook/seguimiento-cronico'),

        'n8n-resumen-historia-clinica' => env('N8N_RESUMEN_HISTORIA_CLINICA_URL', 'https://hooks.medicalsoft.ai/webhook/resumenclinico'),

        'n8n-educar-paciente' => env('N8N_EDUCAR_PACIENTE_URL', 'https://hooks.medicalsoft.ai/webhooks/n8n/educar-paciente'),

        'n8n-inteligencia-comercial' => env('N8N_INTELIGENCIA_COMERCIAL_URL', 'https://hooks.medicalsoft.ai/webhook/inteligenciacomercial'),

        'n8n-costo-rentabilidad' => env('N8N_COSTO_RENTABILIDAD_URL', 'https://hooks.medicalsoft.ai/webhook/costosyrentabilidad'),

        'n8n-post-consultas' => env('N8N_POST_CONSULTAS_URL', 'https://hooks.medicalsoft.ai/webhook/postconsulta'),

        'n8n-confirmacion-cita-pago' => env('N8N_CONFIRMACION_CITA_PAGO_URL', 'https://hooks.medicalsoft.ai/webhook/confirmacioncita-pago'),

    ],

    'admin' => [
        'products_url' => env('ADMIN_PRODUCTS_URL', 'http://admin.microservice/api/v1/products'),
    ],


];

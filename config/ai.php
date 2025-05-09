<?php

// config/ai.php
return [
    'responsable_types' => [
        'patient' => \App\Models\Patient::class,
        'clinical_record' => \App\Models\ClinicalRecord::class,
    ]
];

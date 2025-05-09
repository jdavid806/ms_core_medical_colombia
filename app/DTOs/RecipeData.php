<?php

namespace App\DTOs;

class RecipeData
{
    public function __construct(
        public readonly int $patientId,
        public readonly int $userId,
        public readonly int $clinicalRecordId,
        public readonly bool $isActive,
        public readonly string $type, // 'general' o 'optometry'
        public readonly array $medicines = [],
        public readonly array $optometry = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            patientId: $data['patient_id'] ?? null,
            userId: $data['user_id'] ?? null,
            clinicalRecordId: $data['clinical_record_id'] ?? null,
            isActive: $data['is_active'] ?? true,
            type: $data['type'] ?? 'general',
            medicines: $data['medicines'] ?? [],
            optometry: $data['optometry'] ?? [],
        );
    }
}

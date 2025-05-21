<?php

namespace App\Repositories;

use App\Models\CopaymentRule;

class CopaymentRuleRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(CopaymentRule $copaymentRule)
    {
        parent::__construct($copaymentRule, self::RELATIONS);
    }

    // CopaymentRuleRepository
    public function updateOrCreateByAttributes(array $data)
    {
        $criteria = [
            'attention_type' => $data['attention_type'],
            'type_scheme'    => $data['type_scheme'],
            'category'       => $data['category'] ?? null,
            'level'          => $data['level'] ?? null,
            'type'           => $data['type'],
        ];

        // Determinar el valor según el tipo
        $value = ($data['type'] === 'fixed')
            ? $data['fixed_amount']
            : $data['percentage'];

        $values = [
            'value' => $value, // <--- Aquí usamos la columna correcta
            'valid_from' => now(), // Si aplica
            // ... otros campos si son necesarios
        ];

        return $this->model::updateOrCreate($criteria, $values);
    }
}

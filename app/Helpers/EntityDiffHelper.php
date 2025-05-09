<?php

namespace App\Helpers;

class EntityDiffHelper
{
    public static function detectChanges(array $oldData, array $newData): array
    {
        $changes = [];

        foreach ($newData as $key => $value) {
            if (array_key_exists($key, $oldData) && $oldData[$key] !== $value) {
                $changes[$key] = $value;
            }
        }

        return $changes;
    }
}

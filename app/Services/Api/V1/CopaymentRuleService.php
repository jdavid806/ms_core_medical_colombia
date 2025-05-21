<?php

namespace App\Services\Api\V1;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\CopaymentRule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Models\ExternalProductCache;
use App\Exceptions\CopaymentRuleException;
use App\Repositories\CopaymentRuleRepository;

class CopaymentRuleService
{
    public function __construct(private CopaymentRuleRepository $copaymentRuleRepository) {}

    public function calculateForAppointment(Appointment $appointment, Patient $patient): float
    {
        $typeScheme = $patient->socialSecurity->type_scheme;
        $attentionType = $appointment->attention_type;

        // CONSULTATION
        if ($attentionType === 'CONSULTATION') {
            if ($typeScheme === 'contributory') {
                $rule = CopaymentRule::where('type_scheme', 'contributory')
                    ->where('category', $patient->socialSecurity->category)
                    ->where('type', 'fixed')
                    ->value('value') ?? 0;
                return $rule;
            }

            // subsidiado no paga cuota
            return 0;
        }

        // PROCEDURE
        if ($attentionType === 'PROCEDURE') {
            $product = ExternalProductCache::where('external_id', $appointment->product_id)->first();

            if (! $product) {
                // opcionalmente lanzar una excepción o loggear
                return 0;
            }

            $baseAmount = $product->sale_price; // aquí defines baseAmount

            if ($typeScheme === 'contributory') {
                $rule = CopaymentRule::where('type_scheme', 'contributory')
                    ->where('category', $patient->socialSecurity->category)
                    ->where('type', 'percentage')
                    ->first();
            } elseif ($typeScheme === 'subsidiary' && $patient->socialSecurity->level === '2') {
                $rule = CopaymentRule::where('type_scheme', 'subsidiary')
                    ->where('level', '2')
                    ->where('type', 'percentage')
                    ->first();
            } else {
                return 0;
            }

            return $rule ? ($baseAmount * ($rule->value / 100)) : 0;
        }

        return 0;
    }

    public function getAllCopaymentRules($filters, $perPage)
    {
        try {
            return CopaymentRule::filter($filters)->paginate($perPage);
        } catch (\Exception $e) {
            throw new CopaymentRuleException('Failed to retrieve CopaymentRules', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCopaymentRuleById(CopaymentRule $copaymentRule)
    {
        $result = $this->copaymentRuleRepository->find($copaymentRule);
        if (!$result) {
            throw new CopaymentRuleException('CopaymentRule not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    public function createCopaymentRule(array $data)
    {
        try {
            return $this->copaymentRuleRepository->create($data);
        } catch (\Exception $e) {
            throw new CopaymentRuleException('Failed to create CopaymentRule', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCopaymentRule(CopaymentRule $copaymentRule, array $data)
    {
        try {
            return $this->copaymentRuleRepository->update($copaymentRule, $data);
        } catch (\Exception $e) {
            throw new CopaymentRuleException('Failed to update CopaymentRule', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCopaymentRule(CopaymentRule $copaymentRule)
    {
        try {
            return $this->copaymentRuleRepository->delete($copaymentRule);
        } catch (\Exception $e) {
            throw new CopaymentRuleException('Failed to delete CopaymentRule', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateOrCreateRule(array $data): array
    {
        try {
            $results = [];

            foreach ($data['rules'] as $rule) {
                // Normaliza aquí, dentro de cada regla
                $rule['attention_type'] = strtolower($rule['attention_type']);
                $rule['type_scheme'] = strtolower($rule['type_scheme']);

                $results[] = $this->copaymentRuleRepository->updateOrCreateByAttributes($rule);
            }

            return $results;
        } catch (\Throwable $e) {
            Log::error("Original error in " . __METHOD__, ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw new CopaymentRuleException("Failed to update or create CopaymentRule", 500, $e);
        }
    }
}

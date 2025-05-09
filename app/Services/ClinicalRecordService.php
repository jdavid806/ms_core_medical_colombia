<?php

namespace App\Services;

use App\DTOs\RecipeData;
use App\Models\ExamType;
use App\Models\ExamRecipe;
use Illuminate\Support\Arr;
use App\Models\ExamRecipeDetail;
use Illuminate\Support\Facades\DB;
use App\Services\ExamRecipeService;
use App\Repositories\ClinicalRecordRepository;

class ClinicalRecordService extends OneToManyService
{
    protected $repository;

    public function __construct(
        ClinicalRecordRepository $repository,
        private ExamRecipeService $examRecipeService,
        private PatientDisabilityService $patientDisabilityService,
        private RecipeService $recipeService,
        private RemissionService $remissionService,
        private VaccineApplicationService $vaccineApplicationService,
        private EvolutionNoteService $evolutionNoteService


    ) {
        $this->repository = $repository;
    }

    public function getByType($type, $patientId)
    {
        return $this->repository->getByType($type, $patientId);
    }


    public function createClinicalRecord($patientId, $data)
    {


        return DB::transaction(function () use ($patientId, $data) {
            // Crear registro clínico con datos básicos
            $clinicalRecordData = array_merge(
                ['patient_id' => $patientId],
                Arr::except($data, ['exam_order', 'patient_disability', 'recipe', 'remission', 'evolution_note', 'vaccine_application', 'exam_recipes'])
            );

            $clinicalRecord = $this->repository->create($clinicalRecordData);

            // Procesar órdenes de examen
            if (!empty($data['exam_order'])) {
                $laboratoryExams = [];

                foreach ($data['exam_order'] as $value) {
                    $exam = ExamType::find($value['exam_order_item_id']);

                    if ($exam->type === 'LABORATORY') {
                        $laboratoryExams[] = $value['exam_order_item_id'];
                        continue;
                    }

                    $examRecipeImaging = ExamRecipe::create([
                        'patient_id' => $patientId,
                        'user_id' => $data['created_by_user_id']
                    ]);

                    ExamRecipeDetail::create([
                        'exam_recipe_id' => $examRecipeImaging->id,
                        'exam_type_id' => $value['exam_order_item_id']
                    ]);
                }

                if (!empty($laboratoryExams)) {
                    $examRecipeLaboratory = ExamRecipe::create([
                        'patient_id' => $patientId,
                        'user_id' => $data['created_by_user_id']
                    ]);

                    foreach ($laboratoryExams as $examId) {
                        ExamRecipeDetail::create([
                            'exam_recipe_id' => $examRecipeLaboratory->id,
                            'exam_type_id' => $examId
                        ]);
                    }
                }
            }

            // Crear notas de evolución si existen
            if (!empty($data['evolution_note'])) {
                $this->createEvolutionNotes($patientId, $data['evolution_note'], $clinicalRecord->id);
            }

            // Crear remisión si existe
            if (!empty($data['remission'])) {
                $this->createRemission($clinicalRecord->id, $data['remission']);
            }

            // Crear incapacidad del paciente si existe
            if (!empty($data['patient_disability'])) {
                $this->createPatientDisability($patientId, $data['patient_disability'], $clinicalRecord->id);
            }

            // Crear receta médica si existe
            if (!empty($data['recipe']) && isset($data['recipe']['patient_id'], $data['recipe']['user_id'])) {
                $recipeData = $data['recipe'];

                $dto = new RecipeData(
                    patientId: $recipeData['patient_id'],
                    userId: $recipeData['user_id'],
                    clinicalRecordId: $clinicalRecord->id,
                    isActive: $recipeData['is_active'] ?? true,
                    type: $recipeData['type'] ?? null,
                    medicines: $recipeData['medicines'] ?? [],
                    optometry: $recipeData['optometry'] ?? []
                );

                $this->createRecipe($dto);
            }

            // Crear receta de exámenes si existen
            if (!empty($data['exam_recipes'])) {
                $this->createExamRecipe($patientId, $data['exam_recipes'], $clinicalRecord->id);
            }

            // Crear aplicación de vacuna si existe
            if (!empty($data['vaccine_application'])) {
                $this->createVaccineApplications($patientId, $data['vaccine_application'], $clinicalRecord->id);
            }

            return response()->json([
                'message' => 'Registro clínico creado exitosamente',
                'clinical_record' => $clinicalRecord->load([
                    'clinicalRecordType',
                    'patient',
                    'createdByUser',
                    'evolutionNotes',
                    'remissions',
                    'recipes',
                    'examRecipes',
                    'patientDisabilities',
                    'vaccineApplications'
                ])
            ], 201);
        });
    }


    private function createEvolutionNotes($patientId, $data, $clinicalRecordId): void
    {
        if (!empty($data)) {
            $this->evolutionNoteService->createEvolutionNote(array_merge(
                ['patient_id' => $patientId],
                ['clinical_record_id' => $clinicalRecordId],
                $data
            ));
        }
    }

    private function createRemission(int $clinicalRecordId, array $data): void
    {
        if (!empty($data)) {
            $this->remissionService->create(
                array_merge($data, ['clinical_record_id' => $clinicalRecordId])
            );
        }
    }

    private function createRecipe(RecipeData $dto): void
    {
        $this->recipeService->createRecipe($dto);
    }

    private function createExamRecipe($patientId, $data, $clinicalRecordId): void
    {
        if (!empty($data)) {
            $this->examRecipeService->createExamRecipe(array_merge(
                ['patient_id' => $patientId],
                ['clinical_record_id' => $clinicalRecordId],
                $data
            ));
        }
    }


    private function createPatientDisability($patientId, array $data, $clinicalRecordId): void
    {
        if (!empty($data)) {
            $this->patientDisabilityService->create(array_merge(
                ['patient_id' => $patientId],
                ['clinical_record_id' => $clinicalRecordId],
                $data
            ));
        }
    }


    private function createVaccineApplications($patientId, $data, $clinicalRecordId): void
    {
        if (!empty($data)) {
            $this->vaccineApplicationService->create(array_merge(
                ['patient_id' => $patientId],
                ['clinical_record_id' => $clinicalRecordId],
                $data
            ));
        }
    }


    public function getLastByPatient($patientId)
    {
        return $this->repository->getLastByPatient($patientId);
    }
}

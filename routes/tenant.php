<?php

declare(strict_types=1);

use App\Models\UserAbsence;
use App\Services\TemplateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\UserRoleController;
use App\Http\Middleware\ApiHeaderMiddleware;
use App\Http\Middleware\ResolveTenantByPath;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ExamOrderController;
use App\Http\Controllers\RemissionController;
use App\Http\Controllers\ExamRecipeController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\UserBranchController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\CupsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ExamPackageController;
use App\Http\Controllers\NursingNoteController;
use App\Http\Controllers\UserAbsenceController;
use App\Http\Middleware\DetectTenantAndService;
use App\Http\Controllers\Api\V1\AgentController;
use App\Http\Controllers\Api\V1\AssetController;
use App\Http\Controllers\Api\V1\Cie11Controller;
use App\Http\Controllers\ExamCategoryController;
use App\Http\Controllers\GroupVaccineController;
use App\Http\Controllers\UserRoleMenuController;
use App\Http\Controllers\Api\V1\EntityController;
use App\Http\Controllers\Api\V1\OfficeController;
use App\Http\Controllers\Api\V1\RecipeController;
use App\Http\Controllers\NotAttendanceController;
use App\Http\Controllers\SpecializableController;
use App\Http\Controllers\UserSpecialtyController;
use App\Http\Controllers\Api\V1\BillingController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\ClinicalRecordController;
use App\Http\Controllers\ExamOrderStateController;
use App\Http\Controllers\Api\V1\SurveyControllerV1;
use App\Http\Controllers\AppointmentTypeController;
use App\Http\Controllers\ComissionConfigController;
use App\Http\Controllers\ExamPackageItemController;
use App\Http\Controllers\Api\V1\CompanionController;
use App\Http\Controllers\Api\V1\SpecialtyController;
use App\Http\Controllers\AppointmentStateController;
use App\Http\Controllers\ExamRecipeResultController;
use App\Http\Controllers\UserAvailabilityController;





use App\Http\Controllers\VaccinationGroupController;

use App\Http\Controllers\Api\V1\AiResponseController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\ItemLookupController;
use App\Http\Controllers\PatientDisabilityController;
use App\Http\Controllers\UserSpecialtyMenuController;
use App\Http\Controllers\ClinicalRecordTypeController;
use App\Http\Controllers\UserRolePermissionController;
use App\Http\Controllers\VaccineApplicationController;
use App\Http\Controllers\Api\V1\DisabilityControllerV1;
use App\Http\Controllers\Api\V1\PrescriptionController;
use App\Http\Controllers\Api\V1\RelationshipController;
use App\Http\Controllers\HistoryPreadmissionController;
use App\Http\Controllers\Api\V1\BranchCompanyController;
use App\Http\Controllers\Api\V1\CommunicationController;
use App\Http\Controllers\Api\V1\IntegrationControllerV1;
use App\Http\Controllers\Api\V1\PaymentMethodController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Api\V1\ProductServiceController;
use App\Http\Controllers\Api\V1\RepresentativeController;
use App\Http\Controllers\ClinicalEvolutionNoteController;
use App\Http\Controllers\Api\V1\CopaymentRuleControllerV1;
use App\Http\Controllers\Api\V1\EstimateServiceController;
use App\Http\Controllers\Api\V1\ResponseAgentAIController;
use App\Http\Controllers\Api\V1\TemplateServiceController;
use App\Http\Controllers\Api\V1\PatientCompanionController;
use App\Http\Controllers\Api\V1\ProductInventoryController;
use App\Http\Controllers\Api\V2\SocialSecurityControllerV2;
use App\Http\Controllers\Api\V1\IntegrationUserControllerV1;
use App\Http\Controllers\Api\V1\CreatePrescriptionController;
use App\Http\Controllers\Api\V1\RecipeItemOptometryController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Api\V1\BranchRepresentativeController;
use App\Http\Controllers\Api\V1\ConversationalFunnelController;
use App\Http\Controllers\Api\V1\ProductTypeInventoryController;
use App\Http\Controllers\Api\V1\ExternalProductCacheControllerV1;
use App\Http\Controllers\Api\V1\IntegrationCredentialControllerV1;
use App\Http\Controllers\Api\V1\PatientCompanionSocialSecurityController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::prefix('medical')->middleware([
    'api',
    DetectTenantAndService::class,
    PreventAccessFromCentralDomains::class,
    ApiHeaderMiddleware::class,
    ResolveTenantByPath::class,
])->group(function () {

    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::manyToManyResource('group-vaccines', GroupVaccineController::class);
    Route::manyToManyResource('user-branches', UserBranchController::class);
    Route::manyToManyResource('user-role-permissions', UserRolePermissionController::class);
    Route::manyToManyResource('user-role-menus', UserRoleMenuController::class);
    Route::manyToManyResource('user-specialty-menus', UserSpecialtyMenuController::class);

    Route::prefix('exam-package-items')
        ->controller(ExamPackageItemController::class)
        ->group(function () {
            Route::get('/{parentId}', 'index');
            Route::get('/{parentId}/{childType}', 'indexByChildType');
            Route::post('/{parentId}', 'store');
            Route::put('/{parentId}', 'update');
            Route::delete('/{parentId}', 'destroy');
        });

    Route::extendedApiResource('branches', BranchController::class);
    Route::extendedApiResource('modules', ModuleController::class);

    Route::extendedApiResource('tickets', TicketController::class);
    Route::post('tickets/by-reasons', [TicketController::class, 'indexByReasons']);

    Route::apiResource('companions', CompanionController::class);
    Route::apiResource('patients', PatientController::class);
    Route::post('/patients/{patient}/companions', [PatientCompanionController::class, 'store']);
    Route::post('/patients-companion-social-security', [PatientCompanionSocialSecurityController::class, 'storePatient']);

    Route::put('/patients-companion-social-security/{id}', [PatientCompanionSocialSecurityController::class, 'updatePatient']);


    Route::apiResource('relationships', RelationshipController::class);



    Route::apiResource('exam-categories', ExamCategoryController::class);
    Route::apiResource('exam-types', ExamTypeController::class);
    Route::apiResource('comission-config', ComissionConfigController::class);
    Route::post('commissions-report/services', [ComissionConfigController::class, 'commissionByServiceReport']);

    Route::apiResource('exam-orders', ExamOrderController::class);
    Route::prefix('exam-orders')
        ->controller(ExamOrderController::class)
        ->group(function () {
            Route::post('finish-appointment/{examOrderId}', 'finishAppointment');
            Route::post('update-minio-file/{examOrderId}/{minioId}', 'updateMinioFile');
            Route::get('last-by-patient/{patientId}', 'getLastbyPatient');
        });

    Route::apiResource('exam-order-states', ExamOrderStateController::class);
    Route::apiResource('exam-packages', ExamPackageController::class);
    Route::apiResource('exam-results', ExamResultController::class);

    Route::prefix('patients')
        ->controller(PatientController::class)
        ->group(function () {
            Route::get('/evolution/{id}', 'evolution');
        });
    Route::prefix('patients')
        ->controller(PatientController::class)
        ->group(function () {
            Route::get('/by-phone/{phone}', 'getByPhone');
        });
    Route::prefix('patients')
        ->controller(PatientController::class)
        ->group(function () {
            Route::get('/by-document/{document}', 'getByDocument');
        });
    Route::extendedApiResource('patients', PatientController::class);


    Route::extendedApiResource('admissions', AdmissionController::class)->except('store');
    Route::post('admissions/{patient}/create', [AdmissionController::class, 'store']);
    Route::post('/admissions/show-multiple', [AdmissionController::class, 'showMultiple']);
    Route::get('admissions-all', [AdmissionController::class, 'getAllAdmissions'])->name('admissions.getAllAdmissions');


    Route::post('offices-company', [OfficeController::class, 'storeCompany']);
    Route::post('office-person', [OfficeController::class, 'storePerson']);



    Route::apiResource('patients.admissions', AdmissionController::class)->shallow();

    Route::extendedApiResource('appointment-types', AppointmentTypeController::class);

    Route::extendedApiResource('appointment-states', AppointmentStateController::class);

    Route::prefix('appointments')
        ->controller(AppointmentController::class)
        ->group(function () {
            Route::post('store-recurrent', 'recurringAppointment');
            Route::get('last-by-patient/{id}', [AppointmentController::class, 'getLastByPatient']);
        });
    Route::extendedApiResource('patients.appointments', AppointmentController::class)->shallow();

    Route::extendedApiResource('patients.disabilities', PatientDisabilityController::class)->shallow();
    Route::get('patients-disabilities/last-by-patient/{id}', [PatientDisabilityController::class, 'getLastByPatient']);
    Route::apiResource('patients.nursing-notes', NursingNoteController::class)->shallow();
    Route::apiResource('patients.vaccine-applications', VaccineApplicationController::class)->shallow();
    Route::apiResource('patients.clinical-records', ClinicalRecordController::class)->shallow();

    Route::post('clinical-records-params/{patientId}', [ClinicalRecordController::class, 'crateClinicalRecordParams']);

    Route::apiResource('clinical-record-types', ClinicalRecordTypeController::class)->shallow();
    Route::get('clinical-records/get-by-type/{type}/{patientId}', [ClinicalRecordController::class, 'getByType']);
    Route::get('clinical-records/last-by-patient/{patientId}', [ClinicalRecordController::class, 'getLastByPatient']);
    Route::get('clinical-records/get-paraclinical-by-appointment/{appointment}', [ClinicalRecordController::class, 'getParaclinicalByAppointment']);

    //Route::apiResource('clinical-records.evolution-notes', ClinicalEvolutionNoteController::class)->shallow();

    Route::apiResource('clinical-records.evolution-notes', ClinicalEvolutionNoteController::class)->shallow();

    Route::get('evolution-notes/by-params/{startDate}/{endDate}/{userId}/{patientId}', [ClinicalEvolutionNoteController::class, 'getEvolutionsByParams']);

    Route::apiResource('clinical-records.remissions', RemissionController::class)->shallow();

    Route::get('remissions/by-params/{startDate}/{endDate}/{userId}/{patientId}', [RemissionController::class, 'getRemissionsByParams']);

    Route::get('user-availabilities/available-blocks', [UserAvailabilityController::class, 'availableBlocks']);

    Route::get('cups/get-by-code/{code}', [CupsController::class, 'getByCode']);
    Route::get('cups/get-by-name/{name}', [CupsController::class, 'getByName']);
    Route::get('cie11/get-by-code/{code}', [Cie11Controller::class, 'getByCode']);
    Route::get('cie11/get-by-name/{name}', [Cie11Controller::class, 'getByName']);

    Route::extendedApiResource('users.availabilities', UserAvailabilityController::class)->shallow();

    Route::apiResource('users', UserController::class);
    Route::apiResource('user-specialties', UserSpecialtyController::class);
    Route::apiResource('patient-companions', PatientCompanionController::class);
    Route::apiResource('vaccines', VaccineController::class);
    Route::apiResource('vaccination-groups', VaccinationGroupController::class);


    Route::get('user-availabilities/available-blocks', [UserAvailabilityController::class, 'availableBlocks']);

    /* Prescription */


    Route::apiResource('prescriptions', PrescriptionController::class);

    Route::apiResource('recipes', RecipeController::class);
    Route::get('recipes/last-of/patient/{patientId}', [RecipeController::class, 'getLastPatientRecipe'])->name('recipes.lastPatientRecipe');
    Route::post('recipes/{id}/update-status', [RecipeController::class, 'updateStatus'])->name('recipes.updateStatus');
    Route::post('create-prescription', [CreatePrescriptionController::class, 'store'])->name('prescriptions.store');


    /* Microservice Admin */

    Route::get('products-services', [ProductServiceController::class, 'getAllProductsServices'])->name('products.services');

    Route::get('products-by-exam-recipe/{id}', [ProductServiceController::class, 'getByExamRecipeId']);


    /* Microservice Admin */

    Route::get('products-all', [ProductServiceController::class, 'getAllProducts'])->name('products.all');

    Route::get('products-services', [ProductServiceController::class, 'getAllProductsServices'])->name('products.services');

    Route::get('product/{id}', [ProductInventoryController::class, 'getProductById'])->name('product.get');

    Route::post('product-create', [ProductInventoryController::class, 'create'])->name('product.create');

    Route::get('products-types', [ProductTypeInventoryController::class, 'index'])->name('products.types');

    Route::apiResource('payment-methods', PaymentMethodController::class);

    /* Microservice Firma */

    Route::post('template-create', [TemplateServiceController::class, 'create'])->name('template.create');

    Route::get('estimates-all', [EstimateServiceController::class, 'getAllEstimates']);

    Route::post('estimate-create', [EstimateServiceController::class, 'create']);


    //Route::get('cups', [CupsController::class, 'index'])->name('cups.index');


    /* Microservice Firma */

    Route::post('template-create', [TemplateServiceController::class, 'create'])->name('template.create');

    /*----------------------------------- central_connection ----------------------------------- */
    /* Country */
    Route::get('countries', [CountryController::class, 'index']);
    /* Departments */
    Route::get('departments/{country}', [DepartmentController::class, 'departmentsByCountry']);
    /* Cities */
    Route::get('cities/{department}', [CityController::class, 'citiesByDepartment']);
    Route::get('cities/by-country/{country}', [CityController::class, 'citiesByCountry']);

    /* Cups */

    Route::get('cups', [CupsController::class, 'index'])->name('cups.index');

    /* Entities */

    Route::apiResource('entities', EntityController::class);

    /* Specialty */

    Route::get('specialties', [SpecialtyController::class, 'index'])->name('specialties.index');
    Route::post('/user-specialties', [UserSpecialtyController::class, 'store'])->name('user-specialties.store');

    Route::post('change-status-appointment/{id}/{statusKey}', [AppointmentController::class, 'changeStatus']);


    /* Company */
    //Route::apiResource('companies', CompanyController::class);
    //Route::post('company-create-complte', [CompanyController::class, 'createCompanyComplete']);
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index']); // Listar compañías
        Route::post('/', [CompanyController::class, 'store']); // Crear compañía
        Route::get('{company}', [CompanyController::class, 'show']); // Mostrar compañía
        Route::put('{company}', [CompanyController::class, 'update']); // Actualizar compañía
        Route::delete('{company}', [CompanyController::class, 'destroy']); // Eliminar compañía
    });

    Route::prefix('companies/{company}/representative')->group(function () {
        Route::get('/', [RepresentativeController::class, 'show']); // Mostrar el representante de la compañía
        Route::post('/', [RepresentativeController::class, 'store']); // Crear un representante
        Route::put('/', [RepresentativeController::class, 'update']); // Actualizar el representante
        Route::delete('/', [RepresentativeController::class, 'destroy']); // Eliminar el representante
    });


    Route::prefix('companies/{company}/communication')->group(function () {
        Route::get('/', [CommunicationController::class, 'show']); // Mostrar la configuración de comunicación de la compañía
        Route::post('/', [CommunicationController::class, 'store']); // Crear la configuración de comunicación
        Route::put('/', [CommunicationController::class, 'update']); // Actualizar la configuración de comunicación
        Route::delete('/', [CommunicationController::class, 'destroy']); // Eliminar la configuración de comunicación
    });


    Route::prefix('companies/{company}/billings')->group(function () {
        Route::get('/', [BillingController::class, 'index']); // Listar todas las facturaciones de una compañía
        Route::post('/', [BillingController::class, 'store']); // Crear una nueva facturación
        Route::get('{billing}', [BillingController::class, 'show']); // Mostrar una facturación específica
        Route::put('{billing}', [BillingController::class, 'update']); // Actualizar una facturación específica
        Route::delete('{billing}', [BillingController::class, 'destroy']); // Eliminar una facturación específica
    });

    Route::prefix('companies/{company}/branches')->group(function () {
        Route::get('/', [BranchCompanyController::class, 'index']); // Listar sucursales de la compañía
        Route::post('/', [BranchCompanyController::class, 'store']); // Crear una sucursal
        Route::get('{branch}', [BranchCompanyController::class, 'show']); // Mostrar una sucursal específica
        Route::put('{branch}', [BranchCompanyController::class, 'update']); // Actualizar una sucursal
        Route::delete('{branch}', [BranchCompanyController::class, 'destroy']); // Eliminar una sucursal
    });



    Route::apiResource('specializables', SpecializableController::class);
    Route::get('specializables/by-specialty/{specialty_id}', [SpecializableController::class, 'getBySpeciality']);

    Route::extendedApiResource('user-roles', UserRoleController::class);



    Route::get('/users/search/{externalId}', [UserController::class, 'findByExternalId']);

    Route::post('user-roles/menus/permissions', [UserRoleController::class, 'storeWithMenusAndPermissions']);
    Route::put('user-roles/menus/permissions/{userRole}', [UserRoleController::class, 'updateWithMenusAndPermissions']);

    Route::post('admissions/new-store/{patientId}', [AdmissionController::class, 'newStore']);
    Route::get('admissions/by-appointment/{appointmentId}', [AdmissionController::class, 'getAdmissionsByAppointmentId']);

    Route::prefix('history-preadmissions')->group(function () {
        Route::get('/', [HistoryPreadmissionController::class, 'index']);
        Route::post('/', [HistoryPreadmissionController::class, 'store']);
        Route::get('{id}', [HistoryPreadmissionController::class, 'show']);
        Route::put('{id}', [HistoryPreadmissionController::class, 'update']);
        Route::delete('{id}', [HistoryPreadmissionController::class, 'destroy']);
        Route::get('last-history/{patientId}/{isLast}', [HistoryPreadmissionController::class, 'historyByPatient']);
    });

    //Route::post('/{type}', [ItemLookupController::class, 'showOrCreate']);

    Route::post('admissions/billing/report', [AdmissionController::class, 'billingReport']);
    Route::post('admissions/billing/report/by-entity', [AdmissionController::class, 'billingReportByEntity']);
    Route::post('admissions/billing/store-by-entity', [BillingController::class, 'storeInvoiceByEntity']);

    Route::apiResource('exam-recipes', ExamRecipeController::class);
    Route::get('exam-recipes/of-patient/{patient}', [ExamRecipeController::class, 'ofPatient']);
    Route::get('exam-recipes/pending/all', [ExamRecipeController::class, 'getPending']);
    Route::get('exam-recipes/pending/of-patient/{patient}', [ExamRecipeController::class, 'getPendingOfPatient']);
    Route::put('exam-recipes/change-status/{examRecipe}/{status}', [ExamRecipeController::class, 'changeStatus']);

    Route::extendedApiResource('exam-recipe-results', ExamRecipeResultController::class);


    Route::apiResource('social-security', SocialSecurityControllerV2::class);


    Route::apiResource('agents', AgentController::class);
    Route::apiResource('ai-responses', AiResponseController::class);

    Route::get('exam-recipes/last-by-patient/{patientId}', [ExamRecipeController::class, 'lastByPatient']);

    Route::extendedApiResource('users.absences', UserAbsenceController::class)->shallow();

    Route::get('admissions/last-patient-invoice/{patientId}', [AdmissionController::class, 'lastPatientInvoice'])->name('admissions.lastPatientInvoice');

    Route::apiResource('conversational-funnels', ConversationalFunnelController::class);

    Route::apiResource('recipe-item-optometries', RecipeItemOptometryController::class);

    Route::post('/patients/{patientId}/appointments/bulk', [AppointmentController::class, 'bulkStore']);

    Route::post('patients/{patientId}/appointments/validate-bulk', [AppointmentController::class, 'validateBulk']);

    Route::controller(ResponseAgentAIController::class)->group(function () {
        Route::get('resumen-historia-clinca/{id}', 'resumenHistoriaClinica');
        Route::get('post-consulta/{id}', 'postConsulta');
        Route::get('confirmacion-cita/{id}', 'confirmacionCita');
        Route::get('agent-comercial', 'agentComercial');
        Route::get('agent-report-financial', 'agentReportFinancial');
        // Si decides usar la ruta comentada, simplemente descoméntala:
        // Route::get('agente-educador/{id}', 'AgentEducador');
    });

    Route::apiResource('disabilities', DisabilityControllerV1::class);

    Route::apiResource('integrations', IntegrationControllerV1::class);
    Route::apiResource('integration-credentials', IntegrationCredentialControllerV1::class);
    Route::apiResource('integration-users', IntegrationUserControllerV1::class);

    Route::apiResource('surveys', SurveyControllerV1::class);

    Route::get('/test', function () {
        return response()->json([
            'message' => 'Funciona!',
            'tenant_id' => tenant('id'),
            'db_name' => config('database.connections.tenant.database'),
        ]);
    });

    Route::get('/debug', function () {
        return [
            'tenant_id' => tenant('id'),
            'db' => DB::connection()->getDatabaseName(),
        ];
    });

    Route::apiResource('copayment-rules', CopaymentRuleControllerV1::class);
    Route::apiResource('external-product-caches',ExternalProductCacheControllerV1::class);
});

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiHeaderMiddleware;
use App\Http\Middleware\ResolveTenantByPath;
use App\Http\Middleware\DetectTenantAndService;
use App\Http\Controllers\Api\V2\UserControllerV2;
use App\Http\Controllers\Api\V2\PatientControllerV2;
use App\Http\Controllers\Api\V2\AdmissionControllerV2;
use App\Http\Controllers\Api\V2\AppointmentControllerV2;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Api\V2\UserAssistantControllerV2;
use App\Http\Controllers\Api\V2\AdmissionPendingControllerV2;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::prefix('v2')->middleware([
    'api',
    DetectTenantAndService::class,
    //InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    ResolveTenantByPath::class,
])->group(function () {

    /* ------------------------------- PATIENTS ------------------------------- */
    Route::get('patients/{externalId?}', [PatientControllerV2::class, 'index']);
    Route::get('patients-clinical-records', [PatientControllerV2::class, 'getAllPatients']);
    Route::get('patients-with-appointments/{externalId?}', [PatientControllerV2::class, 'getPatientsWithAppointments']);

    /* ------------------------------- END PATIENTS ---------------------------- */

    /* ------------------------------- Admission ------------------------------- */

    Route::get('admissions-pending', [AdmissionPendingControllerV2::class, 'index']);

    /* ------------------------------- END Admission ---------------------------- */


    /* ------------------------------- Appointments ------------------------------- */
    Route::get('appointments/active/{externalId?}', [AppointmentControllerV2::class, 'index']);
    /* ------------------------------- END Appointments --------------------------- */


    /* ------------------------------- User Assistants ------------------------------- */

    Route::extendedApiResource('user-assistants', UserAssistantControllerV2::class);

    Route::get('users/{user}/assistants', [UserAssistantControllerV2::class, 'getAssistantsByUser']);

    /* ------------------------------- END User Assistants --------------------------- */

    Route::apiResource('users', UserControllerV2::class);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Api\V1\CupsController;
use App\Http\Controllers\Api\V1\ItemLookupController;

Route::prefix('create')->group(function () {
    Route::post('/tenant', [TenantController::class, 'createTenant']);
});

Route::post('/{type}', [ItemLookupController::class, 'showOrCreate']);

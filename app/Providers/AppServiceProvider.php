<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Models\Appointment;
use Laravel\Telescope\Telescope;
use App\Observers\TicketObserver;
use Illuminate\Support\Facades\Route;
use App\Observers\AppointmentObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        Schema::defaultStringLength(191);

        Ticket::observe(TicketObserver::class);

        Appointment::observe(AppointmentObserver::class);

        Relation::morphMap([
            'exam_category' => \App\Models\ExamCategory::class,
            'exam_type' => \App\Models\ExamType::class,
        ]);

        Relation::enforceMorphMap([
            'Historia Clínica' => \App\Models\ClinicalRecord::class
        ]);

        Route::macro('extendedApiResource', function ($name, $controller) {
            $base = $name;
            if (strpos($name, '.') !== false) {
                $parts = explode('.', $name);
                $base = end($parts);
            }

            Route::post("{$base}/bulk/store", [$controller, 'bulkStore'])
                ->name("{$base}.bulkStore");

            Route::get("{$base}/active/all", [$controller, 'active'])
                ->name("{$base}.active");

            Route::get("{$base}/active/count", [$controller, 'activeCount'])
                ->name("{$base}.activeCount");

            Route::post("{$base}/find-by/field", [$controller, 'findByField'])
                ->name("{$base}.findByField");

            return Route::apiResource($name, $controller);
        });

        Route::macro('manyToManyResource', function ($prefix, $controller) {
            $base = str_replace('-', '_', $prefix);

            Route::prefix($prefix)
                ->controller($controller)
                ->group(function () use ($base) {
                    Route::get('/{parentId}', 'index')->name("{$base}.index");
                    Route::post('/{parentId}', 'store')->name("{$base}.store");
                    Route::put('/{parentId}', 'update')->name("{$base}.update");
                    Route::delete('/{parentId}', 'destroy')->name("{$base}.destroy");
                });
        });


        Relation::morphMap(config('ai.responsable_types'));
    }
}

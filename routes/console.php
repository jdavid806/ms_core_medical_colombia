<?php

use App\Console\Commands\ReportFinancialByService;
use App\Console\Commands\SendChronicPatientsReminder;
use App\Console\Commands\SendHistoricalReportToWebhook;
use App\Console\Commands\SyncExternalProducts;
use Illuminate\Foundation\Inspiring;
use App\Jobs\CheckMissedAppointments;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new CheckMissedAppointments())->everyMinute();

Schedule::job(new SendChronicPatientsReminder())->daily();

Schedule::job(new SendHistoricalReportToWebhook())->weeklyOn(1, '6:00');

Schedule::job(new ReportFinancialByService())->monthlyOn(1, '6:00');

Schedule::job(new SyncExternalProducts())->daily();

<?php

namespace App\Http\Controllers;

use App\Models\AppointmentState;

class AppointmentStateController extends BasicController
{
    protected $service;
    protected $relations = [];

    public function index()
    {
        return AppointmentState::all();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponses;

    public function include(string $relationship) : bool
    {
        $param = request()->get('include');

        if(!isset($param)) {
            return false;
        }

        $includesValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includesValues);
    }
}

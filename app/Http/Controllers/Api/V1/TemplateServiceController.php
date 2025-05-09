<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\TemplateService;
use App\Http\Controllers\Controller;

class TemplateServiceController extends Controller
{
    public function __construct(private TemplateService $templateService){}

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            "type" => "required",
            "title" => "required|string",
            "description" => "required|string",
            "data" => "required",
            "tenant_id" => "required",
        ]);

        $template = $this->templateService->createTemplate($validatedData);

        return response()->json($template);
    }
}

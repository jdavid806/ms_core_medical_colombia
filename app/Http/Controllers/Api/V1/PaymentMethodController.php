<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Services\PaymentMethodService;

class PaymentMethodController extends Controller
{

    public function __construct(private PaymentMethodService $paymentMethodService) {}
    public function index()
    {
        return $this->paymentMethodService->getPaymentMethods();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodService->createPaymentMethod($request->validated());

        return response()->json([
            'message' => 'PaymentMethod created successfully',
            'PaymentMethod' => $paymentMethod,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

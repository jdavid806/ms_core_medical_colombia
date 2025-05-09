<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Services\AssetService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Asset\AssetResource;
use App\Http\Requests\Api\V1\Asset\StoreAssetRequest;
use App\Http\Requests\Api\V1\Asset\UpdateAssetRequest;
use App\Models\Company;

class AssetController extends Controller
{
    public function __construct(private AssetService $assetService) {}

    public function index()
    {
        $assets = $this->assetService->getAllAssets();
        return AssetResource::collection($assets);
    }

    public function store(Request $request)
    {

        $company = Company::find(1);
        //$asset = $this->assetService->createAsset($request->validated());
        if ($request->hasFile('watermark')) {
            // Eliminar marcas de agua existentes
            $company->assets()->where('type', 'watermark')->delete();
            
            // Guardar nueva marca de agua
            $watermarkPath = $request->file('watermark')->store('public/assets');
            $company->assets()->create([
                'type' => 'watermark',
                'path' => str_replace('public/', '', $watermarkPath),
            ]);
        }
        return response()->json([
            'message' => 'Asset created successfully',
            //'Asset' => $asset,
        ]);
    }

    public function show(Asset $asset)
    {
        return new AssetResource($asset);
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $this->assetService->updateAsset($asset, $request->validated());
        return response()->json([
            'message' => 'Asset updated successfully',
        ]);
    }

    public function destroy(Asset $asset)
    {
        $this->assetService->deleteAsset($asset);
        return response()->json([
            'message' => 'Asset deleted successfully',
        ]);
    }

    //
}

<?php

namespace App\Services;

use App\Models\Asset;
use App\Repositories\AssetRepository;

class AssetService
{
    public function __construct(private AssetRepository $assetRepository) {}

    public function getAllAssets()
    {
        return $this->assetRepository->all();
    }

    public function getAssetById(Asset $asset)
    {
        return $this->assetRepository->find($asset);
    }

    public function createAsset(array $data)
    {
        return $this->assetRepository->create($data);
    }

    public function updateAsset(Asset $asset, array $data)
    {
        return $this->assetRepository->update($asset, $data);
    }

    public function deleteAsset(Asset $asset)
    {
        return $this->assetRepository->delete($asset);
    }
}

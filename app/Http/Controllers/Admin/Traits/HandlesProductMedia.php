<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;
use App\Models\ProductSpecification;

trait HandlesProductMedia
{
    private function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    private function syncImages(\App\Models\Product $product, $files): void
    {
        if (!$files) {
            return;
        }

        $order = 1;
        foreach ($files as $file) {
            $filename = $this->uploadFile($file, 'products/gallery');
            $product->images()->create([
                'image' => $filename,
                'order' => $order++,
            ]);
        }
    }

    private function syncSpecifications(\App\Models\Product $product, array $specs): void
    {
        $order = 1;
        foreach ($specs as $spec) {
            if (empty($spec['key']) && empty($spec['value'])) {
                continue;
            }
            $product->specifications()->create([
                'key' => $spec['key'] ?? '',
                'value' => $spec['value'] ?? '',
                'order' => $order++,
            ]);
        }
    }
}

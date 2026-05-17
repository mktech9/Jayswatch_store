<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;

class ProductApiController extends Controller
{
    public function homeproducts()
    {
        $products = ProductModel::with('brandInfo')
            ->where('status', 0)
            ->get();

        $response = $products->map(function ($p) {

            $brandName = $p->brandInfo->brand_name ?? '';
            $productName = $p->pro_name ?? '';

            // Convert spaces & special chars to "_"
            $brandFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $brandName);
            $productFolder = preg_replace('/[^A-Za-z0-9\-]/', '_', $productName);

            $imageUrl = asset(
                'assets/admin_assets/brand/'.
                $brandFolder.'/'.
                $productFolder.'/image/'.
                $p->pro_image
            );

            return [
                'pro_name' => $p->pro_name,
                'pro_sku' => $p->pro_sku,
                'slug' => $p->slug,
                'brand' => $brandName,
                'selling_price_exclusive' => $p->selling_price_exclusive,
                'pro_image' => $imageUrl,
            ];
        });

        return response()->json($response);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductSearchRequest;
use App\Http\Requests\Product\ProductShowRequest;
use App\Interfaces\Services\ProductServiceInterface;

class ProductCotroller extends Controller
{
    public function __construct(
        private ProductServiceInterface $productService
    ){}

    public function show(ProductShowRequest $request)
    {
        // Get id from uri
        $id = $request->route('id');

        // Find requested product by id
        $product = $this->productService->findById($id);

        // Show product and return 404 status code if requested product does not exist
        return response()->json([
            "product" => $product
        ] , $product ? 200 : 404);
    }

    public function search(ProductSearchRequest $request)
    {
        $products = $this->productService->search(
            title: $request->title , 
            description: $request->description ,
            priceRange: ["min" => $request->min_price , "max" => $request->max_price] ,
            category: $request->category ,
            part: $request->part ,
            orderBy: "id" ,
            limit: $request->limit
        );

        return response()->json([
            "status" => true ,
            "data" => $products
        ]);
    }
}

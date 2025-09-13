<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AdminProductEditRequest;
use App\Http\Requests\Admin\Product\AdminProductRemoveRequest;
use App\Http\Requests\Admin\Product\AdminProductStoreRequest;
use App\Interfaces\Services\ProductServiceInterface;
use App\Interfaces\Services\UserServiceInterface;

class AdminProductCotroller extends Controller
{
    public function __construct(
        private ProductServiceInterface $productService ,
        private UserServiceInterface $userService
    ){}

    public function store(AdminProductStoreRequest $request)
    {
        // Fetch user id from jwt
        $userID = $this->userService->getUserId();

        // Store a product 
        $product = $this->productService->createOne($request->validated() , $userID , true);

        // Send success message
        return response()->json([
            "status" => true ,
            "message" => "Product added successfully" ,
            "product" => $product
        ]);
    }

    public function edit(AdminProductEditRequest $request)
    {
        // Edit product 
        $updatedProduct = $this->productService->updateOne(
            $request->validated() , 
            $request->route('id')
        );

        // 
        return response()->json([
            "status" => true ,
            "message" => "$updatedProduct product(s) updated"
        ]);
    }

    public function remove(AdminProductRemoveRequest $request)
    {
        $deletedProduct = $this->productService->deleteOne($request->route('id'));

        return response()->json([
            "status" => true ,
            "message" => "$deletedProduct product(s) deleted"
        ]);
    }
}

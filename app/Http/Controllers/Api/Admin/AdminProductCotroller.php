<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AdminProductDeleteRequest;
use App\Http\Requests\Admin\Product\AdminProductStoreRequest;
use App\Http\Requests\Admin\Product\AdminProductUpdateRequest;
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
            "success" => true ,
            "message" => "Product added successfully" ,
            "product" => $product
        ] , 202);
    }

    public function update(AdminProductUpdateRequest $request)
    {
        // update product 
        $updatedProduct = $this->productService->updateOne(
            $request->validated() , 
            $request->route('id')
        );

        // success response
        return response()->json([
            "success" => true ,
            "message" => "$updatedProduct product(s) updated"
        ] , 201);
    }

    public function delete(AdminProductDeleteRequest $request)
    {
        // Delete the product and find how many products has been deleted
        $deletedProduct = $this->productService->deleteOne($request->route('id'));

        return response()->json([
            "success" => true ,
            "message" => "$deletedProduct product(s) deleted"
        ] , 201);
    }
}

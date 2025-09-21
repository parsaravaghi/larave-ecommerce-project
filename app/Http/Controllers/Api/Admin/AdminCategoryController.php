<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\AdminCategoryDeleteRequest;
use App\Http\Requests\Admin\Category\AdminCategoryStoreRequest;
use App\Http\Requests\Admin\Category\AdminCategoryUpdateRequest;
use App\Interfaces\Services\CategoryServiceInterface;

class AdminCategoryController extends Controller
{
    public function __construct(
        private CategoryServiceInterface $categoryService
    ) {}

    public function store(AdminCategoryStoreRequest $request)
    {
        // store validated data
        $category = $this->categoryService->createOne($request->validated());

        return response()->json([
            "success" => true ,
            "data" => $category
        ] , 202);
    }

    public function update(AdminCategoryUpdateRequest $request)
    {
        // Update category by admin data
        $updatedCategory = $this->categoryService->updateOne(
            userData: $request->validated() ,
            id: $request->route('id')
        );

        // success message
        return response()->json([
            "success" => true ,
            "message" => "$updatedCategory category(s) updated" ,
            "errors" => null
        ]);
    }

    public function delete(AdminCategoryDeleteRequest $request)
    {
        $deletedCategory = $this->categoryService->deleteOne($request->route('id'));

        return response()->json([
            "success" => true ,
            "message" => "$deletedCategory category(s) deleted" ,
            "errors" => null
        ]);
    }
}

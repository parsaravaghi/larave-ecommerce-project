<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategorySearchRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryServiceInterface $categoryService
    ) {}

    public function show(Request $request)
    {
        // Get id from route and convert its datatype to integer
        $id = (int) $request->route('id');

        // Return not found if requested category would be null
        if(!$category = $this->categoryService->findById($id))
            abort(404);

        // Success message
        return response()->json([
            "success" => true ,
            "data" => $category
        ]);
    }

    public function search(CategorySearchRequest $request)
    {
        // Search requested categories
        $categories = $this->categoryService->search(
            name: $request->name ,
            limit: $request->limit ,
            part: $request->part
        );

        // Success message
        return response()->json([
            "data" => $categories 
        ]);
    }

    public function showParentIDs(Request $request)
    {
        $id = (int) $request->route('id');

        $categories = $this->categoryService->getParents($id);

        return response()->json([
            "data" => $categories
        ]);
    }
}

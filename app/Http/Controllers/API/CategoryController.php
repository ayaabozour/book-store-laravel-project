<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Throwable;

class CategoryController extends Controller{
    use ApiResponse;

    public function __construct(protected CategoryService $categoryService){}

    public function index(Request $request){
        try{
            $perPage = $request->query('per_page',10);

        $categories = $this->categoryService->paginate($perPage);

        return $this->success(
            CategoryResource::collection($categories),
            'Categories fetched successfully'
        );
    }catch(Throwable $e){
        report($e);

        return $this->error(
            'Failed to fetch categories',
            config('app.debug') ? $e->getMessage() : null,
            500
        );
    }

    }

    public function store(CategoryRequest $request){
        try{
            $category = $this->categoryService->create($request->validated());

            return $this->success(
            new CategoryResource($category),
            'Category created successfully',
            201
            );
        }catch(Throwable $e){
            report($e);
            return $this->error(
                'Failed to create category',
                config('app.debug') ? $e->getMessage() : null,
                500
            );
        }

    }
}

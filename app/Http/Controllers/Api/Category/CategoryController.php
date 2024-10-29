<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = Category::query()->create($data);

        return response(status: 201)->json(['id' => $category->id,'title'=> $category->title]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response(status: 200)->json(['id' => $category->id,'title'=> $category->title]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->update($data);

        return response(status: 200)->json(['id' => $category->id,'title'=> $category->title]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(status: 204);
    }
}

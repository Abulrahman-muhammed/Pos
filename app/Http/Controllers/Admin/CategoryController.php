<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Enums\CategoryStatusEnum;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Storage;
use App\Enums\CategoryImageUsageEnum;

class CategoryController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryStatuses = CategoryStatusEnum::labels();
        return view('admin.categories.create', compact('categoryStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $category = Category::create($data);
    
        // =============== image uploading ====================
        if ($request->hasFile('image')) {
            $uploaded = $this->uploadImage($request->file('image'), 'categories');
    
            $category->photo()->create([
                'usage' => CategoryImageUsageEnum::USAGE->value,
                'path'  => $uploaded['path'],
                'ext'   => $request->file('image')->getClientOriginalExtension(),
            ]);
        }
    
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully .');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=Category::findOrFail($id);
        $categoryStatuses = CategoryStatusEnum::labels();
        return view('admin.categories.edit', compact('category','categoryStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        // dd($request->all());
        $category = Category::findOrFail($id);        
        $category->update($request->validated());
        
        // =============== image uploading ====================
        if ($request->hasFile('image')) {
            $uploaded = $this->uploadImage($request->file('image'), 'categories');
        
            if ($category->photo && $category->photo->path) {
                Storage::disk('public')->delete($category->photo->path);
            }
        
            $category->photo()->create(
                [
                    'path' => $uploaded['path'],
                    'usage' => CategoryImageUsageEnum::USAGE->value,
                    'ext'  => $request->file('image')->getClientOriginalExtension(),
                ]
            );
        }
    
        return redirect()->route('admin.categories.index')->with('success', 'Category Updated successfully .');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->items()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete category because it has items linked to it.'
            ], 400);
        }


        if ($category->photo && $category->photo->path) {
            // Delete Photo From Storage
            Storage::disk('public')->delete($category->photo->path);
    
            // Delete image from table
            $category->photo()->delete();
        }
    
        $category->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ]);
    }
}

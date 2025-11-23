<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Enums\CategoryStatusEnum;
use Illuminate\Support\Facades\Storage;
use App\Enums\CategoryImageUsageEnum;
use App\Services\UploadimageService;
class CategoryController extends Controller
{
    protected $uploader;
    public function __construct(UploadimageService $uploader)
    {
        $this->uploader = $uploader;
    }
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
            $file = $this->uploader->uploadImage(
                $request->file('image'),
                'categories',
                CategoryImageUsageEnum::USAGE->value
            );
            $category->photo()->create($file);
        }
    
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully .');
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
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        if ($request->hasFile('image')) {

            // old image delete
            if ($category->photo && $category->photo->path) {
                $this->uploader->delete($category->photo->path);
                $category->photo()->delete();
            }

            // new
            $file = $this->uploader->uploadImage(
                $request->file('image'),
                'categories',
                CategoryImageUsageEnum::USAGE->value
            );

            $category->photo()->create($file);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
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

        // Delete image
        if ($category->photo && $category->photo->path) {
            $this->uploader->delete($category->photo->path);
            $category->photo()->delete();
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ]);
    }
}

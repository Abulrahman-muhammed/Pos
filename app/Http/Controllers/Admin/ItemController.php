<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Enums\ItemStatusEnum;
use App\Enums\CategoryStatusEnum;
use App\Enums\UnitStatusEnum;

use App\Http\Requests\Admin\ItemStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ItemUpdateRequest;
use App\Enums\ItemImageUsageEnum;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::paginate();
        return view('admin.items.index',compact('items'));    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status',ItemStatusEnum::Active->value)->get();
        $units = Unit::where('status',UnitStatusEnum::Active->value)->get();
        $itemStatus = ItemStatusEnum::labels();

        return view('admin.items.create',compact('categories','units','itemStatus'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request)
    {
        // dd( $request->validated());
        $item = Item::create($request->validated());

        if($request->hasFile('main_image')){
            $newImageName = time() . uniqid() . '.' . $request->file('main_image')->getClientOriginalExtension();
            $path = $request->file('main_image')->storeAs('items', $newImageName, 'public');
            $item->mainPhoto()->create([
                'path' => $path,
                'usage' => ItemImageUsageEnum::MAIN->value,
                'ext'=> $request->file('main_image')->getClientOriginalExtension()
            ]);
        }
        if($request->hasFile('gallery')){
            $galleryFiles = $request->file('gallery');
            foreach($galleryFiles as $image){
                $newImageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('items', $newImageName, 'public');
                $item->gallery()->create([
                    'path' => $path,
                    'usage' => ItemImageUsageEnum::GALLERY->value,
                    'ext'=> $image->getClientOriginalExtension()                
            ]);
            }
        }
        return redirect()->route('admin.items.index')->with('success','Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with(['mainPhoto','gallery','category','unit'])->findOrFail($id);
        return view('admin.items.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::with(['mainPhoto','gallery'])->findOrFail($id);
        $categories = Category::where('status',ItemStatusEnum::Active->value)->get();
        $units = Unit::where('status',UnitStatusEnum::Active->value)->get();
        $itemStatus = ItemStatusEnum::labels();

        return view('admin.items.edit',compact('item','categories','units','itemStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemUpdateRequest $request, string $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->validated());

        if($request->hasFile('main_image')){
            // Delete old main image if exists
            if ($item->mainPhoto) {
                Storage::disk('public')->delete($item->mainPhoto->path);
                $item->mainPhoto()->delete();
            }
            $newImageName = time() . uniqid() . '.' . $request->file('main_image')->getClientOriginalExtension();
            $path = $request->file('main_image')->storeAs('items', $newImageName, 'public');
            $item->mainPhoto()->create([
                'path' => $path,
                'usage' => ItemImageUsageEnum::MAIN->value,
                'ext'=> $request->file('main_image')->getClientOriginalExtension()
            ]);
        }
        if($request->hasFile('gallery')){
            $galleryFiles = $request->file('gallery');
            foreach($galleryFiles as $image){
                $newImageName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('items', $newImageName, 'public');
                $item->gallery()->create([
                    'path' => $path,
                    'usage' => ItemImageUsageEnum::GALLERY->value,
                    'ext'=> $image->getClientOriginalExtension()                
            ]);
            }
        }
        if ($request->filled('delete_gallery')) {
            $imagesToDelete = $item->gallery()->whereIn('id', $request->input('delete_gallery'))->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }
        return redirect()->route('admin.items.index')->with('success','Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);

        if ($item->mainPhoto) {
            Storage::disk('public')->delete($item->mainPhoto->path);
            $item->mainPhoto()->delete();
        }

        if ($item->gallery && $item->gallery->count() > 0) {
            foreach ($item->gallery as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item deleted successfully.'
        ]);
        }
}

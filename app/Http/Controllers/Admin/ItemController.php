<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Enums\ItemStatusEnum;
use App\Enums\UnitStatusEnum;
use App\Enums\WarehouseStatusEnum;

use App\Http\Requests\Admin\ItemStoreRequest;
use App\Http\Requests\Admin\ItemUpdateRequest;

use App\Enums\ItemImageUsageEnum;

use App\Services\StockMangmentService;
use App\Services\UploadimageService;

use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    protected $uploader;

    public function __construct(UploadimageService $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $items = Item::paginate();
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::where('status', ItemStatusEnum::Active->value)->get();
        $units = Unit::where('status', UnitStatusEnum::Active->value)->get();
        $warehouses = Warehouse::where('status', WarehouseStatusEnum::Active->value)->get();
        $itemStatus = ItemStatusEnum::labels();

        return view('admin.items.create', get_defined_vars());
    }

    public function store(ItemStoreRequest $request)
    {
        DB::beginTransaction();

        $item = Item::create($request->validated());

        // MAIN IMAGE
        if ($request->hasFile('main_image')) {
            $file = $this->uploader->uploadImage(
                $request->file('main_image'),
                'items',
                ItemImageUsageEnum::MAIN->value
            );

            $item->mainPhoto()->create($file);
        }

        // GALLERY
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $file = $this->uploader->uploadImage(
                    $image,
                    'items',
                    ItemImageUsageEnum::GALLERY->value
                );

                $item->gallery()->create($file);
            }
        }

        // STOCK
        (new StockMangmentService())->initStock(
            $item,
            $request->warehouse_id,
            $request->quantity
        );

        DB::commit();

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(string $id)
    {
        $item = Item::with(['mainPhoto','gallery','category','unit'])->findOrFail($id);
        return view('admin.items.show', compact('item'));
    }

    public function edit(string $id)
    {
        $item = Item::with(['mainPhoto','gallery'])->findOrFail($id);
        $categories = Category::where('status', ItemStatusEnum::Active->value)->get();
        $units = Unit::where('status', UnitStatusEnum::Active->value)->get();
        $itemStatus = ItemStatusEnum::labels();

        return view('admin.items.edit', compact('item','categories','units','itemStatus'));
    }

    public function update(ItemUpdateRequest $request, string $id)
    {
        $item = Item::findOrFail($id);

        $item->update($request->validated());

        // MAIN IMAGE
        if ($request->hasFile('main_image')) {

            if ($item->mainPhoto) {
                $this->uploader->delete($item->mainPhoto->path);
                $item->mainPhoto()->delete();
            }

            $file = $this->uploader->uploadImage(
                $request->file('main_image'),
                'items',
                ItemImageUsageEnum::MAIN->value
            );

            $item->mainPhoto()->create($file);
        }

        // GALLERY
        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $file = $this->uploader->uploadImage(
                    $image,
                    'items',
                    ItemImageUsageEnum::GALLERY->value
                );

                $item->gallery()->create($file);
            }
        }

        // DELETE SELECTED GALLERY IMAGES
        if ($request->filled('delete_gallery')) {

            $imagesToDelete = $item->gallery()->whereIn('id', $request->delete_gallery)->get();

            foreach ($imagesToDelete as $img) {
                $this->uploader->delete($img->path);
                $img->delete();
            }
        }

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);

        if ($item->sales()->count() > 0 || 
            $item->returns()->count() > 0 
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete item with associated sales.'
            ], 400);
        }

        // DELETE MAIN IMAGE
        if ($item->mainPhoto) {
            $this->uploader->delete($item->mainPhoto->path);
            $item->mainPhoto()->delete();
        }
        // DELETE GALLERY
        foreach ($item->gallery as $img) {
            $this->uploader->delete($img->path);
            $img->delete();
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item deleted successfully.'
        ]);
    }
}

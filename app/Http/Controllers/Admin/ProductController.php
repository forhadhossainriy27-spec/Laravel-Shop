<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        $query->when($request->search, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('sku', 'like', "%{$request->search}%");
            });
        });

        $query->when($request->category, fn($q) => $q->where('category_id', $request->category));

        $query->when($request->brand, fn($q) => $q->where('brand_id', $request->brand));

        $query->when(
            $request->status !== null && $request->status !== '',
            fn($q) => $q->where('status', $request->status)
        );

        $query->when(
            $request->featured !== null && $request->featured !== '',
            fn($q) => $q->where('featured', $request->featured)
        );

        $query->when($request->stock == 'low', fn($q) => $q->where('stock', '<=', 5));

        $query->when($request->stock == 'out', fn($q) => $q->where('stock', 0));

        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name');
                break;

            case 'name_desc':
                $query->orderByDesc('name');
                break;

            case 'price_low':
                $query->orderBy('price');
                break;

            case 'price_high':
                $query->orderByDesc('price');
                break;

            case 'stock':
                $query->orderBy('stock');
                break;

            case 'oldest':
                $query->oldest();
                break;

            default:
                $query->latest();
        }

        $products = $query
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'brands'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact(
            'categories',
            'brands'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productService->store($request);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
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
    public function edit(Product $product)
    {
        $product->load('images');

        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.products.edit',
            compact('product', 'categories', 'brands')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productService->update($request, $product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroyGallery(ProductImage $image)
    {
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return back()->with('success', 'Product moved to trash.');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()
            ->with(['category', 'brand'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('admin.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $this->productService->restore($id);

        return back()->with('success', 'Product restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->productService->forceDelete($id);

        return back()->with('success', 'Product permanently deleted.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'action' => ['required'],
        ]);

        $products = Product::whereIn('id', $request->ids);

        switch ($request->action) {

            case 'delete':
                $products->delete();
                $message = 'Products deleted successfully.';
                break;

            case 'active':
                $products->update([
                    'status' => true
                ]);
                $message = 'Products activated.';
                break;

            case 'inactive':
                $products->update([
                    'status' => false
                ]);
                $message = 'Products deactivated.';
                break;

            default:
                return back()->with('error', 'Invalid action.');
        }

        return back()->with('success', $message);
    }
    public function duplicate(Product $product)
    {
        $this->productService->duplicate($product);

        return back()->with(
            'success',
            'Product duplicated successfully.'
        );
    }
}

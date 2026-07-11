<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ProductActivity;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function store(Request $request): Product
    {
        return DB::transaction(function () use ($request) {

            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']);

            $data['status'] = $request->boolean('status');
            $data['featured'] = $request->boolean('featured');

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')
                    ->store('products', 'public');
            }

            $product = Product::create($data);

            $product->update([
                'sku' => 'SKU-' . str_pad(
                    $product->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);

            if ($request->hasFile('gallery')) {

                foreach ($request->file('gallery') as $image) {

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $image->store('products/gallery', 'public'),
                    ]);
                }
            }

            $this->log(
                $product,
                'created',
                'Product created'
            );

            return $product;
        });
    }

    public function update(ProductRequest $request, Product $product): Product
    {
        return DB::transaction(function () use ($request, $product) {

            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']);

            $data['status'] = $request->boolean('status');
            $data['featured'] = $request->boolean('featured');

            if ($request->hasFile('thumbnail')) {

                if (
                    $product->thumbnail &&
                    Storage::disk('public')->exists($product->thumbnail)
                ) {

                    Storage::disk('public')->delete($product->thumbnail);
                }

                $data['thumbnail'] = $request
                    ->file('thumbnail')
                    ->store('products', 'public');
            }

            $product->update($data);

            if ($request->hasFile('gallery')) {

                foreach ($request->file('gallery') as $image) {

                    $product->images()->create([
                        'image' => $image->store(
                            'products/gallery',
                            'public'
                        ),
                    ]);
                }
            }

            $this->log(
                $product,
                'updated',
                'Product updated'
            );
            return $product;
        });
    }

    public function delete(Product $product): void
    {
        $product->delete();
        $this->log(
            $product,
            'deleted',
            'Product moved to trash'
        );
    }

    public function forceDelete($id): void
    {
        $product = Product::onlyTrashed()
            ->with('images')
            ->findOrFail($id);

        if (
            $product->thumbnail &&
            Storage::disk('public')->exists($product->thumbnail)
        ) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        foreach ($product->images as $image) {

            if (
                $image->image &&
                Storage::disk('public')->exists($image->image)
            ) {
                Storage::disk('public')->delete($image->image);
            }

            $image->forceDelete();
        }

        $product->forceDelete();
    }

    public function restore($id): void
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $product->restore();

        $this->log(
            $product,
            'restored',
            'Product restored'
        );
    }

    public function duplicate(Product $product): Product
    {
        return DB::transaction(function () use ($product) {

            $new = $product->replicate();

            $new->name = $product->name . ' Copy';

            $new->slug = Str::slug($new->name . '-' . Str::random(5));

            $new->sku = 'SKU-' . strtoupper(Str::random(8));

            $new->status = 0;

            $new->stock = 0;

            if ($product->thumbnail) {

                $old = storage_path('app/public/' . $product->thumbnail);

                if (file_exists($old)) {

                    $newPath = 'products/' . uniqid() . '.' . pathinfo($old, PATHINFO_EXTENSION);

                    Storage::disk('public')->put(
                        $newPath,
                        file_get_contents($old)
                    );

                    $new->thumbnail = $newPath;
                }
            }

            $new->save();

            foreach ($product->images as $image) {

                $old = storage_path('app/public/' . $image->image);

                if (file_exists($old)) {

                    $newPath = 'products/gallery/' . uniqid() . '.' . pathinfo($old, PATHINFO_EXTENSION);

                    Storage::disk('public')->put(
                        $newPath,
                        file_get_contents($old)
                    );

                    $new->images()->create([
                        'image' => $newPath
                    ]);
                }
            }

            $this->log(
                $new,
                'duplicated',
                'Duplicated from Product #' . $product->id
            );
            return $new;
        });
    }

    private function log(Product $product, string $action, string $description = null)
    {
        ProductActivity::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}

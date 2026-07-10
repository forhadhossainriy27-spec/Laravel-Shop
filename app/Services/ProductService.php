<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

            return $product;
        });
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function forceDelete(Product $product): void
    {
        DB::transaction(function () use ($product) {

            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            foreach ($product->images as $image) {

                Storage::disk('public')->delete($image->image);

                $image->delete();
            }

            $product->forceDelete();
        });
    }
}

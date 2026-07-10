<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')
                ->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('logo')) {

            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand moved to trash.');
    }

    public function trash()
    {
        $brands = Brand::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.brands.trash', compact('brands'));
    }

    public function restore($id)
    {
        Brand::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('admin.brands.trash')
            ->with('success', 'Brand restored successfully.');
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->forceDelete();

        return redirect()
            ->route('admin.brands.trash')
            ->with('success', 'Brand permanently deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
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
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

public function destroy(Category $category)
{
    $category->delete();

    return redirect()
        ->route('admin.categories.index')
        ->with('success','Category deleted successfully.');
}

    public function trash()
    {
        $categories = Category::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        Category::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->forceDelete();

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category permanently deleted.');
    }
}

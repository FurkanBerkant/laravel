<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $categories = Category::orderBy('order')
            ->orderBy('name')
            ->paginate(20);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ] ,
        [
            'name.required' => 'Kategori adı zorunludur',
            'name.unique' => 'Bu kategori adı zaten kullanılıyor',
            'image.image' => 'Dosya bir resim olmalıdır',
            'image.max' => 'Resim maksimum 2MB olabilir',
        ]);
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
        }
        Category::create($validated);
        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) : View
    {
        $category->load('products');
        return view('categories.show', compact('category'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) : View
    {
        return view('categories.edit', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ], [
            'name.required' => 'Kategori adı zorunludur',
            'name.unique' => 'Bu kategori adı zaten kullanılıyor',
            'image.image' => 'Dosya bir resim olmalıdır',
            'image.max' => 'Resim maksimum 2MB olabilir',
        ]);
        if($request-> hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
        }

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if($category -> image) {
            Storage::disk('public') -> delete($category -> image);
        }

        $category -> delete();

        return redirect()->route('categories.index')->with('success', 'Kategori basariyla silindi.');
    }
}

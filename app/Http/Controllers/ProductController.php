<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->has('category_id') && request()->category_id != '' ) {
            $query->where('category_id', request()->category_id);
        }
        if($request-> has('search')){
            $query->where(function ($q) use ($request){
                $q-> where ('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('sku', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('description', 'like', '%' . $request->get('search') . '%');
            });
        }

        if($request->has('status')){
            $query->where('is_active' , $request->get('status'));
        }

        if($request->has('stock_status')){
            $query->where('stock_status' , $request ->get('stock_status'));
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(20)->appends($request->all());

        $categories = Category::active() -> orderBy('name') -> get();
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::active() -> orderBy('name') -> get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'track_stock' => 'boolean',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_backorder',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ], [
            'category_id.required' => 'Kategori seçimi zorunludur',
            'category_id.exists' => 'Geçersiz kategori',
            'name.required' => 'Ürün adı zorunludur',
            'price.required' => 'Fiyat zorunludur',
            'price.min' => 'Fiyat 0\'dan küçük olamaz',
            'stock.required' => 'Stok miktarı zorunludur',
        ]);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')
                ->store('products/main', 'public');
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products/gallery', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $product = Product::create($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Ürün başarıyla oluşturuldu!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load('category');

        $product->incrementViewCount();

        return view('products.show', compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'track_stock' => 'boolean',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_backorder',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Ana resim güncelle
        if ($request->hasFile('main_image')) {
            // Eski resmi sil
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $validated['main_image'] = $request->file('main_image')
                ->store('products/main', 'public');
        }

        // Ek resimleri güncelle
        if ($request->hasFile('images')) {
            // Eski resimleri sil
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products/gallery', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        // Güncelle
        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Ürün başarıyla güncellendi!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Soft delete
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Ürün başarıyla silindi!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/ProductController.php

    public function index(Request $request): View
    {
        $products = Product::query();
        $products->when($request->category_id, function ($query, $category_id) {
            $query->where('category_id', $category_id);
        });

        $products->when($request->search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('sku', 'LIKE', '%' . $search . '%');
        });

        $products->when($request->filled('status'), function ($query) use ($request) {
            $query->where('is_active', $request->get('status'));
        });

        $products->when($request->filled('stock_status'), function ($query) use ($request) {
            $query->where('stock_status', $request->get('stock_status'));
        });

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $products->orderBy($sortBy, $sortOrder);

        $products = $products->paginate(20)->appends($request->all());

        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::all();
        return view('products.index', compact('products', 'categories','brands'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::active() -> orderBy('name') -> get();
        $brands = Brand::all();
        return view('products.create', compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
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
            'brand_id.required' => 'Marka seçimi zorunludur',
            'brand_id.exists' => 'Geçersiz marka',
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
    public function edit(Product $product): View
    {
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::all();
        return view('products.edit', compact('product', 'categories','brands'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
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

        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $validated['main_image'] = $request->file('main_image')
                ->store('products/main', 'public');
        }

        if ($request->hasFile('images')) {
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

        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Ürün başarıyla güncellendi!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Ürün başarıyla silindi!');
    }
}

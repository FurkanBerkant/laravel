<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $brands = Brand::all();
        return response()->json([
            'success' => true,
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request-> validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $brand = Brand::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Marka oluşturuldu',
            'data' => $brand
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(brand $brand): JsonResponse
    {

        $brand -> load('products');

        return response()->json([
            'success'=> true,
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, brand $brand): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $brand->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Marka güncellendi',
            'data' => $brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(brand $brand): JsonResponse
    {
        $brand->delete();
        return response()->json([
            'success' => true,
            'message' => 'Marka silindi'
        ]);    }
}

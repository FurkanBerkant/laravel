<?php

namespace App\Http\Controllers;

use App\Models\brand;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View | Factory
    {
        $brands = brand::orderBy('name')->paginate(20);
        return view('brands.index', compact('brands'));
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
    public function store(Request $request): array
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(brand $brand): brand
    {
        return $brand;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(brand $brand): brand
    {
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, brand $brand): array
    {
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(brand $brand): brand
    {
        return $brand;
    }
}

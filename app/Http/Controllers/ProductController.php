<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            "status" => "success",
            "products" => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $category = Category::firstWhere('name', $request->category);

        $product = $category->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ])->user()->associate($request->user());

        return response()->json([
            "status" => "success",
            "message" => "Product created successfully",
            "Product" => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            "status" => "success",
            "product" => $product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if($request->category) {
            $category = Category::firstWhere('name', $request->category);

            $product->category()->associate($category);
        }
        
        $product->update($request->all());
    
        
        return response()->json([
            "status" => "success",
            "message" => "Product updated successfully",
            "Product" => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(auth()->user()->can('update all products') || (auth()->user()->can('update own products') && $product->user()->is(auth()->user()))) {
            
            $product->delete();
    
            return response()->json([
                "status" => "success",
                "message" => "Product deleted successfully"], 200);
            }
            else return response()->json([
                "status" => "error",
                "message" => "You are not authorized to delete this product"], 403);

    }
}

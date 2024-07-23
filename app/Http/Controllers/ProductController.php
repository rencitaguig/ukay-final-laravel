<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::paginate(10); // Adjust per-page limit to 10
            return response()->json([
                'html' => view('products.partials.products', compact('products'))->render(),
                'next_page' => $products->nextPageUrl(),
            ]);
        }
    
        $products = Product::paginate(10); // Adjust per-page limit to 10
        return view('products.index', compact('products'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'size' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'stock' => 'required|integer',
            'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->size = $request->size;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->stock = $request->stock;
        $product->image = ''; // Provide a default value

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $product->image .= 'storage/images/' . $fileName . ',';
            }
            $product->image = rtrim($product->image, ',');
        }

        $product->save();

        return response()->json(["success" => "Product created successfully.", "product" => $product, "status" => 200]);
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'size' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'stock' => 'required|integer',
            'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product->name = $request->name;
        $product->size = $request->size;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->stock = $request->stock;

        if ($request->hasFile('uploads')) {
            $imagePaths = [];
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $imagePaths[] = 'storage/images/' . $fileName;
            }
            $product->image = implode(',', $imagePaths);
        }

        $product->save();

        return response()->json(["success" => "Product updated successfully.", "product" => $product, "status" => 200]);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(["success" => "Product deleted successfully.", "status" => 200]);
    }

    public function import (Request $request)
    {
      $request ->validate([
          'importFile' => ['required', 'file', 'mimes:xlsx,xls']
      ]);
 
      Excel::import(new ProductsImport, $request->file('importFile'));
 
      return redirect()->back()->with('success', 'Products imported successfully');
    }
}

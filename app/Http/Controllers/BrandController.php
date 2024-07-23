<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BrandsImport;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return response()->json($brands);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'company' => 'required',
            'website' => 'required|url',
            'description' => 'required',
            'status' => 'required',
            'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->company = $request->company;
        $brand->website = $request->website;
        $brand->description = $request->description;
        $brand->logo = ''; // Provide a default value
        $brand->status = $request->status;

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $brand->logo .= 'storage/images/' . $fileName . ',';
            }
            $brand->logo = rtrim($brand->logo, ',');
        }

        $brand->save();

        return response()->json(["success" => "Brand created successfully.", "brand" => $brand, "status" => 200]);
    }

    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'company' => 'required',
            'website' => 'required|url',
            'description' => 'required',
            'status' => 'required',
            'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $brand->name = $request->name;
        $brand->company = $request->company;
        $brand->website = $request->website;
        $brand->description = $request->description;
        $brand->status = $request->status;

        if ($request->hasFile('uploads')) {
            $imagePaths = [];
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $imagePaths[] = 'storage/images/' . $fileName;
            }
            $brand->logo = implode(',', $imagePaths);
        }

        $brand->save();

        return response()->json(["success" => "Brand updated successfully.", "brand" => $brand, "status" => 200]);
    }

    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(["success" => "Brand deleted successfully.", "status" => 200]);
    }

    public function import (Request $request)
    {
      $request ->validate([
          'importFile' => ['required', 'file', 'mimes:xlsx,xls']
      ]);
 
      Excel::import(new BrandsImport, $request->file('importFile'));
 
      return redirect()->back()->with('success', 'Brand imported successfully');
    }
}

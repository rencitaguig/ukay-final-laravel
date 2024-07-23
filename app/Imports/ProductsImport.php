<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Product::create([
                'name' => $row['name'],
                'size' => $row['size'],
                'description' => $row['description'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'image' => $row['image'],
                'category_id' => $row['category_id'],
                'brand_id' => $row['brand_id'],
                'stock' => $row['stock'],
            ]);
        }
    }
}

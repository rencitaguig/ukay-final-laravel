<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductBrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productBrands = [];
        for ($i = 1; $i <= 30; $i++) {
            $productBrands[] = [
                'product_id' => $i, // Assuming product IDs from 1 to 30
                'brand_id' => $i,   // Assuming brand IDs from 1 to 30
            ];
        }

        DB::table('product_brands')->insert($productBrands);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [];
        for ($i = 1; $i <= 30; $i++) {
            $brands[] = [
                'name' => 'Brand ' . $i,
                'company' => 'Company ' . $i,
                'website' => 'https://www.company' . $i . '.com',
                'description' => 'This is the description for Brand ' . $i,
                'logo' => 'logos/brand' . $i . '.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('brands')->insert($brands);
    }
}

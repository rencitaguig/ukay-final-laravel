<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class BrandsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
       {
           foreach ($rows as $row)
           {
            Brand::create([
                'name'        => $row['name'],
                'company'     => $row['company'],
                'website'     => $row['website'],
                'description' => $row['description'],
                'logo'        => $row['logo'],
                'status'      => $row['status'],
            ]);
   
           }
       }
}

<?php

namespace App\Imports;

use App\Models\Announcement;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AnnouncementsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
       {
           foreach ($rows as $row)
           {
            Announcement::create([
                'title' => $row['title'],
                'date_of_arrival' => $row['date_of_arrival'],
                'description'=> $row['description'],
                'logo'=> $row['logo'],
            ]);
   
           }
       }
}

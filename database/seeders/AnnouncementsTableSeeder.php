<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcements = [];
        for ($i = 1; $i <= 30; $i++) {
            $announcements[] = [
                'title' => 'Announcement ' . $i,
                'date_of_arrival' => Carbon::now()->subDays(rand(0, 365))->toDateString(),
                'description' => 'This is the description for announcement ' . $i,
                'logo' => 'logos/logo' . $i . '.png',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('announcements')->insert($announcements);
    }
}

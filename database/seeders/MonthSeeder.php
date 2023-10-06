<?php

namespace Database\Seeders;

use App\Models\Month;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        DB::table('months')->delete();

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        // Loop through the month names and insert them into the database
        foreach ($months as $month) {
            DB::table('months')->insert([
                'name' => $month,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}

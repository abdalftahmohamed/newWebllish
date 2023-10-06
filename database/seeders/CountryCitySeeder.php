<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'country' => 'United States',
                'cities' => ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia'],
            ],
            [
                'country' => 'Egypt',
                'cities' => ['Cairo', 'Masoura', 'NasrCity', 'Glasgow', 'Edinburgh'],
            ],
            [
                'country' => 'Canada',
                'cities' => ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Ottawa'],
            ],
            // Add more countries and cities as needed
        ];

        foreach ($data as $item) {
            $country = DB::table('countries')->insertGetId([
                'name' => $item['country'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($item['cities'] as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'country_id' => $country,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }


}

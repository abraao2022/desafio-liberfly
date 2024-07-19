<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            ['name' => 'Electronics', 'description' => 'Electronic gadgets and devices.'],
            ['name' => 'Books', 'description' => 'Various genres of books.'],
            ['name' => 'Clothing', 'description' => 'Men and women clothing.'],
            ['name' => 'Home Appliances', 'description' => 'Appliances for home use.'],
            ['name' => 'Sports Equipment', 'description' => 'Equipment for various sports.'],
        ]);
    }
}

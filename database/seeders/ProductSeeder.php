<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        Product::create([
            'name' => 'Women Regular Fit Solid Spread Collar Casual Shirt',
            'price' => 629,
            'description' => 'Very good product. Perfect size and too much comfortable',
            'image' => 'whiteshirtgirl.webp'
        ]);
        Product::create([
            'name' => 'Men Slim Fit Printed Spread Collar Casual Shirt',
            'price' => 399,
            'description' => 'Quality wise great according to the price',
            'image' => 'boyblackdree.webp'
        ]);
        Product::create([
            'name' => 'FUNDAY FASHION Women Regular Fit Solid Spread Collar Casual Shirt',
            'price' => 349,
            'description' => 'Nice shirt and the fabric is best',
            'image' => 'blackdressgirl.webp'
        ]);
    }
}

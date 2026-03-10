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

        
        // Product::create([
        //     'name' => 'Women Regular Fit Solid Spread Collar Casual Shirt',
        //     'price' => 629,
        //     'description' => 'Very good product. Perfect size and too much comfortable',
        //     'image' => 'whiteshirtgirl.webp'
        // ]);
        // Product::create([
        //     'name' => 'Men Slim Fit Printed Spread Collar Casual Shirt',
        //     'price' => 399,
        //     'description' => 'Quality wise great according to the price',
        //     'image' => 'boyblackdree.webp'
        // ]);
        // Product::create([
        //     'name' => 'FUNDAY FASHION Women Regular Fit Solid Spread Collar Casual Shirt',
        //     'price' => 349,
        //     'description' => 'Nice shirt and the fabric is best',
        //     'image' => 'blackdressgirl.webp'
        // ]);

        Product::create([
            'name' => 'Ducati Panigale',
            'price' => 50,
            'description' => 'The MSRP for the Ducati Panigale V4 varies by model, starting around ₹32 Lakh for the base V4 and going up significantly for higher trims like the V4 S (around ₹39 Lakh), Tricolore (around ₹77 Lakh), and the top-tier V4 R (around ₹85 Lakh)',
            'image' => 'ducativ4.jpeg'
        ]);
        Product::create([
            'name' => 'BMW R 1300 GS',
            'price' => 34,
            'description' => 'The BMW R 1300 GS, has been updated for 2026 in the USA. The motorcycle has received new colour options while remaining mechanically unchanged.',
            'image' => 'bmw.jpg'
        ]);
        Product::create([
            'name' => 'Harley-Davidson X440',
            'price' => 12,
            'description' => 'The X440 is the most affordable Harley-Davidson you can buy in India. It is equipped with a new 440cc engine that churns out good performance',
            'image' => 'harly.jpeg'
        ]);


        Product::create([
            'name' => 'Yamaha YZF R15s',
            'price' => 9,
            'description' => "Yamaha R15 V4 2026 Launched further strengthens Yamaha's leadership in the entry-level supersport category",
            'image' => 'r15.jpeg'
        ]);


        Product::create([
            'name' => 'Honda CB Unicorn 160',
            'price' => 7,
            'description' => 'The 2025 Honda Unicorn has been launched at ₹1.19 lakh (ex-showroom Delhi), featuring modern upgrades',
            'image' => 'honda.jpeg'
        ]);
        Product::create([
            'name' => 'Yamaha MT-15',
            'price' => 10,
            'description' => 'Yamaha MT-15 is generally considered worth buying in 2025 for its stylish streetfighter design, agile handling, powerful VVA engine for its class, and great tech (like slipper clutch, Traction Control) for city/commute/spirited rides,',
            'image' => 'mt15.jpeg'
        ]);
        Product::create([
            'name' => 'Triumph Speed T4',
            'price' => 13,
            'description' => 'the Triumph Speed T4 is worth buying if you want a relaxed, city-friendly, retro-styled bike with great low-end torque, excellent fuel efficiency, and premium build quality at a lower price than the Speed 400',
            'image' => 'triump.jpeg'
        ]);
        Product::create([
            'name' => 'Royal Enfield Hunter 350',
            'price' => 11,
            'description' => 'the Royal Enfield Hunter 350 is generally considered worth buying, especially as a city commuter and for new riders',
            'image' => 'royal.jpeg'
        ]);
        Product::create([
            'name' => 'TVS Ronin TD Special Edition',
            'price' => 11,
            'description' => 'The TVS Ronin TD is available in a new triple-tone Nimbus Grey colour option, along with a new graphic',
            'image' => 'ronin.jpeg'
        ]);

       
    }
}

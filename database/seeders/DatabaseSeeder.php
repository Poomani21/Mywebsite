<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'created_at' => new UTCDateTime(Carbon::now()->getTimestamp()*1000),
            'updated_at' => new UTCDateTime(Carbon::now()->getTimestamp()*1000),
        ]);
        
        $this->call([
            ProductSeeder::class,
           
        ]);
    }
}

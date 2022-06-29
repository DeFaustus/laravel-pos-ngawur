<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\History;
use App\Models\Kategori;
use App\Models\Stok;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Kategori::factory(3)->create();
        // Supplier::factory(5)->create();
        History::factory(30)->create();
        // Barang::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

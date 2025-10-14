<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create default categories
        $categories = [
            ['name' => 'Gaji', 'type' => 'pemasukan', 'description' => 'Pendapatan dari gaji'],
            ['name' => 'Bonus', 'type' => 'pemasukan', 'description' => 'Pendapatan dari bonus'],
            ['name' => 'Lainnya (Pemasukan)', 'type' => 'pemasukan', 'description' => 'Pendapatan lainnya'],
            ['name' => 'Makan & Minum', 'type' => 'pengeluaran', 'description' => 'Pengeluaran untuk konsumsi'],
            ['name' => 'Transportasi', 'type' => 'pengeluaran', 'description' => 'Pengeluaran transportasi'],
            ['name' => 'Belanja', 'type' => 'pengeluaran', 'description' => 'Pengeluaran belanja'],
            ['name' => 'Hiburan', 'type' => 'pengeluaran', 'description' => 'Pengeluaran hiburan'],
            ['name' => 'Lainnya (Pengeluaran)', 'type' => 'pengeluaran', 'description' => 'Pengeluaran lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Default categories created successfully!');
    }
}
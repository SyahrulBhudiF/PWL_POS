<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $kategoriNames = ['jeans', 't-shirt', 'hoodie', 'accessories', 'boxer'];
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'kategori_kode' => 'AOC' . $i + 1,
                'kategori_nama' => $kategoriNames[$i],
            ];
        }
        DB::table('m_kategori')->insert($data);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $userIds = DB::table('m_user')->pluck('user_id');
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'barang_id' => $i,
                'user_id' => $userIds->random(),
                'stok_tanggal' => now(),
                'stok_jumlah' => random_int(1, 50),
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}

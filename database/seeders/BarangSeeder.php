<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * From first to last list: Jeans, T-shirt, Hoodie, accessories, Boxer
     */
    public function run(): void
    {
        $itemNames = [
            'Levis', 'Emba' ,
            'V-Neck Tee', 'Pocket Shirt',
            'Pullover',  'Sleeveless',
            'Woolen Hat', 'Wallet',
            'Silk Boxer', 'Loose Boxer'
        ];
        $kategoriIds = [
            1, 1,
            2, 2,
            3, 3,
            4, 4,
            5, 5
        ];
        $data = [];
        for ($i=0; $i < 10; $i++) {
            $data[] =[
                'kategori_id' =>$kategoriIds[$i],
                'barang_kode' => 'BRG' . $i + 1,
                'barang_nama' => $itemNames[$i],
                'harga_beli' => random_int(200, 300),
                'harga_jual' => random_int(250, 400)
            ];
        }
        DB::table('m_barang')->insert($data);
    }
}

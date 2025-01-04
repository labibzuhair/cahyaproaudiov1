<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\produk;


class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'name' => 'Sewa Sound System',
            'description' => 'Sewa sound system berkualitas tinggi untuk acara Anda.',
            'price' => 150000,
            'type' => 'sound',
            'stock' => '1',
            'photo_main' => 'images/sound_main.jpg',
            'photo_1' => 'images/sound_1.jpg',
            'photo_2' => 'images/sound_2.jpg',
            'photo_3' => null,
            'photo_4' => null,
        ]);

        Produk::create([
            'name' => 'Sewa Tenda Pesta',
            'description' => 'Tenda pesta elegan untuk acara formal atau informal.',
            'price' => 500000,
            'type' => 'tenda',
            'stock' => '1',
            'photo_main' => 'images/tenda_main.jpg',
            'photo_1' => 'images/tenda_1.jpg',
            'photo_2' => null,
            'photo_3' => null,
            'photo_4' => null,
        ]);

        Produk::create([
            'name' => 'Sewa Dekorasi Event',
            'description' => 'Dekorasi kreatif untuk membuat acara Anda lebih berkesan.',
            'price' => 300000,
            'type' => 'dekorasi',
            'stock' => '1',
            'photo_main' => 'images/dekorasi_main.jpg',
            'photo_1' => null,
            'photo_2' => null,
            'photo_3' => null,
            'photo_4' => null,
        ]);
    }
}

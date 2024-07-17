<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Perfume Importado A',
            'description' => 'Um perfume fresco e sofisticado com notas cítricas e florais.',
            'price' => 299.90,
        ]);

        Product::create([
            'name' => 'Perfume Importado B',
            'description' => 'Uma fragrância intensa e marcante com toques amadeirados.',
            'price' => 399.90,
        ]);

        Product::create([
            'name' => 'Perfume Importado C',
            'description' => 'Perfume elegante com aroma doce e frutado, perfeito para ocasiões especiais.',
            'price' => 499.90,
        ]);

        Product::create([
            'name' => 'Perfume Importado D',
            'description' => 'Uma fragrância suave e envolvente com notas de baunilha e jasmim.',
            'price' => 259.90,
        ]);

        Product::create([
            'name' => 'Perfume Importado E',
            'description' => 'Perfume exótico com mistura de especiarias e toques de âmbar.',
            'price' => 349.90,
        ]);
    }
}

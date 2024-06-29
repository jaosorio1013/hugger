<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getProducts() as $product => $price) {
            Product::factory()->create([
                'name' => $product,
                'price' => $price,
            ]);
        }
    }

    private function getProducts(): array
    {
        return [
            'ABRAZADOR CON DONACIÓN' => 100000,
            'ABRAZADOR SOLO' => 50000,
            'GIGANTE' => 250000,
            'MEDIANO' => 98000,
            'MEDIANO SOLO' => 77000,
            'MEDIANO CON DONACIÓN' => 153000,
            'CUARENTENA' => 230000,
            'KIT SUPER' => 62000,
            'KIT DE CONDOLENCIAS' => 98000,
            'KIT PARA QUIÉN ESTÁ LEJOS' => 125000,
            'KIT NUEVOS COMIENZOS' => 290000,
            'KIT NUEVA VIDA' => 98000,
            'KIT CUMPLEAÑOS' => 120000,
            'KIT RECUPERACIÓN' => 98000,
            'LIBRO EN VOZ ALTA' => 50000,
            'POSTALES INDIVIDUALES' => 4500,
            'POSTALES X6' => 22000,
            'LIBRETAS INDIVIDUAL' => 13800,
            'LIBRETAS X 3' => 38000,
            'LIBRETAS X 5' => 65000,
            'TAPABOCAS INDIVIDUAL' => 5000,
            'TAPABOCAS X 3' => 12000,
            'TAPABOCAS X 6' => 25000,
            'TULAS' => 30000,
            'CAMISETA ADULTO' => 45000,
            'CAMISETA NIÑO' => 35000,
            'LIBRO PARA COLOREAR' => 15000,
            'LIBROS PARA COLOREAR SET X3' => 40000,
            'STICKER X 1 HOJAS' => 5500,
            'STICKER X 3 HOJAS' => 15000,
            'STICKER INDIVIDUAL' => 6000,
            'DECRETOS' => 15000,
            'MAZO DE CARTAS' => 40000,
        ];
    }
}

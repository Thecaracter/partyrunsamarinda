<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            [
                'name' => 'S',
                'stock' => 100
            ],
            [
                'name' => 'M',
                'stock' => 150
            ],
            [
                'name' => 'L',
                'stock' => 150
            ],
            [
                'name' => 'XL',
                'stock' => 100
            ],
            [
                'name' => 'XXL',
                'stock' => 50
            ]
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
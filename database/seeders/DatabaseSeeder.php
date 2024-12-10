<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $cantidadUsuarios = 200;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;

        User::factory($cantidadUsuarios)->create();
        Category::factory($cantidadCategorias)->create($cantidadCategorias);
        Product::factory()->create($cantidadProductos)->each(
            function($product){
                $cateogias = Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );

        Transaction::factory()->create($cantidadTransacciones);

    }
}

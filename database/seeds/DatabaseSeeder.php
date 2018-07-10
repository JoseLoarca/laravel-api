<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

//        User::truncate();
//        Category::truncate();
//        Product::truncate();
        Transaction::truncate();
//        DB::table('category_product')->truncate();

        $cantidadUsuarios = 10;
        $cantidadCategories = 10;
        $cantidadProductos = 100;
        $cantidadTransacciones = 100;

//        factory(User::class, $cantidadUsuarios)->create();
//        factory(Category::class, $cantidadCategories)->create();
//
//        factory(Product::class, $cantidadProductos)->create()->each(
//            function ($producto) {
//                $categorias = Category::all()->random(mt_rand(1, 2))->pluck('id');
//
//                $producto->categories()->attach($categorias);
//            }
//        );

        factory(Transaction::class, $cantidadTransacciones)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use \App\Http\Controllers\Admin\ProductController;

class ImportProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ProductController $product)
    {
        \App\Model\Product::truncate();
        $product->importProducts();
    }
}

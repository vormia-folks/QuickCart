<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ? read from public path
        $file = public_path('jsonfile/products.json');
        $json_products = json_decode(file_get_contents($file), true);

        // loop
        foreach ($json_products as $_prod) {

            // New Product
            $this_product = new Product();
            $this_product->name = $_prod['name'];
            $this_product->price = $_prod['price'];
            $this_product->flag = 1;

            //Save
            $this_product->save();
        }
    }
}

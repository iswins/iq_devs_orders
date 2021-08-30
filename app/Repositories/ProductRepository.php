<?php
/**
 * Created by v.taneev.
 */


namespace App\Repositories;


use App\Models\Product;

class ProductRepository
{
    /**
     * @param $rate
     * @return Product
     */
    public static function getProductForRate($rate) {
        $product = Product::query()
            ->where('rate_from', '>=', $rate)
            ->where('rate_to', '<=', $rate)
            ->first();

        return $product;
    }
}

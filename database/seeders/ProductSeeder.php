<?php
/**
 * Created by v.taneev.
 */


namespace Database\Seeders;


use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run()
    {
        $rows = [
            'product_a' => ['name' => 'Продукт A', 'rate_from' => 1, 'rate_to' => 30, 'credit_rate' => 10],
            'product_b' => ['name' => 'Продукт B', 'rate_from' => 31, 'rate_to' => 60, 'credit_rate' => 15],
            'product_c' => ['name' => 'Продукт C', 'rate_from' => 61, 'rate_to' => 99, 'credit_rate' => 20],
        ];


        foreach ($rows as $code => $data) {
            $exists = Product::query()
                ->where('code', '=', $code)
                ->first();

            if ($exists) {
                continue;
            }

            $model = new Product();
            $model->code = $code;
            $model->name = $data['name'];
            $model->rate_from = $data['rate_from'];
            $model->rate_to = $data['rate_to'];
            $model->credit_rate = $data['credit_rate'];
            $model->save();
        }
    }
}

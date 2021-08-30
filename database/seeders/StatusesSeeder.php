<?php
/**
 * Created by v.taneev.
 */


namespace Database\Seeders;


use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{

    public function run()
    {
        $statuses = [
            'review' => ['name' => 'На рассмотрении', 'color' => '#000'],
            'refused' => ['name' => 'Отказано', 'color' => '#F00'],
            'approved' => ['name' => 'Одобрено', 'color' => '#0F0'],
            'payment' => ['name' => 'Производится выплата', 'color' => '#00F'],
            'success' => ['name' => 'Выплачено', 'color' => '#0F0'],
        ];

        foreach ($statuses as $code => $data) {
            $exists = Status::query()
                ->where('code', '=', $code)
                ->first();

            if ($exists) {
                continue;
            }

            $model = new Status();
            $model->code = $code;
            $model->name = $data['name'];
            $model->color = $data['color'];
            $model->save();
        }
    }
}

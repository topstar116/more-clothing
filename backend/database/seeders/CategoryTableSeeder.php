<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->truncate();

        $datas = [
            [
                'name'     => 'カテゴリー1',
            ],
            [
                'name'     => 'カテゴリー2',
            ],
            [
                'name'     => 'カテゴリー3',
            ],
        ];

        foreach($datas as $data) {
            $category = new Category();
            $category->name = $data['name'];
            $category->save();
        }
    }
}

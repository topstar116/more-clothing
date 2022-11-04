<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->truncate();

        $datas = [
            [
                'last_name'     =>  'manager1',
                'first_name'    =>  '',
                'last_name_kana'    =>'',
                'first_name_kana'   =>  '',
                'owner'     => 0,
                'email'     => 'chankan77@gmail.com',
                'password'  => 'password',
            ],
            [
                'last_name'     =>  'manager2',
                'first_name'    =>  '',
                'last_name_kana'    =>'',
                'first_name_kana'   =>  '',
                'owner'     => 0,
                'email'     => 'sasaki.r.0809@gmail.com',
                'password'  => 'ofp12345',
            ],
        ];

        foreach($datas as $data) {
            $manage = new Manager();
            $manage->last_name = $data['last_name'];
            $manage->first_name = $data['first_name'];
            $manage->last_name_kana = $data['last_name_kana'];
            $manage->first_name_kana = $data['first_name_kana'];
            $manage->owner = $data['owner'];
            $manage->email = $data['email'];
            $manage->password = Hash::make($data['password']);
            $manage->save();
        }
    }
}

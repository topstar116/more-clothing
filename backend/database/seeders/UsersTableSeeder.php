<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('users')->truncate();

        $datas = [
            [
                'last_name'     =>  'user',
                'first_name'    =>  'user',
                'last_name_kana'    =>'user',
                'first_name_kana'   =>  'user',
                'password'  =>  'password',
                'api_token',
                'email'     =>  'test@test.com',
                'phone_number'     =>   '08123565241',
                'postcode'      =>      '4568521',
                'city'      =>  'Tokyo',
                'block'     =>  'building',
            ],
        ];

        foreach($datas as $data) {
            $user = new User();
            $user->last_name = $data['last_name'];
            $user->first_name = $data['first_name'];
            $user->last_name_kana = $data['last_name_kana'];
            $user->first_name_kana = $data['first_name_kana'];
            $user->email = $data['email'];
            $user->postcode = $data['postcode'];
            $user->phone_number = $data['phone_number'];
            $user->city = $data['city'];
            $user->block = $data['block'];
            $user->password = Hash::make($data['password']);
            $user->save();
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'name1',
        'name2',
        'kana1',
        'kana2',
        'address1',
        'address2',
        'tel',
        'post',
        'email',
        'memo',
    ];

    public function rentalUserListOfManager($id){
        return self::query()
        ->where('manager_id', '=', $id)
        ->get();
    }

    public function rentalUserUpdate($request) {
        RentalUser::where('manager_id',$request['manager_id'])->update($request);
    }
}

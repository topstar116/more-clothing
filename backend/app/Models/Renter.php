<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renter extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'email',
        'passworad',
        'phone_number',
        'postcode',
        'city',
        'block',
        'memo',
    ];

    public static function findByID($staff_id) {
        return self::query()
                ->where('id', $staff_id)
                ->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalPoint extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id',
        'bank_id',
        'staff_id',
        'point',
        'fee',
        'memo',
    ];

    public static function findByID($bank_id) {
        return self::query()
            ->where('id', $bank_id)
            ->whereNull('deleted_at')
            ->first();
    }
}

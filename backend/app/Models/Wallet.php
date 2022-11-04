<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    public function getPoints() {
        return $this->belongsToMany(GetPoint::class);
    }

    public function withdrawalPoints() {
        return $this->belongsToMany(WithdrawalPoint::class);
    }

    public static function findByID($user_id) {
        return self::query()
            ->where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function findByUserIdWithGetPointAndWithdrawalPoint($user_id) {
        return self::query()
            ->with(['getPoints'], ['withdrawalPoints'])
            ->where('id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}

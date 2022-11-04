<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'number',
    ];

    public function japanBanks() {
        return $this->belongsToMany(JapanBank::class);
    }

    public function otherBanks() {
        return $this->belongsToMany(OtherBank::class);
    }

    public static function findByID($bank_id) {
        return self::query()
            ->where('id', $bank_id)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function findByUserIdWithJapanAndOtherBank($user_id) {
        return self::query()
            ->with(['japanBanks'], ['otherBanks'])
            ->where('id', $user_id)
            ->whereNull('deleted_at')
            ->get();
    }

    public static function findByUserIdWithJapanAndOtherBankManager($user_id) {
        return self::query()
            ->with(['japanBanks'], ['otherBanks'])
            ->where('id', $user_id)
            ->get();
    }
}

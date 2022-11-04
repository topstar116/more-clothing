<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestReturns extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'return_on',
        'detail',
    ];

    public static function findByID($request_return_id) {
        return self::query()
            ->where('id', $request_return_id)
            ->whereNull('deleted_at')
            ->first();
    }

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->first();
    }
}

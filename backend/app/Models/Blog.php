<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_id',
        'title',
        'thumbnail_url',
        'body',
    ];

    public static function findByID($blog_id) {
        return self::query()
                ->where('id', $blog_id)
                ->first();
    }
}

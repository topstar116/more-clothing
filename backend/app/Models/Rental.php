<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'item_id',
        'stop_request_id',
        'name1',
        'name2',
        'item_images'
    ];

    public function rentalShowOfItem($item_id) {
        dd($id);
    }
}

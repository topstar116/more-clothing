<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalTrade extends Model
{
    use HasFactory;

    public function rentalTradeIndex() {
        return self::query()->get();
    }
}

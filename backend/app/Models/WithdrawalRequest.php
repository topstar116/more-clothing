<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    public function index() {
        return self::query()->get();
    }

    public function withdrawalList() {
        return self::query()->get();
    }
}

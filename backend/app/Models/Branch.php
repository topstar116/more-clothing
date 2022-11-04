<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'name',
        'tel',
        'email',
        'post',
        'address1',
        'address2',
    ];

    public function shopAdd($requests) {
        
        $params['manager_id'] = $requests['manager_id'];
        $params['name'] = $requests['name'];
        $params['tel'] = $requests['tel'];
        $params['email'] = $requests['email'];
        $params['post'] = $requests['post'];
        $params['address1'] = $requests['address1'];
        $params['address2'] = $requests['address2'];

        shop::create($params);
    }
}

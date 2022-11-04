<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'name1',
        'name2',
        'email',
        'memo',
    ];

    public function indexOfManager($key) {
        return self::query()->where('manager_id',$key)->get();
    }

    public function StaffAdd($request) {
        $params['manager_id'] = $request['shop'];
        $params['name1'] = $request['name1'];
        $params['name2'] = $request['name2'];
        $params['email'] = $request['email'];
        $params['memo'] = $request['memo'];
        Staff::create($params);
    }
}

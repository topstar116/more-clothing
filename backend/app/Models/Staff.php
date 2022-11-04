<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Box;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'staffs';
    protected $fillable = [
        'shop_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'email',
        'memo',
    ];

    public static function findByID($staff_id) {
        return self::query()
                ->where('id', $staff_id)
                ->first();
    }

    public function staffAdd($request) {
        // $params['manager_id'] = $request['manager_id'];
        $params['shop_id'] = $request['shop'];
        $params['last_name'] = $request['name1'];
        $params['first_name'] = $request['name2'];
        $params['last_name_kana'] = $request['name1'];
        $params['first_name_kana'] = $request['name2'];
        $params['email'] = $request['email'];
        $params['memo'] = $request['memo'];
        Staff::create($params);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}

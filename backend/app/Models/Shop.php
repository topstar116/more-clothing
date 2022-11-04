<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Staff;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'shops';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'postcode',
        'city',
        'block',
    ];

    public static function findByID($shop_id) {
        return self::query()
                ->where('id', $shop_id)
                ->first();
    }

    public function shopAdd($requests) {
        
        // $params['manager_id'] = $requests['manager_id'];
        $params['name'] = $requests['name'];
        $params['phone_number'] = $requests['phone_number'];
        $params['email'] = $requests['email'];
        $params['postcode'] = $requests['postcode'];
        $params['city'] = $requests['city'];
        $params['block'] = $requests['block'];

        Shop::create($params);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}

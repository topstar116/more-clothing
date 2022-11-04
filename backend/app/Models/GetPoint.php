<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class GetPoint extends Model
{
    use HasFactory, SoftDeletes;

    const EXPIRATION_DAYS = 180;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet_id',
        'how',
        'relation_id',
        'point',
        'expiration_on',
    ];

    /**
     * 日付を変形する属性
     *
     * @var array
     */

    protected $dates = [
        'expiration_on',
    ];

    public static function build($wallet_id, $how = 0, $relation_id = 0, $point,  $days = self::EXPIRATION_DAYS)
    {
        $date = now();

        return new self([
            'wallet_id'      => $wallet_id,
            'how' => $how,
            'relation_id' => $relation_id,
            'point' => $point,
            'expiration_on' => Carbon::today()->addDays($days),
            
        ]);
    }

    /**
     * 有効期限内かどうかを取得
     *
     * @return bool
     */
    public function isExpiration()
    {
        return $this->expiration_on >= Carbon::today();
    }

    public static function findByID($wallet_id) {
        return self::query()
            ->where('wallet_id', $wallet_id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function storePointRequest($params)
    {
        $this->create($params);
    }

    
    public function tradeList($user_id)
    {
        return $this
            ->select([
                'wallets.id',
                'get_points.*',
                'history_rentals.*',
                'items.id',
                'item_images.image_url',
            ])
            ->leftJoin('history_rentals', function ($query) {
                $query->on('history_rentals.get_point_id', '=', 'get_points.wallet_id');
            })
            ->leftJoin('items', function ($query) {
                $query->on('history_rentals.item_id', '=', 'items.id');
            })
            ->leftJoin('item_images', function ($query) {
                $query->on('items.id', '=', 'item_images.item_id');
            })
            ->leftJoin('wallets', function ($query) {
                $query->on('get_points.wallet_id', 'wallets.id');
            })
            ->where('wallets.user_id', '=', $user_id)
            ->orderBy('get_points.created_at', 'desc')
            ->get();

        // return $this
        //     ->select([
        //         'points.*',
        //         'items.item_image_id',
        //         'item_images.url',
        //     ])
        //     ->rightJoin('items', function ($query) {
        //         $query->on('points.item_id', '=', 'items.id');
        //     })
        //     ->rightJoin('item_images', function ($query) {
        //         $query->on('items.item_image_id', '=', 'item_images.id');
        //     })
        //     ->where('points.user_id', $id)
        //     ->get();
    }

    /**
     * 取引一覧の残高を取得する
     *
     * @param [array] $params
     * @return App\Models\Point
     */
    public function tradeHoldPoint($id)
    {
        // 取引のプラスの合計値を取得
        $point_plus = GetPoint::
            leftJoin('wallets', function ($query) {
                $query->on('get_points.wallet_id', 'wallets.id');
            })  
            ->where('wallets.user_id', $id)
            ->sum('point');

        // 取引のマイナスの合計値を取得
        $point_minus = GetPoint::
            leftJoin('wallets', function ($query) {
                $query->on('get_points.wallet_id', 'wallets.id');
            })  
            ->where('wallets.user_id', $id)
            ->sum('point');

        // プラスとマイナスを計算
        $point_total = $point_plus - $point_minus;
        return $point_total;
    }

    /**
     * 取引一覧の残高を、出金リクエストから1,000円刻みで請求する
     *
     * @param [array] $params
     * @return App\Models\Point
     */
    public function tradeHoldPointSelect($id)
    {
        $point_instance = new Point;
        $total_point = $point_instance->tradeHoldPoint($id);
        for($i = 1000; $i <= $total_point; $i = $i + 1000) {
            $array[] = $i;
        }
        return $array;
    }
}

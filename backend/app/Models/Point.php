<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'item_id',
        'reason',
        'reason_id',
        'point',
        'expiration_at',
    ];

    /**
     * 取引に追加
     *
     * @param $key
     * @return App\Models\Point
     */
    public function storePointRequest($params)
    {
        $this->create($params);
    }

    /**
     * 取引一覧
     *
     * @param [array] $params
     * @return App\Models\Point
     */
    public function tradeList($id)
    {
        return $this
            ->select([
                'points.*',
                'items.item_image_id',
                'item_images.url',
            ])
            ->where('points.user_id', $id)
            ->leftJoin('items', function ($query) {
                $query->on('points.item_id', '=', 'items.id');
            })
            ->leftJoin('item_images', function ($query) {
                $query->on('items.item_image_id', '=', 'item_images.id');
            })
            ->orderBy('points.created_at', 'desc')
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
        $point_plus = Point::where('points.user_id', $id)
            ->where('points.reason', 0)
            ->orWhere('points.reason', 1)
            ->sum('point');

        // 取引のマイナスの合計値を取得
        $point_minus = Point::where('points.user_id', $id)
            ->where('points.reason', 8)
            ->orWhere('points.reason', 9)
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
        $array = [];
        for($i = 1000; $i <= $total_point; $i = $i + 1000) {
            $array[] = $i;
        }
        return $array;
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'type',
        'status',
        'Staff_id',
        'reason',
        // 'request_sell',
        'request_rental',
        'request_return_at',
        'memo',
        'decision_at',
    ];
    protected $dates = ['deleted_at'];

    /**
     * リクエストを引数とした、一覧を取得
     *
     * @param $key
     * @return App\Models\Box
     */
    public function indexOfTypeWithUser($key)
    {
        return ItemRequest::select([
            'item_requests.*',
            'items.number as item_number',
            'users.id as user_id',
            'users.last_name as user_name1',
            'users.first_name as user_name2',
            ])
            ->where('item_requests.type', $key)
            ->whereNull('item_requests.decision_at')
            ->whereNull('item_requests.deleted_at')
            ->orderBy('created_at', 'desc')
            ->leftJoin('items', 'items.id', '=', 'item_requests.item_id')
            ->leftJoin('boxes', 'boxes.id', '=', 'items.box_id')
            ->leftJoin('users', 'users.id', '=', 'boxes.user_id')
            ->get();
    }

    /**
     * 販売停止リクエストを追加（引数をnumberにする）
     *
     * @param $key
     * @return App\Models\Box
     */
    public function store($params)
    {
        $this->create($params);
    }
}

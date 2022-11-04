<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Staff;
use App\Models\Item;

class Box extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'user_id',
        'number',
        'received_on',
        'detail',
    ];

    /**
     * ユーザーに紐づく箱一覧
     *
     * @param [array] $params
     * @return App\Models\Box
     */
    public function boxListOfBoxId($user_id)
    {
        return $this
            ->where('boxes.user_id', '=', $user_id)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function getBoxesByUser($user_id) {
        return self::query()
                ->where('user_id', $user_id)
                ->orderBy('created_at', 'DESC')
                ->get();
    }

    public function findByBoxId($box_id)
    {
        return $this
            ->where('id', '=', $box_id)
            ->whereNull('deleted_at')
            ->first();
    }

   
    /**
     * ユーザーに紐づく箱一覧
     *
     * @param [array] $params
     * @return App\Models\Box
     */
    public function boxListOfUser($user_id)
    {
        return $this
            ->where('boxes.user_id', '=', $user_id)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * 箱に紐づく商品一覧を取得
     *
     * @param [array] $params
     * @return App\Models\Box
     */
    public function boxItemList()
    {
        return $this
            ->select([
                'boxes.*',
                'users.id as user_id',
                'users.last_name as user_name1',
                'users.first_name as user_name2',
                'users.last_name_kana as user_kana1',
                'users.first_name_kana as user_kana2',
            ])
            ->leftJoin('users', 'boxes.user_id', '=', 'users.id')
            ->get();
    }

    /**
     * 箱詳細
     *
     * @param [array] $params
     * @return App\Models\Box
     */
    public function boxShowWithUserItem($id)
    {
        return Box::where('boxes.id', $id)
            ->select([
                'boxes.*',
                'users.last_name as user_name1',
                'users.first_name as user_name2',
            ])
            ->leftJoin('users', 'boxes.user_id', '=', 'users.id')
            ->first();

    }

    /**
     * 新規で箱を追加する
     *
     * @param [array] $params
     * @return App\Models\Box
     */
    public function boxAddOfUser($targets)
    {
        // DBに登録されているnumberを全て配列で取得
        $boxNumbers = Box::select(['boxes.number'])->get()->toArray();
        foreach($boxNumbers as $boxNumber) {
            $numbers[] = $boxNumber['number'];
        }

        // DBに登録されているnumberとランダムで生成した値が被るか調べる
        if($boxNumbers) {
            do{
                // 12桁のランダムな整数を作成
                $randam = '';
                for($i=0;$i<12;$i++){
                    $randam.=mt_rand(0,9);
                }
                // DBに登録されているnumberと12桁のランダムな整数が合致するか
                $key = in_array($randam, $numbers);
            } while ($key == true);
        } else {
            // 12桁のランダムな整数を作成
            $randam = '';
            for($i=0;$i<12;$i++){
                $randam.=mt_rand(0,9);
            }
        }

        try {
            $params['user_id']       = $targets['user'];
            $params['staff_id']       = $targets['staff'];
            $params['received_on']   = $targets['date'];
            $params['detail']        = $targets['detail'];
            $params['number']        = $randam;
        } catch(\Exception $e) {

        }
        Box::create($params);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function staff(){
        return $this->belongsTo(Staff::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
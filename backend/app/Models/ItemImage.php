<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemImage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'item_id',
        'image_url',
        'image_order',
    ];

    public static function findByID($item_id) {
        return self::query()
            ->where('id', $item_id)
            ->whereNull('deleted_at')
            ->orderBy('image_order')
            ->first();
    }

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->whereNull('deleted_at')
            ->orderBy('image_order')
            ->all();
    }

    public static function delByOrder($item_id, $orders) {

        foreach($orders as $order){
            self::query()
            ->where('item_id', $item_id)
            ->where('image_order', $order)
            ->whereNull('deleted_at')
            ->delete();
        }
        
    }

    public function delete(){
        if(file_exists('file_path')){
            @unlink('file_path');
        }
        parent::delete();
    }

    /**
     * 荷物画像 追加
     *
     * @param [array] $params
     * @return App\Models\Item
     */
    public function itemImageStore($requests, $id)
    {

        $paths = [];
        $orders = [];
        if(isset($requests['img1'])) {
            $requests['img1']->store('/public/img/items');
            $paths[] = '/storage/app/public/img/items/' . $requests['img1']->hashName();
            array_push($orders,0);
            // $item_image = ItemImage::delByOrder($id,0);
        };
        if(isset($requests['img2'])) {
            $requests['img2']->store('/public/img/items');
            $paths[] = '/storage/app/public/img/items/' . $requests['img2']->hashName();
            array_push($orders,1);
            // $item_image = ItemImage::delByOrder($id,1);
        };
        if(isset($requests['img3'])) {
            $requests['img3']->store('/public/img/items');
            $paths[] = '/storage/app/public/img/items/' . $requests['img3']->hashName();
            array_push($orders,2);
            // $item_image = ItemImage::delByOrder($id,2);
        };
        if(isset($requests['img4'])) {
            $requests['img4']->store('/public/img/items');
            $paths[] = '/storage/app/public/img/items/' . $requests['img4']->hashName();
            array_push($orders,3);
            // $item_image = ItemImage::delByOrder($id,3);
        };
        if(isset($requests['img5'])) {
            $requests['img5']->store('/public/img/items');
            $paths[] = '/storage/app/public/img/items/' . $requests['img5']->hashName();
            array_push($orders,4);
            // $item_image = ItemImage::delByOrder($id,4);
        };
        
        itemImage::delByOrder($id,$orders);

        foreach($paths as $index => $path) {
            
            $params['item_id']     = $id;
            $params['image_url']         = $path;
            $params['image_order'] = $orders[$index];
            // var_dump($params);

            ItemImage::create($params);            
            
            
            // if($index == 0) {
            //     $lastID = DB::getPdo()->lastInsertId();
            //     $item = Item::where('id', $id)->first();
            //     $item->item_image_id = $lastID;
            //     $item->create();
            // };
        };
    }

    public function itemImageList($id) {
        return ItemImage::where('item_id',$id)->orderBy('image_order')->get();
    }
}

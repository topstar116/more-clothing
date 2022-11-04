<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Item;
use App\Models\InfoRental;
use App\Models\RequestSale;
use App\Models\Sell;
use App\Models\ItemImage;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryDonation;

class ItemController extends Controller
{
    /**
     * 保管荷物 中身一覧
     *
     * @return view
     */
    public function index($id)
    {
        $item_instance = new Item;
        $box = Box::where('id', $id)->first();
        // $items = $item_instance->boxItemList($id);
        // $item_images = $item_instance->boxItemImageList($id);
        $items = $box->items()->get();
        
        // 上のプログラムと同じ
        // $items = Item::orderBy('id', 'DESC')->where('box_id',$id)->get();
        return view('user.item.index', compact('items', 'box'));
    }

    /**
     * 保管荷物 中身詳細
     *
     * @return view
     */
    public function show($id)
    {
        // $item = Item::findById($id);
        // return view('user.item.show', compact('item'));
        $instance_item = new Item;
        //ステータス情報を取得
        $array = $instance_item->itemWithStatus($id);
        // 荷物の情報
        $item = $array[0] ?? '';
        // 荷物の画像を取得する
        $item_image = ItemImage::where('item_id', $id)->first();
        // 荷物の追加情報
        $detail = $array[1] ?? '';
        // $detail = $item->status;

        return view('user.item.show', compact('item', 'detail', 'item_image'));
    }

    /**
     * 寄付の処理（statusを7に変更する）
     *
     * @return view
     */
    public function changeDonate(Request $request)
    {
        $id = $request->id;
        $item = new Item;
        // 寄付のステータス(7)を渡す
        $item->changeItemStatus($id, 'done_donate');
        
        $data = array(
            'item_id' => $id,
            'memo' => '',
        );

        $history_sale = new HistoryDonation($data);
        $history_sale->save();
        // $item->status = 7;
        // $item->save();
        return redirect(route('custody.item.detail', $id));
    }

    /**
     * 販売代行を停止する（requestを7に変更する、request tableに表示させる）
     *
     * @return view
     */
    public function itemStopSell(Request $request)
    {
        $id = $request->id;
        $item = new Item;
        $request = new ItemRequest;
        return DB::transaction(function () use ($item, $request, $id) {
            // １．requestを7に変更する
            $item->changeItemRequest($id, 2);
            // ２．requestに販売出品停止リクエスト（8）を追加
            $params['item_id'] = $id;
            $params['type'] = 8;
            $request->store($params);
            return redirect(route('custody.item.detail', $id));
        });
        return redirect(route('custody.item.detail', $id));
    }

    /**
     * レンタル出品を停止する
     *
     * @return view
     */
    public function itemStopRental(Request $request)
    {
        $id = $request->id;
        $item = new Item;
        $request = new ItemRequest;
        // トランザクションで同時に値を変更する
        return DB::transaction(function () use ($item, $request, $id) {
            // １．request 4 に変更する
            $item->changeItemRequest($id, 4);
            // ２．販売を停止リクエスト（9）を追加
            $params['item_id'] = $id;
            $params['type'] = 9;
            $request->store($params);
            return redirect(route('custody.item.detail', $id));
        });
        return redirect(route('custody.item.detail', $id));
    }

    /**
     * 商品 返却リクエスト
     *
     * @return view
     */
    public function returnRequest()
    {
        $user_id = Auth::user()->id;
        // １．箱を配列で取得
        $boxes = Box::where('user_id', $user_id)->get();
        // $boxes_length = count($boxes);
        // for($i = 1; $i > $boxes_length+1; $i++) {
        //     dd($boxes[])
        // }
        // $item = new Item;
        // $item->relatedBoxItemsWithImages;
        // $item_images = Item::find(2)->itemImages()->get();
        // ２．箱の中の荷物を、画像付きで配列で取得
        $items = [];$item_images = [];
        foreach($boxes as $index => $box) {
            $items[$index] = Item::where('box_id', $box->id)->get();
            // $item_images[$index] = Item::where('item_id', $items[$index]->id)->itemImages()->get();
        }
        // dd($items);
        // ３．荷物の画像を配列に取得、
        foreach($items as $i_index => $item) {
            foreach($item as $t_index => $target) {
                $item_images[$i_index][$t_index] = ItemImage::where('item_id', $target->id)->get();
            }
        }
        // dd($items);
        // dd($item_images);
        return view('user.return.request', compact('boxes', 'items', 'item_images'));
    }

    /**
     * 商品 返却リクエスト POST
     *
     * @return view
     */
    public function returnRequestPost(Request $request) {
        // 入力した値を全て取得
        $input = $request->all();
        // form_inputという値で取得
        $request->session()->put("form_input", $input);
        return redirect(route('custody.return.request.confirm'));
    }

    /**
     * 商品 返却リクエスト 確認
     *
     * @return view
     */
    public function returnRequestConfirm(Request $request) {
        // セッションにうつし変える
        $input = $request->session()->get("form_input");
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!$input){
			return redirect(route('custody.return.request'));
        }
        // 画像を配列で取得する
        foreach($input['images'] as $index => $image) {
            $images[] = ItemImage::where('id', $image)->first();
        }
        // 確認画面へリダイレクト
        return view('user.return.requestConfirm', compact('input', 'images'));
    }

    /**
     * 商品 返却リクエスト 確認 POST
     *
     * @return view
     */
    public function returnRequestConfirmPost(Request $request) {
        $input = $request->session()->get("form_input");
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!$input){
			return redirect(route('custody.return.request'));
        }

        //戻るボタンが押された
        if($request->has("back")){
            return redirect(route('custody.return.request'))->withInput($input);
        }

        // 返却リクエストの処理実行
        $itemImage = new ItemImage;
        $item = new Item;
        $itemRequest = new ItemRequest;
        DB::beginTransaction();
        try {
            // 荷物画像のIDから、荷物IDを取得して、リクエストの値を返却リクエスト(5)に変更する
            foreach($input['images'] as $index => $image) {
                $image_id = $itemImage::find($image)->item_id;
                $item_id = $item::find($image_id)->id;
                $item->changeItemRequest($item_id, 5);

                // 荷物リクエスト：返却
                $params['item_id'] = $item_id;
                $params['type'] = 3;
                $params['request_return_at'] = $input['date'];
                $params['memo'] = $input['request'];
                $itemRequest->store($params);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }

        // ここでメールを送信するなどを行う

        // セッションを空にする
        $request->session()->forget("form_input");
        return redirect(route('custody.return.request.complete'));
    }

    /**
     * 商品 返却リクエスト 完了
     *
     * @return view
     */
    public function returnRequestComplete() {
        return view('user.return.requestComplete');
    }

    /**
     * 販売代行 荷物一覧
     *
     * @return view
     */
    public function saleIndex() {
        $item_instance = new Item;
        // 販売代行中の荷物一覧を取得する
        $items = $item_instance->itemListSell();
        return view('user.sale.index', compact('items'));
    }

    /**
     * 販売代行 荷物詳細
     *
     * @return view
     */
    // public function saleShow() {
    //     return view('user.sale.show');
    // }

    /**
     * 販売代行 リクエスト
     *
     * @return view
     */
    public function saleRequest() {
        $item_instance = new Item;
        // 画像付き荷物一覧
        $items = $item_instance->itemListSell();
        return view('user.sale.request', compact('items'));
    }

    /**
     * 販売代行 リクエスト POST
     *
     * @return view
     */
    public function saleRequestPost(Request $request)
    {
        // 入力した値を全て取得
        $input = $request->all();
        // form_inputという値で取得
        $request->session()->put("form_input", $input);
        return view('user.sale.requestConfirm');
    }

    /**
     * 販売代行 リクエスト ステップ2
     *
     * @return view
     */
    public function saleRequestTwo(Request $request)
    {
        // 入力したセッション情報を全て取得
        $input = $request->all();
        $request->session()->put("form_input", $input);

        // form_inputという値で取得
        // 戻る機能
        $oldSession = $request->session()->get("_old_input");
        $inputSession = $request->session()->get("form_input");

        $input_items = '';
        if($oldSession) {
            $input_items = $oldSession;
        } elseif($inputSession) {
            $input_items = $inputSession;
        }

        // sessionに値がない場合、販売代行ページにリダイレクト
        if(!isset($input_items['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.sales.request'))->withErrors($error);
        }
        return view('user.sale.requestTwo', compact('input_items'));
    }

    /**
     * 販売代行 リクエスト ステップ2 POST
     *
     * @return view
     */
    public function saleRequestTwoPost(Request $request)
    {
        // 入力した値を全て取得
        $input = $request->all();
        // form_inputという値で取得
        $request->session()->put("form_input", $input);
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.sales.request'))->withErrors($error);
        }

        //戻るボタンが押された
        if($request->has("back")){
            return redirect(route('custody.sales.request'))->withInput($input);
        }
        return redirect(route('custody.sales.request.confirm'));
    }

    /**
     * 販売代行 リクエスト 確認
     *
     * @return view
     */
    public function saleRequestConfirm(Request $request)
    {
        // セッションにうつし変える
        $input = $request->session()->get("form_input");

        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.sales.request'))->withErrors($error);
        }
        return view('user.sale.requestConfirm', compact('input'))->withInput($input);
    }

    /**
     * 販売代行 リクエスト 確認 POST
     *
     * @return view
     */
    public function saleRequestConfirmPost(Request $request)
    {
        
        $input = $request->session()->get("form_input");
        
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.sales.request'))->withErrors($error);
        }

        //戻るボタンが押された
        if($request->has("back")){
            // return view('user.sale.requestConfirm', compact('input'))->withInput($input);
            return redirect(route('custody.sales.request.two'))->withInput($input);
            // return redirect()->back()->withInput($input);
        }
        // 荷物IDから、リクエストの値を返却リクエスト(1)に変更する
        $item = new Item;
        $requestSale = new RequestSale;
        DB::beginTransaction();
        try {
            // 荷物IDから、リクエストの値を返却リクエスト(1)に変更する
            $item->changeItemRequest($input['item_id'], 'now_sale');

            // 販売代行リクエストを登録する
            $requestSale->item_id = $input['item_id'];
            $requestSale->detail = $input['request'];
            $requestSale->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }

        // ここでメールを送信するなどを行う

        // セッションを空にする
        $request->session()->forget("form_input");
        return redirect(route('custody.sales.request.complete'));
    }

    /**
     * 販売代行 リクエスト 完了
     *
     * @return view
     */
    public function salesRequestComplete() {
        return view('user.sale.requestComplete');
    }

    /**
     * 販売代行 停止リクエスト
     *
     * @return view
     */
    public function saleStopRequest(Request $request) {
        $items = $request['items'];
        $item_instance = new Item;
        foreach($items as $item) {
            $item_instance->changeItemRequest($item, 2);
        }
        return redirect(route('custody.sales'));
    }

    /**
     * 販売代行 停止リクエスト完了
     *
     * @return view
     */
    // public function saleStopRequestComplete() {
    //     return view('user.sale.stopRequestComplete');
    // }

    /**
     * レンタル 荷物一覧
     *
     * @return view
     */
    public function rentalIndex() {
        $itemInstance = new Item;
        // 販売代行中の荷物一覧を取得する
        $items = $itemInstance->itemListRental();
        return view('user.rental.index', compact('items'));
    }

    /**
     * レンタル 停止リクエスト
     *
     * @return view
     */
    public function rentalStopRequest(Request $request)
    {
        $items = $request['items'];
        $itemInstance = new Item;
        DB::beginTransaction();
        try {
            foreach($items as $item) {
                // 荷物のIDの値を変える
                $itemInstance->changeItemRequest($item, 'lend_rental');
                // InfoRental::where('id', 'items_id')->delete();
            }
            DB::commit();
            return redirect(route('custody.rental'));
        } catch (\Exception $e) {
            DB::rollback();
            $error = 'レンタル停止リクエストに失敗しました。';
            return back()->withErrors($error);
        }
    }

    /**
     * レンタル 停止リクエスト 完了
     *
     * @return view
     */
    // public function rentalStopRequestComplete() {
    //     return view('user.rental.stopRequestComplete');
    // }

    /**
     * レンタル 荷物詳細
     *
     * @return view
     */
    // public function rentalShow() {
    //     return view('user.rental.show');
    // }

    /**
     * レンタル 出品リクエスト
     *
     * @return view
     */
    public function rentalRequest() {
        $item_instance = new Item;
        // 画像付き荷物一覧
        $items = $item_instance->itemListRental();
        return view('user.rental.request', compact('items'));
    }

    /**
     * レンタル 出品リクエスト POST
     *
     * @return view
     */
    public function rentalRequestPost(Request $request) {
        // 入力した値を全て取得
        $input = $request->all();
        // form_inputという値で取得
        $request->session()->put("form_input", $input);
        return view('user.rental.requestConfirm');
    }

    /**
     * レンタル 出品リクエスト ステップ2
     *
     * @return view
     */
    public function rentalRequestTwo(Request $request)
    {
        // 入力した値を全て取得
        $input = $request->all();
        $request->session()->put("form_input", $input);

        // form_inputという値で取得
        // 戻る機能
        $oldSession = $request->session()->get("_old_input");
        $inputSession = $request->session()->get("form_input");

        $input_items = '';
        if($oldSession) {
            $input_items = $oldSession;
        } elseif($inputSession) {
            $input_items = $inputSession;
        }

        // dd($input_items);
        // sessionに丈夫尾がない場合、販売代行ページにリダイレクト
        if(!isset($input_items['item_id'])) {
            $error = 'セッションが切れました';
			return redirect(route('custody.rental.request'))->withErrors($error);
        }
        return view('user.rental.requestTwo', compact('input_items'));
    }

    /**
     * レンタル リクエスト ステップ2 POST
     *
     * @return view
     */
    public function rentalRequestTwoPost(Request $request)
    {
        // 入力した値を全て取得
        $input = $request->all();
        // form_inputという値で取得
        $request->session()->put("form_input", $input);

        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.rental.request'))->withErrors($error);
        }

        //戻るボタンが押された
        if($request->has("back")){
            return redirect(route('custody.rental.request'))->withInput($input);
        }
        return redirect(route('custody.rental.request.confirm'));
    }

    /**
     * レンタル 出品リクエスト 確認
     *
     * @return view
     */
    public function rentalRequestConfirm(Request $request) {
        // セッションにうつし変える
        $input = $request->session()->get("form_input");
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('rental.rental.request'))->withErrors($error);
        }
        return view('user.rental.requestConfirm', compact('input'))->withInput($input);
    }

    /**
     * レンタル 出品リクエスト 確認 POST
     *
     * @return view
     */
    public function rentalRequestConfirmPost(Request $request)
    {
        $input = $request->session()->get("form_input");

        // print_r($input);
        // exit;
        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!isset($input['item_id'])) {
            $error = 'セッションが切れました。';
			return redirect(route('custody.rental.request'))->withErrors($error);
        }

        //戻るボタンが押された
        if($request->has("back")){
            return redirect(route('custody.rental.request.two'))->withInput($input);
        }

        // インスタンスの生成
        $item = new Item;
        $infoRental = new InfoRental;
        // $infoRental = new RentalTrade;

        DB::beginTransaction();
        try {
            // 荷物IDから、リクエストの値を返却リクエスト(3)に変更する
            $item->changeItemRequest($input['item_id'], 'lend_rental');

            // レンタル出品リクエスト
            // $infoRental->item_id = $input['item_id'];
            // $infoRental->price = $input['price'];
            // $infoRental->detail = $input['other'];
            // $infoRental->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }

        // ここでメールを送信するなどを行う
        // セッションを空にする
        $request->session()->forget("form_input");
        // 完了画面へ
        return redirect(route('custody.rental.request.complete'));
    }

    /**
     * レンタル 出品リクエスト 完了
     *
     * @return view
     */
    public function rentalRequestComplete() {
        return view('user.rental.requestComplete');
    }

    /**
     * 寄付 リクエスト
     *
     * @return view
     */
    public function donateRequest() {
        return view('user.donate.request');
    }

    /**
     * 寄付 リクエスト 確認
     *
     * @return view
     */
    public function donateRequestConfirm() {
        return view('user.donate.requestConfirm');
    }

    /**
     * 寄付 リクエスト 完了
     *
     * @return view
     */
    public function donateRequestComplete() {
        return view('user.donate.requestComplete');
    }

    /**
     * 取引履歴 一覧（出金 / 販売 / レンタル / 寄付）
     *
     * @return view
     */
    public function tradeIndex() {
        return view('user.trade.index');
    }

    /**
     * 取引履歴 詳細
     *
     * @return view
     */
    public function tradeShow() {
        return view('user.trade.show');
    }

    /**
     * 出金 リクエスト
     *
     * @return view
     */
    public function paymentRequest() {
        return view('user.payment.request');
    }

    /**
     * 出金 リクエスト 確認
     *
     * @return view
     */
    public function paymentRequestConfirm() {
        return view('user.payment.requestConfirm');
    }

    /**
     * 出金 リクエスト 完了
     *
     * @return view
     */
    public function paymentRequestComplete() {
        return view('user.payment.requestComplete');
    }
}

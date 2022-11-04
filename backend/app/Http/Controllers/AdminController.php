<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Box;
use App\Models\Item;
use App\Models\Sell;
use App\Models\Sale;
use App\Models\Ship;
use App\Models\User;
use App\Models\Point;
use App\Models\Shop;
use App\Models\Staff;
use App\Models\Rental;
use App\Models\ItemImage;
use App\Models\RentalUser;
use App\Models\RentalImage;
use App\Models\RentalTrade;
use App\Models\ItemRequest;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// バリデーションファイル
// リクエスト 承認
use App\Http\Requests\PermitItemRequest;
// リクエスト 非承認
use App\Http\Requests\RejectItemRequest;
// リクエスト 売却
use App\Http\Requests\SoldItemRequest;
// リクエスト レンタル
use App\Http\Requests\RentalItemRequest;
// リクエスト レンタル返却
use App\Http\Requests\RentalReturnItemRequest;
// リクエスト 荷物追加
use App\Http\Requests\StoreItemRequest;
// リクエスト レンタルユーザー編集
use App\Http\Requests\StoreRentalUserRequest;

class AdminController extends Controller
{
    /**
     * 出金リクエスト一覧
     *
     * @return view
     */
    public function withdrawalRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;
        
        // 出金リクエスト一覧を取得
        $withdrawalInstance = new WithdrawalRequest;
        $withdrawals = $withdrawalInstance->index();

        // 担当者一覧を取得
        $staffs = Staff::get();
        // dd($staffs);

        return view('admin.request.withdrawal', compact('withdrawals', 'staffs'));
    }

    /**
     * 出金リクエスト 承認処理
     *
     * @return view
     */
    public function withdrawalRequestPost(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'staff'    => 'required',
            'target_id' => 'required',
            'memo'      => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'target_id.required' => '出金リクエストは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.withdrawal'))
                ->withErrors($validator)
                ->withInput();
        }

        // 出金リクエスト情報を取得
        $withdrawalInstance = new WithdrawalRequest;
        $withdrawal = $withdrawalInstance->show($request['target_id']);
        // dd($withdrawal);

        // DBトランザクションで、「出金リクエスト完了」と「ポイント登録」を同時に行う
        $pointInstance = new Point;
        // 今日の日付を取得
        $today = Carbon::now();
        // 今日から1年後の日付を取得
        $expiration = Carbon::now()->addYear();

        DB::beginTransaction();
        try {
            // 出金リクエストのcomplete_atにデータを登録する（update）
            $withdrawalInstance->updateCompleteAt($request);

            // ポイント（points）に登録する（store）
            $params['user_id']       = $withdrawal['user_id'];
            $params['item_id']       = null;
            $params['reason']        = 9;
            $params['reason_id']     = $withdrawal['id'];
            $params['point']         = $withdrawal['price'];
            $params['expiration_at'] = $expiration;
            $pointInstance->storePointRequest($params);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = '出金リクエスト承認処理の失敗しました。';
            return back()->withInput()->withErrors($error);
        }
        return redirect(route('admin.request.withdrawal'))->with('success-message', '出金リクエスト承認処理が成功しました。');
    }

    /**
     * 出金リクエスト 非承認処理
     *
     * @return view
     */
    public function withdrawalRequestReject(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'staff'     => 'required',
            'reject_id'  => 'required',
            'reason'     => 'max:1000',
            'memo'       => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'reject_id.required' => '出金リクエストは必須です。',
            'reason.max'         => '非承認理由は1000文字以内です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];

        // ソフトデリート
        $withdrawalInstance = new WithdrawalRequest;
        try {
            WithdrawalRequest::find($request['reject_id'])->delete();
            return redirect(route('admin.request.withdrawal'))->with('success-message', '出金リクエスト非承認処理が成功しました。');
        } catch (\Exception $e) {
            $error = '出金リクエスト非承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * 返却リクエスト
     *
     * @return view
     */
    public function returnRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 荷物リクエストの中から、返却リクエスト（3）の一覧を取得
        $itemRequestInstance = new ItemRequest;
        $itemRequests = $itemRequestInstance->indexOfTypeWithUser(3);

        // 担当者一覧を取得
        $staffs = Staff::get();

        return view('admin.request.return', compact('itemRequests', 'staffs'));
    }

    /**
     * 返却リクエスト 承認手続き
     *
     * @return view
     */
    public function returnRequestPost(Request $request)
    {

        // バリデーションチェック
        $rulus = [
            'company'   => 'required|max:100',
            'number'    => 'required|max:20',
            'date'      => 'required',
            'staff'    => 'required',
            'target_id' => 'required',
            'memo'      => 'max:1000',
        ];
        $message = [
            'company.required'   => '返却郵送会社は必須です。',
            'company.max'        => '返却追跡会社は100文字以内です。',
            'number.required'    => '返却追跡番号は必須です。',
            'number.max'         => '返却追跡番号は20文字以内です。',
            'date.required'      => '返却予定日は必須です。',
            'staff.required'    => '担当者は必須です。',
            'target_id.required' => '出金リクエストは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.return'))
            ->withErrors($validator)
            ->withInput();
        }

            // staff_id
            // status：1
            // memo：

        // １．返却情報（ships）に登録
            // company：テキスト
            // number：テキスト
            // estimated_arrival_at：日付


        // 対象の商品リクエストIDを取得
        $request_id = $request['target_id'];

        // 対象の商品リクエスト情報を取得する
        $itemRequestsInstance = new ItemRequest;
        $itemRequest = ItemRequest::where('id', '=', $request_id)->first();

        // 対象の商品を取得する
        $item = Item::where('id', $itemRequest['item_id'])->first();

        // 返却情報のインスタンス作成
        $shipInstance = new Ship;

        // DBトランザクションで、「商品リクエスト完了」と「返却情報登録」を同時に行う
        // 今日の日付を取得
        $today = Carbon::now();
        DB::beginTransaction();
        try {
            // 商品のステータス変更
            $item->status  = 9;
            $item->request = 0;
            $item->save();

            // 商品リクエストのdecision_atの日付を更新
            $itemRequest->decision_at = $today;
            $itemRequest->save();

            // 返却情報（ships）に登録する
            $params['item_id']              = $itemRequest['item_id'];
            $params['request_id']           = $itemRequest['id'];
            $params['company']              = $request['company'];
            $params['number']               = $request['number'];
            $params['estimated_arrival_at'] = $request['date'];

            $shipInstance->create($params);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = '返却リクエスト承認処理の失敗しました。';
            return back()->withInput()->withErrors($error);
        }
        return redirect(route('admin.request.return'))->with('success-message', '返却リクエスト承認処理が成功しました。');
    }

    /**
     * 返却リクエスト 非承認手続き
     *
     * @return view
     */
    public function returnRequestReject(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'staff'    => 'required',
            'reject_id' => 'required',
            'reason'    => 'max:1000',
            'memo'      => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'reject_id.required' => '出金リクエストは必須です。',
            'reason.max'         => '非承認理由は1000文字以内です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.return'))
            ->withErrors($validator)
            ->withInput();
        }

        // 返却リクエストを更新処理
        $itemRequest = ItemRequest::where('id', $request['reject_id'])->first();

        // 対象の商品を取得する
        $item = Item::where('id', $itemRequest['item_id'])->first();

        // 今日の日付
        $today = Carbon::now();
        DB::beginTransaction();
        try {
            // 商品のステータス変更
            $item->status  = 0;
            $item->request = 0;
            $item->save();

            // アイテムリクエスト非承認処理
            $itemRequest->decision_at = $today;
            $itemRequest->staff_id   = $request['staff'];
            $itemRequest->reason      = $request['reason'];
            $itemRequest->memo        = $request['memo'];
            $itemRequest->type        = 2;
            $itemRequest->save();
            DB::commit();
            return redirect(route('admin.request.return'))->with('success-message', '返却リクエスト非承認処理が成功しました。');
        } catch (\Exception $e) {
            DB::rollback();
            $error = '返却リクエスト非承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    // /**
    //  * 返却リクエスト 詳細
    //  *
    //  * @return view
    //  */
    // public function returnDetailResult() {
    //     return view('admin.request.returnDetail');
    // }

    /**
     * 販売代行リクエスト
     *
     * @return view
     */
    public function salesRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 荷物リクエストの中から、販売代行リクエスト（0）の一覧を取得
        $itemRequestInstance = new ItemRequest;
        $itemRequests = $itemRequestInstance->indexOfTypeWithUser(0);

        // 担当者一覧を取得
        $staffInstance = new staff;
        $staffs = Staff::get();

        return view('admin.request.sales', compact('itemRequests', 'staffs'));
    }

    /**
     * 販売代行リクエスト POST
     *
     * @return view
     */
    public function salesRequestPost(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'selling_price' => 'required|max:100',
            'date'          => 'required|max:20',
            'url'           => 'required',
            'staff'        => 'required',
            'target_id'     => 'required',
            'memo'          => 'max:1000',
        ];
        $message = [
            'company.required'   => '返却郵送会社は必須です。',
            'company.max'        => '返却追跡会社は100文字以内です。',
            'number.required'    => '返却追跡番号は必須です。',
            'number.max'         => '返却追跡番号は20文字以内です。',
            'date.required'      => '返却予定日は必須です。',
            'staff.required'    => '担当者は必須です。',
            'target_id.required' => '出金リクエストは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.sales'))
            ->withErrors($validator)
            ->withInput();
        }

        // 販売代行処理
        // 商品リクエスト更新処理に必要な情報
        $itemRequest = ItemRequest::where('id', $request['target_id'])->first();
        $today = Carbon::now();

        // 商品更新処理に必要な情報
        $item = Item::where('id', $itemRequest['item_id'])->first();

        // 販売代行処理に必要な情報
        $sellInstance = new Sell;

        DB::beginTransaction();
        try {
            // 商品リクエスト更新処理
            $itemRequest->status      = 1;
            $itemRequest->memo        = $request['memo'];
            $itemRequest->decision_at = $today;
            $itemRequest->save();

            // 商品更新処理
            $item->status  = 1;
            $item->request = 0;
            $item->save();

            // 販売代行処理
            $params['item_id']          = $item['id'];
            $params['staff_id']        = $request['staff'];
            $params['start_request_id'] = $itemRequest['id'];
            // $params['asking_price']     = $itemRequest['request_sell'];
            $params['selling_price']    = $request['selling_price'];
            $params['selling_day']      = $request['date'];
            $params['url']              = $request['url'];

            $sellInstance->create($params);
            DB::commit();
            return redirect(route('admin.request.sales'))->with('success-message', '販売リクエスト承認処理が成功しました。');
        } catch (\Exception $e) {
            DB::rollback();
            $error = '販売リクエスト承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * 販売代行リクエスト reject
     *
     * @return view
     */
    public function salesRequestReject(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'staff'        => 'required',
            'reject_id'     => 'required',
            'reason'        => 'max:1000',
            'memo'          => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'reject_id.required' => '販売代行リクエストは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
            'reason.max'         => '非承認理由は1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.sales'))
            ->withErrors($validator)
            ->withInput();
        }

        // 商品リクエスト更新処理に必要な情報
        $itemRequest = ItemRequest::where('id', $request['reject_id'])->first();
        $today = Carbon::now();

        // 商品更新処理に必要な情報
        $item = Item::where('id', $itemRequest['item_id'])->first();

        DB::beginTransaction();
        try {
            $itemRequest = ItemRequest::where('id', $request['reject_id'])->first();

            $itemRequest->status = 2;
            $itemRequest->reason = $request['reason'];
            $itemRequest->memo = $request['memo'];
            $itemRequest->decision_at = $today;
            $itemRequest->save();

            $item->status  = 0;
            $item->request = 0;
            $item->save();
            DB::commit();
            return redirect(route('admin.request.sales'))->with('success-message', '販売リクエスト非承認処理が成功しました。');
        } catch (\Exception $e) {
            DB::rollback();
            $error = '販売リクエスト非承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * レンタル出品リクエスト
     *
     * @return view
     */
    public function rentalRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 荷物リクエストの中から、販売代行リクエスト（0）の一覧を取得
        $itemRequestInstance = new ItemRequest;
        $itemRequests = $itemRequestInstance->indexOfTypeWithUser(1);

        // 担当者一覧を取得
        $staffInstance = new staff;
        $staffs = Staff::get();

        return view('admin.request.rental', compact('itemRequests', 'staffs'));
    }

    /**
     * レンタル出品リクエスト
     *
     * @return view
     */
    public function rentalRequestPost(Request $request)
    {
        // dd($request->all());
        // バリデーションチェック
        $rulus = [
            'name'      => 'required|max:255',
            'detail'    => 'required|max:1000',
            'img1'      => 'required|image|mimes:jpeg,png,jpg,gif|max:10485760',
            'staff'    => 'required',
            'target_id' => 'required',
            'memo'      => 'max:1000',
        ];
        if($request['img2']) {
            $rulus[] = [
                'img2' => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            ];
        }
        if($request['img3']) {
            $rulus[] = [
                'img3' => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            ];
        }
        if($request['img4']) {
            $rulus[] = [
                'img4' => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            ];
        }
        if($request['img5']) {
            $rulus[] = [
                'img5' => 'image|mimes:jpeg,png,jpg,gif|max:10485760',
            ];
        }
        $message = [
            'name.max'           => 'メモは1000文字以内です。',
            'name.required'      => '商品名は必須です。',
            'detail.max'         => 'メモは1000文字以内です。',
            'detail.required'    => '商品詳細は必須です。',
            'img1.required'      => '1枚以上の画像の登録が必要です。',
            'img1.image'         => '1枚目の画像が、指定されたファイルではありません。',
            'img1.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img1.max'           => '1枚目の画像サイズが10Mを超えています。',
            'img2.image'         => '2枚目の画像が、指定されたファイルではありません。',
            'img2.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img2.max'           => '2枚目の画像サイズが10Mを超えています。',
            'img3.image'         => '3枚目の画像が、指定されたファイルではありません。',
            'img3.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img3.max'           => '3枚目の画像サイズが10Mを超えています。',
            'img4.image'         => '4枚目の画像が、指定されたファイルではありません。',
            'img4.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img4.max'           => '4枚目の画像サイズが10Mを超えています。',
            'img5.image'         => '5枚目の画像が、指定されたファイルではありません。',
            'img5.mimes'         => '画像ファイルはjpeg,png,jpg,gifのみです。',
            'img5.max'           => '5枚目の画像サイズが10Mを超えています。',
            'staff.required'    => '担当者は必須です。',
            'target_id.required' => 'レンタル出品リクエストは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.rental'))
            ->withErrors($validator)
            ->withInput();
        }

        // 販売代行処理
        // 荷物リクエスト更新処理に必要な情報
        $itemRequest = ItemRequest::where('id', $request['target_id'])->first();
        $today = Carbon::now();

        // 荷物更新処理に必要な情報
        $item = Item::where('id', $itemRequest['item_id'])->first();

        // レンタル荷物処理に必要な情報
        $rentalInstance = new Rental;
        $rentalImageInstance = new RentalImage;
        DB::beginTransaction();
        try {
            // 荷物リクエスト更新処理（レンタル中に変換）
            $itemRequest->status      = 1;
            $itemRequest->staff_id   = $request['staff'];
            $itemRequest->memo        = $request['memo'];
            $itemRequest->decision_at = $today;
            $itemRequest->save();

            // 荷物更新処理
            $item->status  = 2;
            $item->request = 0;
            $item->save();

            // レンタル荷物登録処理
            $params['item_id']          = $itemRequest['item_id'];
            $params['start_request_id'] = $itemRequest['id'];
            $params['price']            = $itemRequest['request_rental'];
            $params['name']             = $request['name'];
            $params['detail']           = $request['detail'];
            $rentalInstance->create($params);

            // レンタル荷物登録後のIDを取得
            $last_id = DB::getPdo()->lastInsertId();
            // レンタル商品画像の登録
            $paths[] = $request['img1']->store('storage/app/public/img/rentals');
            if($request['img2']) {
                $paths[] = $request['img2']->store('/storage/app/public/img/rentals');
            };
            if($request['img3']) {
                $paths[] = $request['img3']->store('/storage/app/public/img/rentals');
            };
            if($request['img4']) {
                $paths[] = $request['img4']->store('/storage/app/public/img/rentals');
            };
            if($request['img5']) {
                $paths[] = $request['img5']->store('/storage/app/public/img/rentals');
            };
            foreach($paths as $path) {
                $image_params['rental_id'] = $last_id;
                $image_params['url']       = $path;
                $rentalImageInstance->create($image_params);
            }
            DB::commit();
            return redirect(route('admin.request.rental'))->with('success-message', 'レンタルリクエスト承認処理が成功しました。');
        } catch(\Exception $e) {
            DB::rollback();
            $error = 'レンタルリクエスト承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
        return view('admin.request.rental');
    }

    /**
     * レンタル出品リクエスト 非承認 - reject
     *
     * @return view
     */
    public function rentalRequestReject(Request $request)
    {
        // バリデーションチェック
        $rulus = [
            'staff'    => 'required',
            'reject_id' => 'required',
            'reason'    => 'max:1000',
            'memo'      => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'reject_id.required' => '出金リクエストは必須です。',
            'reason.max'         => '非承認理由は1000文字以内です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.request.rental'))
            ->withErrors($validator)
            ->withInput();
        }

        // レンタルリクエストを更新処理
        $itemRequest = ItemRequest::where('id', $request['reject_id'])->first();

        // 対象の荷物を取得する
        $item = Item::where('id', $itemRequest['item_id'])->first();

        // 今日の日付
        $today = Carbon::now();
        DB::beginTransaction();
        try {
            // 荷物のステータス変更
            $item->status  = 0;
            $item->request = 0;
            $item->save();

            // レンタくリクエスト非承認処理
            $itemRequest->decision_at = $today;
            $itemRequest->staff_id   = $request['staff'];
            $itemRequest->reason      = $request['reason'];
            $itemRequest->memo        = $request['memo'];
            $itemRequest->type        = 2;
            $itemRequest->save();
            DB::commit();
            return redirect(route('admin.request.rental'))->with('success-message', 'レンタルリクエスト非承認処理が成功しました。');
        } catch (\Exception $e) {
            DB::rollback();
            $error = 'レンタルリクエスト非承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * 販売代行出品停止リクエスト
     *
     * @return view
     */
    public function salesStopRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 荷物リクエストの中から、販売代行停止リクエスト（8）の一覧を取得
        $itemRequestInstance = new ItemRequest;
        $itemRequests = $itemRequestInstance->indexOfTypeWithUser(8);

        // 担当者一覧を取得
        $staffInstance = new staff;
        $staffs = Staff::get();
        return view('admin.request.stopSales', compact('itemRequests', 'staffs'));
    }

    // /**
    //  * 販売代行出品停止リクエスト 承認 - POST
    //  *
    //  * @return view
    //  */
    // public function salesStopRequestPost(Request $request)
    // {
    //     // バリデーションチェック
    //     $rulus = [
    //         'staff'        => 'required',
    //         'target_id'     => 'required',
    //         'memo'          => 'max:1000',
    //     ];
    //     $message = [
    //         'staff.required'    => '担当者は必須です。',
    //         'target_id.required' => '出金リクエストは必須です。',
    //         'memo.max'           => 'メモは1000文字以内です。',
    //     ];
    //     $validator = Validator::make($request->all(), $rulus, $message);
    //     if ($validator->fails()) {
    //         return redirect(route('admin.stop.request.sales'))
    //         ->withErrors($validator)
    //         ->withInput();
    //     }

    //     // レンタルリクエスト更新処理に必要な情報を取得する
    //     $itemRequest = ItemRequest::where('id', $request['target_id'])->first();

    //     // 対象の荷物を取得する
    //     $item = Item::where('id', $itemRequest['item_id'])->first();

    //     // 販売代行情報を取得する
    //     $sell = Sell::where('item_id', $itemRequest['item_id'])->whereNull('stop_request_id')->whereNull('sale_id')->whereNull('deleted_at')->first();

    //     // 今日の日付
    //     $today = Carbon::now();
    //     DB::beginTransaction();
    //     try {
    //         // 販売代行停止リクエスト
    //         // １．荷物情報の更新
    //         $item->status  = 0;
    //         $item->request = 0;
    //         $item->save();

    //         // ２．荷物リクエストの更新
    //         $itemRequest->staff_id = $request['staff'];
    //         $itemRequest->decision_at = $today;
    //         $itemRequest->memo = $request['memo'];
    //         $itemRequest->save();
    //         $itemRequest->delete();

    //         // ３．販売代行情報の更新
    //         $sell->stop_request_id = $itemRequest['id'];
    //         $sell->item_id = $itemRequest['item_id'];
    //         $sell->save();
    //         $sell->delete();
    //         DB::commit();
    //         return redirect(route('admin.stop.request.sales'))->with('success-message', '販売停止リクエスト承認処理が成功しました。');
    //     } catch(\Exception $e) {
    //         DB::rollback();
    //         $error = '販売停止リクエスト承認処理に失敗しました。';
    //         return back()->withInput()->withErrors($error);
    //     }
    // }

    // /**
    //  * 販売代行出品停止リクエスト 非承認 - reject
    //  *
    //  * @return view
    //  */
    // public function salesStopRequestReject(RejectItemRequest $request)
    // {
    //     $validated = $request->validated();

    //     // 荷物リクエスト情報を取得する
    //     $itemRequest = ItemRequest::where('id', $validated['reject_id'])->first();
    //     // $itemRequest = ItemRequest::find($validated['reject_id']);
    //     // dd($itemRequest);


    //     // 荷物情報を取得する
    //     $itemId = $itemRequest['item_id'];
    //     // dd($itemRequest['id']);
    //     // $item = Item::find($itemRequest['id']);
    //     $item = Item::where('items.id', $itemId)->first();
    //     // dd($item);

    //     // 今日の日付
    //     $today = Carbon::now();

    //     // 販売代行停止リクエスト
    //     DB::beginTransaction();
    //     try {
    //         // １．荷物情報を更新
    //         $item->request = 0;
    //         $item->save();

    //         // ２．荷物リクエスト情報を更新
    //         $itemRequest->status = 2;
    //         $itemRequest->decision_at = $today;
    //         $itemRequest->save();
    //         $itemRequest->delete();

    //         DB::commit();
    //         return redirect(route('admin.stop.request.sales'))->with('success-message', '販売停止リクエスト非承認処理が成功しました。');
    //     } catch(\Exception $e) {
    //         DB::rollback();
    //         $error = '販売停止リクエスト非承認処理に失敗しました。';
    //         return back()->withInput()->withErrors($error);
    //     }
    // }

    /**
     * レンタル出品停止リクエスト
     *
     * @return view
     */
    public function rentalStopRequest()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 荷物リクエストの中から、レンタル出品停止リクエスト（8）の一覧を取得
        $itemRequestInstance = new ItemRequest;
        $itemRequests = $itemRequestInstance->indexOfTypeWithUser(9);

        // 担当者一覧を取得
        $staffs = Staff::get();
        return view('admin.request.stopRental', compact('itemRequests', 'staffs'));
    }

    /**
     * レンタル出品停止リクエスト 承認 - post
     *
     * @return view
     */
    public function rentalStopRequestPost(PermitItemRequest $request)
    {
        // バリデーション済みアイテム
        $validated = $request->validated();

        // 荷物リクエストの情報を取得
        $itemRequest = ItemRequest::find($validated['target_id']);

        // 対象の荷物を取得する
        $item = Item::find($itemRequest['item_id']);

        // 対象の荷物出品情報を取得する
        $rental = Rental::where('item_id', $item['id'])->whereNull('stop_request_id')->whereNull('deleted_at')->first();

        // 今日の日付
        $today = Carbon::now();
        DB::beginTransaction();
        try {
            // 荷物リクエスト更新処理
            $itemRequest->status      = 1; // 状態
            $itemRequest->staff_id   = $validated['staff']; // 担当者
            $itemRequest->memo        = $validated['memo']; // メモ
            $itemRequest->decision_at = $today; // 更新日
            $itemRequest->save();
            $itemRequest->delete(); // ソフトデリート


            // 荷物更新処理
            $item->status  = 0; // ステータス
            $item->request = 0; // リクエスト
            $item->save();

            // 荷物出品情報更新処理
            $rental->stop_request_id = $itemRequest['id']; // 停止リクエスト
            $rental->save();
            $rental->delete(); // ソフトデリート
            DB::commit();
            return redirect(route('admin.stop.request.rental'))->with('success-message', 'レンタル停止リクエスト承認処理が成功しました。');
        } catch(\Exception $e) {
            DB::rollback();
            $error = 'レンタル停止リクエスト承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * レンタル出品停止リクエスト 非承認 - reject
     *
     * @return view
     */
    public function rentalStopRequestReject(RejectItemRequest $request)
    {
        $validated = $request->validated();

        // 荷物リクエスト情報を取得する
        $itemRequest = ItemRequest::find($validated['reject_id']);

        // 荷物情報を取得する
        $item = Item::find($itemRequest['item_id']);

        // 今日の日付
        $today = Carbon::now();

        // 販売代行停止リクエスト
        DB::beginTransaction();
        try {
            // １．荷物情報を更新
            $item->request = 0;
            $item->save();

            // ２．荷物リクエスト情報を更新
            $itemRequest->status        = 2;
            $itemRequest->decision_at   = $today;
            $itemRequest->reason        = $validated['reason'];
            $itemRequest->memo          = $validated['memo'];
            $itemRequest->save();
            $itemRequest->delete();

            DB::commit();
            return redirect(route('admin.stop.request.rental'))->with('success-message', 'レンタル停止リクエスト非承認処理が成功しました。');
        } catch(\Exception $e) {
            DB::rollback();
            $error = 'レンタル停止リクエスト非承認処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * ユーザー一覧
     *
     * @return view
     */
    public function userList()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // ユーザー一覧を取得
        $userInstance = new User;
        $users = $userInstance->userList();

        // 担当者一覧を取得
        // $staffInstance = new staff;
        // $staffs = Staff::get();
        return view('admin.list.user', compact('users'));
    }

    /**
     * ユーザー詳細
     *
     * @return view
     */
    public function userShow($id)
    {
        $user = User::find($id);
        return view('admin.show.user', compact('user'));
    }

    /**
     * ユーザー一時停止
     *
     * @return view
     */
    public function userEditStop(Request $request)
    {
        $id = $request['user_id'];
        $user = User::find($id)->delete();
        return redirect(route('admin.list.user'))->with('success-message', 'ユーザーの削除が完了しました。');
    }

    /**
     * 支店 一覧
     *
     * @return view
     */
    public function shopList()
    {
        // ログインしている管理者のIDを取得
        // $managerId = Auth::guard('manager')->user()->id;

        // 支店一覧を取得
        $shops = Shop::get();
        return view('admin.list.shop', compact('shops'));
    }

    /**
     * 支店 追加
     *
     * @return view
     */
    public function shopAdd()
    {
        // 担当者と紐づく管理者情報
        $managerId = Auth::guard('manager')->user()->id;
        return view('admin.add.shop', compact('managerId'));
    }

    /**s
     * 支店 追加 POST
     *
     * @return view
     */
    public function shopAddPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:shops|max:255',
            'phone_number' => 'required|unique:shops|max:15',
            'name' => 'required',
            'postcode' => 'required',
            'city' => 'required',
            'block' => 'required',
        ]);
        $shopInstance = new shop;
        
        $shopInstance->shopAdd($validated);
        // 担当者と紐づく管理者情報
        return redirect(route('admin.list.shop'))->with('success-message', '支店を追加しました。');
    }

    /**
     * 支店 削除
     *
     * @return view
     */
    public function shopEditStop(Request $request)
    {
        $shop = Shop::where('id', $request['target_id'])->first();
        $shop->staffs->each->boxes->each->items->each->delete();
        $shop->staffs->each->boxes->each->delete();
        $shop->staffs->each->delete();
        $shop->delete();
        return redirect(route('admin.list.shop'))->with('success-message', '支店の削除に成功しました。');
    }

    /**
     * 担当者一覧
     *
     * @return view
     */
    public function staffList()
    {
        $managerId = Auth::guard('manager')->user()->id;
        $staffs = Staff::get();
        return view('admin.list.staff', compact('staffs'));
    }

    /**
     * 担当者追加
     *
     * @return view
     */
    public function staffAdd()
    {
        // 担当者と紐づく管理者情報
        $managerId = Auth::guard('manager')->user()->id;
        $shops = Shop::get();
        return view('admin.add.staff', compact('managerId','shops'));
    }

    /**
     * 担当者追加 POST
     *
     * @return view
     */
    public function staffAddPost(Request $request)
    {
        $requests = $request->all();
        $staffInstance = new staff;
        $check = Staff::where('email',$request->get('email'))->get();
        if($check->isEmpty()){
            $staffInstance->staffAdd($requests);
        }
        return redirect(route('admin.list.staff'))->with('success-message', '担当者を追加しました。');
    }

    /**
     * 担当者 削除
     *
     * @return view
     */
    public function staffEditStop(Request $request)
    {
        $staff = Staff::where('id', $request['target_id'])->first();
        $staff->boxes->each->items->each->delete();
        $staff->boxes->each->delete();
        $staff->delete();
        return back()->with('success-message', '担当者の削除に成功しました。');
    }

    // /**
    //  * ユーザー削除
    //  *
    //  * @return view
    //  */
    // public function userEditDelete($id)
    // {
    //     $user = User::find($id);
    //     return view('admin.show.user', compact('user'));
    // }

    /**
     * 保管箱一覧
     *
     * @return view
     */
    public function boxList()
    {
        $boxInstance = new Box;
        $boxes = $boxInstance->boxItemList();
        return view('admin.list.box', compact('boxes'));
    }

    /**
     * 保管箱詳細
     *
     * @return view
     */
    public function boxShow($id)
    {
        try{
            $box = Box::where('id',$id)->first();
            $items = Item::where('box_id',$id)->get();

            // // 支店一覧を取得
            // $shops = Shop::get();
            // $staffs = Staff::get();

            // レンタルユーザー一覧を取得
            $rentals = RentalUser::all();

            // foreach($items as $item) {
            //     dd($item->oldestImage());
            //     // $img_url = ItemImage::where('item_id',$item->id)->first('image_url');
            //     // $item->item_url = $img_url['image_url'];
            // }
            
        }catch(\Exception $e) {
            $box = $items = $rentals = [];
        }
        return view('admin.show.box', compact('box', 'items', 'rentals'));
    }

    /**
     * 保管箱追加
     *
     * @return view
     */
    public function boxAdd()
    {
        $users = User::get();
        $staffs = Staff::get();
        return view('admin.add.box', compact('users','staffs'));
    }

    /**
     * 保管箱追加 POST
     *
     * @return view
     */
    public function boxAddPost(Request $request)
    {
        $requests = $request->all();
        $boxInstance = new Box;
        $boxInstance->boxAddOfUser($requests);
        return redirect(route('admin.list.box'))->with('success-message', '箱を追加しました。');
    }

    /**
     * 保管箱 削除
     *
     * @return view
     */
    public function boxEditStop(Request $request)
    {
        $id = $request['delete_id'];
        $box = Box::where('id',$id)->first();
        $box->items->each->delete();
        $box->delete();
        return redirect(route('admin.list.box'));
    }

    /**
     * 荷物 一覧
     *
     * @return view
     */
    public function itemList()
    {
        // 荷物一覧
        $items = Item::get();
        
        // 支店一覧を取得
        // $shops = Shop::where('shops.manager_id', $managerId)->get();

        // 担当者一覧を取得
        // $staffInstance = new staff;
        // $staffs = Staff::get();
        // レンタルユーザー一覧を取得
        $rentals = RentalUser::all();
        return view('admin.list.item', compact('items', 'rentals'));
    }

    /**
     * 荷物 詳細
     *
     * @return view
     */
    public function itemShow($id)
    {
        // インスタンス
        try{
            $itemInstance = new Item;
            $itemImageInstance = new ItemImage;

            // 荷物を取得
            $item = $itemInstance->itemShow($id);
            // 荷物の画像を取得
            $itemImages = $itemImageInstance->itemImageList($id);
            // 支店一覧を取得
            // $managerId = Auth::guard('manager')->user()->id;
            // $shops = Shop::where('shops.manager_id', $managerId)->get();
            $shop = Shop::where('id', $item->shop_id)->get();
            $staff = Staff::where('id', $item->staff_id)->get();

            $shops = Shop::get();
            $staffs = Staff::get();
            // 担当者一覧を取得
            // $staffInstance = new staff;
            // $staffs = Staff::get();
        }catch(\Exception $e) {
            $item = $itemImages = $staffs = $shops = $shop = $staff = [];
        }
        

        return view('admin.show.item', compact('item', 'itemImages', 'staffs', 'shops','shop','staff'));
    }

    /**
     * 荷物 削除
     *
     * @return view
     */
    public function itemEditStop(Request $request)
    {
        $id = $request['delete_id'];
        Item::where('id', $id)->delete();
        return redirect(route('admin.list.item'))->with('success-message', 'アイテムの削除が完了しました。');
    }

    /**
     * 荷物 変更保存
     *
     * @return view
     */
    public function itemEditStore(StoreItemRequest $request)
    {
        // バリデーションの値を取得
        $validated = $request->validated();
        // 荷物ID
        $itemId = $request['item_id'];

        // インスタンス
        $itemInstance = new Item;
        $itemImageInstance = new ItemImage;

        // 荷物の元情報を取得
        $item = $itemInstance->itemShow($itemId);

        // 荷物画像の元情報を取得
        $itemImages = $itemImageInstance->itemImageList($itemId);
        // dd($validated);
        // if(isset($validated['img4']) && !(isset($itemImages[4]))) {
        //     dd('OK');
        // } else {
        //     dd('NG');
        // }
        // DB::beginTransaction();
        try {
            // 荷物の更新
            $params['box_id'] = $request['box_id'];
            if($request['how'] == "1") {
                $params['storage'] = 'ハンガー';
            }else {
                $params['storage'] = '箱';
            }
            $params['memo'] = $request['memo'];
            $params['received_on'] = date("Y-m-d H:i:s");

            $item = Item::where('id',$itemId)->update($params); 

            // $item->where('id',$itemId)->update($validated);
            // 画像を全て登録
            $itemImageInstance = new ItemImage;
            $itemImageInstance->itemImageStore($validated, $itemId);
            // $paths[] = '';
            // for($i = 0; $i < 5; $i++) {
            //     if(isset($request['img' . $i + 1]) && isset($itemImages[$i])) {
            //         // 新しい画像データがあり、既に登録ずみの場合
            //         $validated['img' . $i + 1]->store('/public/img/items');
            //         $itemImages[$i]['url'] = '/storage/img/items/' . $validated['img' . $i + 1]->hashName();
            //     } elseif(isset($validated['img' . $i + 1]) && !(isset($itemImages[$i]))) {
            //         // 新しい画像データがあり、登録情報がない場合]
            //         $validated['img' . $i + 1]->store('/public/img/items');
            //         $paths[] = '/storage/img/items/' . $validated['img' . $i + 1]->hashName();
            //     } 
            // };

            // // 画像を更新する
            // // dd($itemImages->isDirty());
            // foreach($itemImages as $itemImage) {
            //     $itemImage->save();
            // }

            // // 未登録の画像を追加する
            // if($paths) {
            //     foreach($paths as $index => $path) {
            //         if($path) {
            //             $params['item_id']     = $itemId;
            //             $params['url']         = $path;
            //             ItemImage::create($params);
            //         }
            //     };
            // } else {}
            // DB::commit();
            return back()->with('success-message', '更新が完了しました。');
        } catch(\Exception $e) {
            DB::rollback();
            $error = '更新に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * 荷物 追加
     *
     * @return view
     */
    public function itemAddPost(Request $request)
    {
        // バリデーションの値を取得
        $validated = $request->all();
        // インスタンス
        $itemInstance = new Item;
        $itemImageInstance = new ItemImage;
        // DB::beginTransaction();
        try {
            // 荷物追加処理
            $item_id = $itemInstance->itemStore($validated);
            // $lastID = DB::getPdo()->lastInsertId();

            // 荷物画像 追加処理(item_images)
            $itemImageInstance->itemImageStore($validated, $item_id);

            // DB::commit();
            return back()->with('success-message', '荷物の追加に成功しました。');
        } catch(\Exception $e) {dd($e->getMessage());
            DB::rollback();
            $error = '荷物の追加に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
    }

    /**
     * 保管荷物 売却完了
     *
     * @return view
     */
    public function itemEditSold(SoldItemRequest $request)
    // public function itemEditSold(Request $request)
    {
        // バリデーションの値を取得
        $validated = $request->validated();

        // インスタンス作成
        $itemInstance = new Item;
        $saleInstance = new Sale;
        $sellInstance = new Sell;
        $pointInstance = new Point;

        // [必要情報設定]
        // 利益計算
        $profit = $validated['price'] - $validated['fee'] - $validated['shipping'];

        // 対象の販売代行情報を取得
        $sell = $sellInstance->sellOfItem($validated['sell_id']);

        // 対象の荷物情報を取得
        $item = $itemInstance->itemShowWithUser($sell['item_id']);
        // $item = Item::select([
        //         'items.*',
        //         'users.id as user_id',
        //     ])
        //     ->where('items.id', $validated['sell_id'])
        //     ->leftJoin('boxes', 'boxes.id', '=', 'items.box_id')
        //     ->leftJoin('users', 'users.id', '=', 'boxes.user_id')
        //     ->first();

        // Sell::where('sells.id', $validated['sell_id'])
        //     ->whereNull('deleted_at')
        //     ->whereNull('sale_id')
        //     ->whereNull('stop_request_id')
        //     ->first();

        // 今日から1年後の日付を取得
        $expiration = Carbon::now()->addYear();

        // DBトランザクション
        DB::beginTransaction();
        try {
            // 売却情報(sales) 登録
            $saleParams['staff_id']    = $validated['staff_id'];
            $saleParams['sold_at']      = $validated['date'];
            $saleParams['price']        = $validated['price'];
            $saleParams['fee']          = $validated['fee'];
            $saleParams['shipping']     = $validated['shipping'];
            $saleParams['profit']       = $profit;
            $saleInstance->create($saleParams);
            // 登録情報を取得する
            $lastID = DB::getPdo()->lastInsertId();

            // 荷物情報(items) 更新
            $item->status = 8;
            $item->save();

            // 販売代行情報(sells) 更新
            $sell->sale_id = $lastID;
            $sell->save();

            // ポイント(points) 登録
            $pointParams['user_id']       = $item['user_id'];
            $pointParams['item_id']       = $item['id'];
            $pointParams['reason']        = 1;
            $pointParams['reason_id']     = $lastID;
            $pointParams['point']         = $profit;
            $pointParams['expiration_at'] = $expiration;
            $pointInstance->create($pointParams);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            $error = '売却の登録に失敗しました。';
            return back()->withInput()->withErrors($error);
        }
        return back()->with('success-message', '売却処理が完了しました。');
    }


    /**
     * 保管荷物 販売停止
     *
     * @return view
     */
    public function itemEditSellStop(Request $request)
    {
        // １．受け取った値をバリデーション
        $rulus = [
            'staff'        => 'required',
            'stop_id'       => 'required',
            'memo'          => 'max:1000',
        ];
        $message = [
            'staff.required'    => '担当者は必須です。',
            'stop_id.required'   => '販売停止IDは必須です。',
            'memo.max'           => 'メモは1000文字以内です。',
        ];
        $validator = Validator::make($request->all(), $rulus, $message);
        if ($validator->fails()) {
            return redirect(route('admin.list.sales.item'))
            ->withErrors($validator)
            ->withInput();
        }
        // ２．トランザクションをひく
        DB::beginTransaction();
        try {
            // ３．商品ステータスを変更
            $item = Item::find($request['stop_id']);
            $item->status = 0;
            $item->save();

            // ４．販売代行情報を変更（停止にする）
            $sell = Sell::where('item_id', $request['stop_id'])->whereNull('sale_id')->whereNull('deleted_at')->first();
            $sell->staff_id = $request['staff'];
            $sell->delete();
            $sell->save();

            DB::commit();
            return redirect(route('admin.list.sales.item'))->with('success-message', '販売停止処理が成功しました。');
        } catch(\Exception $e) {
            DB::rollback();
            $error = '販売停止処理に失敗しました。';
            return back()->withInput()->withErrors($error);
        }

        // // バリデーションチェック
        // $rulus = [
        //     'staff'        => 'required',
        //     'target_id'     => 'required',
        //     'memo'          => 'max:1000',
        // ];
        // $message = [
        //     'staff.required'    => '担当者は必須です。',
        //     'target_id.required' => '出金リクエストは必須です。',
        //     'memo.max'           => 'メモは1000文字以内です。',
        // ];
        // $validator = Validator::make($request->all(), $rulus, $message);
        // if ($validator->fails()) {
        //     return redirect(route('admin.list.sales.item'))
        //     ->withErrors($validator)
        //     ->withInput();
        // }

        // // レンタルリクエスト更新処理に必要な情報を取得する
        // $itemRequest = ItemRequest::where('id', $request['target_id'])->first();

        // // 対象の荷物を取得する
        // $item = Item::where('id', $itemRequest['item_id'])->first();

        // // 販売代行情報を取得する
        // $sell = Sell::where('item_id', $itemRequest['item_id'])->whereNull('stop_request_id')->whereNull('sale_id')->whereNull('deleted_at')->first();

        // // 今日の日付
        // $today = Carbon::now();
        // DB::beginTransaction();
        // try {
        //     // 販売代行停止リクエスト
        //     // １．荷物情報の更新
        //     $item->status  = 0;
        //     $item->request = 0;
        //     $item->save();

        //     // ２．荷物リクエストの更新
        //     $itemRequest->staff_id = $request['staff'];
        //     $itemRequest->decision_at = $today;
        //     $itemRequest->memo = $request['memo'];
        //     $itemRequest->save();
        //     $itemRequest->delete();

        //     // ３．販売代行情報の更新
        //     $sell->stop_request_id = $itemRequest['id'];
        //     $sell->item_id = $itemRequest['item_id'];
        //     $sell->save();
        //     $sell->delete();
        //     DB::commit();
        //     return redirect(route('admin.list.sales.item'))->with('success-message', '販売停止処理が成功しました。');
        // } catch(\Exception $e) {
        //     DB::rollback();
        //     $error = '販売停止リクエスト承認処理に失敗しました。';
        //     return back()->withInput()->withErrors($error);
        // }
    }

    /**
     * 保管荷物 レンタル開始
     *
     * @return view
     */
    public function itemEditRental(RentalItemRequest $request)
    {
        // バリデーションの値を取得
        $validated = $request->validated();

        // インスタンス作成
        $itemInstance = new Item;
        $rentalInstance = new Rental;
        $rentalTradeInstance = new RentalTrade;

        // 必要な情報を取得
        // 荷物情報取得
        $item = $itemInstance->itemShowWithUser($validated['rental_id']);
        // レンタル情報取得
        $rental = $rentalInstance->rentalShowOfItem($item->id);

        // トランザクション処理
        DB::beginTransaction();
        try {
            // 荷物情報 更新
            $item->status = 3;
            $item->save();

            // レンタル履歴情報 追加
            $params['rental_id']      = $rental->id;
            $params['rental_user_id'] = $validated['rental_user_id'];
            $params['staff_id']      = $validated['staff_id'];
            $params['start_at']       = $validated['date'];
            $params['finish_at']      = $validated['fin'];
            $rentalTradeInstance->create($params);
            $lastID = DB::getPdo()->lastInsertId();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            $error = 'レンタル開始登録に失敗しました。';
            return back()->withErrors($error);
        }
        return back()->with('success-message', 'レンタル開始リクエストの登録処理が成功しました。');

    }

    /**
     * 保管荷物 レンタル返却完了
     *
     * @return view
     */
    public function itemEditReturn(RentalReturnItemRequest $request)
    {
        // バリデーションの値を取得
        $validated = $request->validated();

        // インスタンス
        $itemInstance = new Item;
        $pointInstance = new Point;
        $rentalInstance = new Rental;
        $rentalTradeInstance = new RentalTrade;

        // 必要情報取得
        // 利益計算
        $profit = $validated['rental_price'] - $validated['rental_fee'];
        // 今日から1年後の日付を取得
        $expiration = Carbon::now()->addYear();
        // 荷物情報を取得
        $item = $itemInstance->itemShowWithUser($validated['return_id']);
        // レンタル情報取得（レンタル履歴情報を取得するため）
        // $rental = $rentalInstance->rentalShowOfItem($item->id);
        // レンタル履歴情報取得
        // $rentalTrade = $rentalTradeInstance->rentalTradeShowOfRental($item->id);

        // レンタル履歴更新
        DB::beginTransaction();
        try {
            // 荷物 更新
            $item->status = 'now_store';
            $item->save();

            // レンタル履歴更新
            // $rentalTrade->return_at = $validated['date'];
            // $rentalTrade->price     = $validated['rental_price'];
            // $rentalTrade->fee       = $validated['rental_fee'];
            // $rentalTrade->save();

            // ポイント(points) 登録
            // $pointParams['user_id']       = $item['user_id'];
            // $pointParams['item_id']       = $item['id'];
            // $pointParams['reason']        = 2;
            // $pointParams['reason_id']     = $rentalTrade['id'];
            // $pointParams['point']         = $profit;
            // $pointParams['expiration_at'] = $expiration;
            // $pointInstance->create($pointParams);

            // DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            $error = 'レンタル返却完了の登録処理に失敗しました。';
            return back()->withErrors($error);
        }
        return back()->with('success-message', 'レンタル返却完了の登録処理が成功しました。');
    }

    /**
     * 販売代行出品中荷物一覧
     *
     * @return view
     */
    public function salesItemList()
    {
        // 販売代行中荷物一覧を取得
        $itemInstance = new Item;
        $sellItems = $itemInstance->itemListSell();

        $staffs = Staff::get();

        return view('admin.list.sales', compact('sellItems','staffs'));
    }

    /**
     * レンタルユーザー一覧
     *
     * @return view
     */
    public function rentalUserList()
    {
        $managerId = Auth::guard('manager')->user()->id;
        // ユーザー一覧を取得
        $rentalUserInstance = new RentalUser;
        $rentalUsers = $rentalUserInstance->rentalUserListOfManager($managerId);

        return view('admin.list.rentalUser', compact('rentalUsers'));
    }

    /**
     * レンタルユーザー詳細
     *
     * @return view
     */
    public function rentalUserShow($id)
    {
        $rentalUser = RentalUser::find($id);
        return view('admin.show.rentalUser', compact('rentalUser'));
    }

    /**
     * レンタルユーザー追加
     *
     * @return view
     */
    public function rentalUserAdd()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        return view('admin.add.rentalUser', compact('managerId'));
    }

    /**
     * レンタルユーザー追加
     *
     * @return view
     */
    public function rentalUserAddPost(StoreRentalUserRequest $request)
    {
        // バリデーションの値を取得
        $validated = $request->validated();

        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // インスタンス
        $rentalUserInstance = new RentalUser;

        try {
            $params['manager_id']   = $managerId;               // 管理者ID
            $params['name1']        = $validated['name1'];      // 苗字
            $params['name2']        = $validated['name2'];      // 名前
            $params['kana1']        = $validated['kana1'];      // 苗字（カナ）
            $params['kana2']        = $validated['kana2'];      // 名前（カナ）
            $params['email']        = $validated['email'];      // メールアドレス
            $params['tel']          = $validated['tel'];        // 電話番号
            $params['post']         = $validated['post'];       // 郵便番号
            $params['address1']     = $validated['address1'];   // 住所1
            $params['address2']     = $validated['address2'];   // 住所2
            $params['memo']         = $validated['memo'];       // メモ
            $rentalUserInstance->create($params);
        } catch(\Exception $e) {
            $error = 'レンタルユーザーの追加に失敗しました。';
            return back()->withErrors($error);
        }
        return redirect(route('admin.list.rental.user'))->with('success-message', 'レンタルユーザー追加が成功しました。');
    }

    /**
     * レンタルユーザー編集
     *
     * @return view
     */
    public function rentalUserEditUpdate(Request $request)
    {
        // 編集するレンタルユーザーを指定する
        $id = $request->id;
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;
        // レンタルユーザー情報を取得
        $rentalUser = RentalUser::find($id);
        return view('admin.update.rentalUser', compact('managerId', 'rentalUser'));
    }

    /**
     * レンタルユーザー編集 POST
     *
     * @return view
     */
    public function rentalUserEditStore(StoreRentalUserRequest $request)
    {
        // バリデーション後の値を取得する
        $validated = $request->validated();

        // レンタルユーザー情報を更新
        $rentalUserInstance = new RentalUser;
        $rentalUserInstance->rentalUserUpdate($validated);

        // レンタルユーザー情報を取得
        $rentalUser = RentalUser::where('id', $validated)->first();
        // $rentalUser = RentalUser::find($validated['id']);
        return redirect(route('admin.show.rental.user', $rentalUser['id'], compact('rentalUser')))->with('success-message', 'レンタルユーザー情報を更新しました。');
    }

    /**
     * レンタルユーザー 削除
     *
     * @return view
     */
    public function rentalUserEditStop(Request $request)
    {
        $id = $request['target_id'];
        try {
            RentalUser::find($id)->delete();
            return redirect(route('admin.list.rental.user'))->with('success-message', 'レンタルユーザーの削除に成功しました。');
        } catch(\Exception $e) {
            $error = 'ユーザーの削除に失敗しました。';
            return back()->withErrors($error);
        }
    }

    /**
     * レンタル荷物一覧
     *
     * @return view
     */
    public function rentalItemList()
    {
        $managerId = Auth::guard('manager')->user()->id;

        // 販売代行中荷物一覧を取得
        $itemInstance = new Item;
        $rentalItems = $itemInstance->itemListRental();
        // dd($sellItems);

        // 担当者一覧を取得
        $staffs = Staff::get();

        // レンタルユーザー一覧を取得
        $rentals = RentalUser::where('id', $managerId)->get();

        return view('admin.list.rental', compact('managerId', 'rentalItems', 'staffs', 'rentals'));
    }

    /**
     * 寄付済み荷物一覧
     *
     * @return view
     */
    public function donateItemList()
    {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;
       
        // 寄付済み荷物一覧を取得
        $itemInstance = new Item;
        $donateItems = $itemInstance->itemListDonate();

        return view('admin.list.donate', compact('donateItems'));
    }

    /**
     * 出金確認
     *
     * @return view
     */
    public function withdrawalHistory() {
        $withdrawalInstance = new WithdrawalRequest;
        $withdrawals = $withdrawalInstance->withdrawalList();
        return view('admin.history.withdrawal', compact('withdrawals'));
    }

    /**
     * 返却履歴
     *
     * @return view
     */
    public function returnHistory() {
        // ログインしている管理者のID
        $managerId = Auth::guard('manager')->user()->id;

        // 返却履歴一覧取得
        $shipInstance = new Ship;
        $ships = $shipInstance->shipList($managerId);
        return view('admin.history.return', compact('ships'));
    }

    /**
     * レンタル履歴
     *
     * @return view
     */
    public function tradeHistory() {
        $rentalTradeInstance = new RentalTrade;
        $rentalTrades = $rentalTradeInstance->rentalTradeIndex();
        return view('admin.history.trade', compact('rentalTrades'));
    }
}

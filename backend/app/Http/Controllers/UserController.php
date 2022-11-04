<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use App\Models\GetPoint;
use App\Models\WithdrawalPoint;
use App\Models\JapanBank;
use App\Models\OtherBank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller,
    Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// バリデーションファイル
// [更新] ユーザーアカウント
use App\Http\Requests\StoreUserRequest;
// [更新] バスワード
use App\Http\Requests\StorePasswordRequest;
// [更新] 銀行情報
use App\Http\Requests\StoreBankRequest;

class UserController extends Controller
{
    /**
     * 取引履歴 一覧（出金 / 販売 / レンタル / 寄付）
     *
     * @return view
     */
    public function tradeIndex()
    {
        $user_id = Auth::user()->id;
        // 取引履歴一覧
        $pointInstance = new GetPoint;
        $trades = $pointInstance->tradeList($user_id);
        // 取引計算結果
        $sum = $pointInstance->tradeHoldPoint($user_id); 
        
        // 出金リクエスト中かどうかを調べる
        $withdrawalInstance = new WithdrawalPoint;
        $now =  $withdrawalInstance->findByID($user_id) ?? '';

        return view('user.trade.index', compact('trades', 'sum', 'now'));
    }

    /**
     * 出金依頼
     *
     * @return view
     */
    public function paymentRequest()
    {
        $user_id = Auth::user()->id;

        // セッション情報を取得
        $sessionInfo = '';
        if(Session::get('form_input')) {
            $sessionInfo = Session::get('form_input');
        }

        // 取引一覧の計算結果から、1,000円刻みの配列を取得（最大値は超えないようにする）
        $pointInstance = new Point;
        $points = $pointInstance->tradeHoldPointSelect($user_id);
        return view('user.payment.request', compact('points', 'sessionInfo'));
    }

    /**
     * 出金依頼 POST
     *
     * @return view
     */
    public function paymentRequestPost(StoreBankRequest $request)
    {
        // 入力した値を、バリデーション済みデータの取得
        $input = $request->validated();

        // form_inputという値で取得
        $request->session()->put("form_input", $input);

        return redirect(route('custody.payment.request.confirm'));
    }

    /**
     * 出金依頼 確認
     *
     * @return view
     */
    public function paymentRequestConfirm(Request $request) {
        // セッションに写し変える
        $input = $request->session()->get("form_input");

        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!$input){
			return redirect(route('custody.payment.request'));
        }
        // 確認画面へリダイレクト
        return view('user.payment.requestConfirm', compact('input'));
    }

    /**
     * 出金依頼 確認 POST
     *
     * @return view
     */
    public function paymentRequestConfirmPost(Request $request)
    {
        // セッションに写し変える
        $input = $request->session()->get("form_input");

        // sessionに情報がない場合、荷物返却リクエスト画面にリダイレクト
        if(!$input){
			return redirect(route('custody.payment.request'));
        }

        // 戻るボタンが押された
        if($request->has("back")){
            return redirect(route('custody.payment.request'))->withInput($input);
        }

        $user_id =  Auth::user()->id;
        $withdrawal = new WithdrawalRequest;
        $japanBank = new JapanBank;
        $otherBank = new OtherBank;
        // DBトランザクション
        DB::beginTransaction();
        try {
            // 条件分岐を行い、ゆうちょ（japan_banks）及びその他銀行（other_banks）のDBに登録する
            if($input['bank_type'] == 0) {
                $params['user_id'] = $user_id;
                $params['mark']    = $input['japan_mark'];
                $params['number']  = $input['japan_number'];
                $params['name']    = $input['japan_name'];
                $japanBank->store($params);
                // $last_id = DB::table('japan_banks')->getPdo()->lastInsertId();
                $lastID = DB::getPdo()->lastInsertId();
            } elseif($input['bank_type'] == 1) {
                $params['user_id']        = $user_id;
                $params['financial_name'] = $input['financial_name'];
                $params['shop_name']    = $input['shop_name'];
                $params['shop_number']  = $input['shop_number'];
                $params['type']           = $input['other_type'];
                $params['number']         = $input['other_number'];
                $params['name']           = $input['other_name'];
                $otherBank->store($params);
                // $last_id = DB::table('other_banks')->getPdo()->lastInsertId();
                $lastID = DB::getPdo()->lastInsertId();
            }
            // 出金リクエスト（withdrawal_requests）に登録する
            $targets['user_id']       = $user_id;
            $targets['bank_type_id']  = $input['bank_type'];
            $targets['bank_id']       = $lastID; // 銀行情報が登録されてから、その情報をもらう
            $targets['price']         = $input['point'];
            $targets['fee']           = $input['fee'];
            $targets['transfer']      = $input['transfer'];
            $withdrawal->store($targets);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withInput();
        }

        // ここでメールを送信するなどを行う

        // セッションを空にする
        $request->session()->forget("form_input");

        // 完了画面にリダイレクト
        return redirect(route('custody.payment.request.complete'));
    }

    /**
     * 出金依頼 完了
     *
     * @return view
     */
    public function paymentRequestComplete() {
        return view('user.payment.requestComplete');
    }

    /**
     * アカウント情報
     *
     * @return view
     */
    public function accountShow() {
        $user = Auth::user();
        return view('user.account.show', compact('user'));
    }

    /**
     * アカウント情報 編集
     *
     * @return view
     */
    public function accountEdit() {
        $user = Auth::user();
        return view('user.account.edit', compact('user'));
    }

    /**
     * アカウント情報 更新
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return Illuminate\Http\Response
     */
    // public function accountUpdate(Validation\UpdateUserRequest $request) {
    public function accountUpdate(StoreUserRequest $request) {
        // バリデーション済みデータの取得
        $validated = $request->validated();

        // 変更内容を保存する
        // １．ユーザー情報を取得する
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        // ２.バリデーションチェック後のデータを、ユーザー情報に上書きする
        $user->last_name = $validated['name1'];
        $user->first_name = $validated['name2'];
        $user->last_name_kana = $validated['kana1'];
        $user->first_name_kana = $validated['kana2'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['tel'];
        $user->postcode = $validated['post'];
        $user->city = $validated['address1'];
        $user->block = $validated['address2'];
        // ３.DBにセーブする
        $user->save();
        
        // サクセスメッセージ付きで元の画面にリダイレクト
        return redirect()->back()->with('success-message', 'ユーザー情報を変更しました。');
    }

    /**
     * アカウント情報 パスワード変更
     *
     * @return view
     */
    public function passwordUpdate() {
        return view('user.account.passwordUpdate');
    }

    /**
     * アカウント情報 パスワード更新
     *
     * @return view
     */
    public function passwordUpdatePost(StorePasswordRequest $request) {
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('update_password_success', 'パスワードを変更しました。');
        // return view('user.account.passwordUpdate');
    }


    /**
     * アカウント情報 退会
     *
     * @return view
     */
    public function withdrawal() {
        return view('user.account.withdrawal');
    }

    /**
     * アカウント情報 退会完了
     *
     * @return view
     */
    public function withdrawalComplete() {
        return view('user.account.withdrawalComplete');
    }
}

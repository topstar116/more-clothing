<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ContactController;

// ログイン ユーザー
use App\Http\Controllers\Auth\LoginController as UserLogin;
use App\Http\Controllers\Auth\RegisterController as UserRegister;
use App\Http\Controllers\Auth\ResetPasswordController as UserResetPassword;
use App\Http\Controllers\Auth\ForgotPasswordController as UserForgotPassword;

// ログイン 管理者
use App\Http\Controllers\AuthManager\LoginController as AdminLogin;
use App\Http\Controllers\AuthManager\RegisterController as AdminRegister;
use App\Http\Controllers\AuthManager\ResetPasswordController as AdminResetPassword;
use App\Http\Controllers\AuthManager\ForgotPasswordController as AdminForgotPassword;
use App\Http\Controllers\Api\v1\ItemImageController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// 共通画面：その他
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('company', [PageController::class, 'company'])->name('company');
// Route::get('faq', [PageController::class, 'faq'])->name('faq');
// Route::get('tokushoho', [PageController::class, 'tokushoho'])->name('tokushoho');
Route::get('terms', [PageController::class, 'terms'])->name('terms');
Route::get('terms-service', [PageController::class, 'termsService'])->name('terms.service');
// Route::get('terms-storage', [PageController::class, 'termsStorage'])->name('terms.storage');
Route::get('terms-agency', [PageController::class, 'termsAgency'])->name('terms.agency');
Route::get('terms-subscription', [PageController::class, 'termsSubscription'])->name('terms.subscription');
Route::get('terms-privacy', [PageController::class, 'termsPrivacy'])->name('terms.privacy');
Route::get('contact-us', [ContactController::class, 'contact'])->name('contact');

// 共通画面：レンタル商品
// Route::get('rental', [RentalController::class, 'index'])->name('rental');
// Route::get('rental/detail/{id}', [RentalController::class, 'show'])->name('rental.detail');

// ベビクロ
Route::get('/baby-clothing', [PageController::class, 'babyclo'])->name('babyclo');

// ログイン周り
Route::get('sign-in', [UserLogin::class, 'showLoginForm'])->name('sign.in');
Route::post('login', [UserLogin::class, 'login'])->name('login');
Route::post('logout', [UserLogin::class, 'logout'])->name('logout');

// パスワードリセット
// Route::get('password-reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::get('password-reset/new/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password-reset/new', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('user-password/reset', [UserForgotPassword::class, 'showLinkRequestForm'])->name('user.password.reset');
Route::post('password-email', [UserForgotPassword::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password-reset/reset/{token}', [UserResetPassword::class, 'showResetForm'])->name('password.reset');
Route::post('password-reset/reset', [UserResetPassword::class, 'reset'])->name('password.update');
Route::get('password-reset/complete', [UserResetPassword::class, 'complete'])->name('password.complete');

// 登録フォーム
Route::get('sign-up', [UserRegister::class, 'showEmailVerifyForm'])->name('email.verify');
Route::post('email-send', [UserRegister::class, 'emailVerify'])->name('email.verify.send');
// Route::get('email-send/complete', [RegisterController::class, 'completeEmailSend'])->name('email.send.complete');
Route::get('sign-up/register/{token}', [UserRegister::class, 'showRegistrationForm'])->name('sign-up.show');
Route::post('sign-up/register/{token}', [UserRegister::class, 'register'])->name('sign-up.store');
Route::get('sign-up/complete', [UserRegister::class, 'completeRegister'])->name('sign-up.complete');

// ユーザー 新規登録
Route::prefix('user-new')->name('user.new.')->group(function () {
    // ユーザー基本情報登録
    Route::get('request', [UserRegister::class, 'requestUser'])->name('request');
    Route::get('register', [UserRegister::class, 'storeUser'])->name('register');
    Route::get('complete', [UserRegister::class, 'completeUser'])->name('complete');
});

// ユーザー パスワードを忘れた方へ
// Route::prefix('user-password')->name('user.password.')->group(function () {
//     Route::get('request', [UserForgotPasswordController::class, 'requestPassword'])->name('request');
//     Route::get('reset', [UserResetPasswordController::class, 'storePassword'])->name('reset');
//     Route::get('complete', [UserResetPasswordController::class, 'completePassword'])->name('complete');
// });

// ユーザー管理画面
Route::prefix('custody')->name('custody.')->group(function () {
    Route::middleware('auth:web')->group(function () {
        // 保管荷物 一覧
        Route::get('box', [BoxController::class, 'index'])->name('box');
        // 保管荷物 商品一覧
        Route::get('box/detail/{id}', [ItemController::class, 'index'])->name('box.detail');
        // 保管荷物 商品詳細
        Route::get('item/detail/{id}', [ItemController::class, 'show'])->name('item.detail');
        Route::post('item/donate', [ItemController::class, 'changeDonate'])->name('item.donate');
        Route::post('item/stop-sell', [ItemController::class, 'itemStopSell'])->name('item.stop.sell');
        Route::post('item/stop-rental', [ItemController::class, 'itemStopRental'])->name('item.stop.rental');

        // 荷物預入リクエスト
        Route::get('box/storage-request', [BoxController::class, 'storageRequest'])->name('storage.request');

        // 商品返却リクエスト
        Route::get('return/request', [ItemController::class, 'returnRequest'])->name('return.request');
        Route::post('return/request', [ItemController::class, 'returnRequestPost'])->name('return.request.post');
        // 商品返却リクエスト 確認
        Route::get('return/request/confirm', [ItemController::class, 'returnRequestConfirm'])->name('return.request.confirm');
        Route::post('return/request/confirm', [ItemController::class, 'returnRequestConfirmPost'])->name('return.request.confirm.post');
        // 商品返却リクエスト 完了
        Route::get('return/request/complete', [ItemController::class, 'returnRequestComplete'])->name('return.request.complete');

        // 販売代行 荷物一覧
        Route::get('sales-agency', [ItemController::class, 'saleIndex'])->name('sales');
        // 販売代行 停止リクエスト
        Route::post('sales-agency/stop-request', [ItemController::class, 'saleStopRequest'])->name('sales.stop.request');
        // 販売代行 停止リクエスト 完了
        // Route::post('sales-agency/stop-request/complete', [ItemController::class, 'saleStopRequestComplete'])->name('sales.stop.request.complete');
        // 販売代行 荷物詳細
        // Route::get('sales-agency/detail/{id}', [ItemController::class, 'saleShow'])->name('sales.detail');
        // 販売代行 リクエスト ステップ1
        Route::get('sales-agency/request', [ItemController::class, 'saleRequest'])->name('sales.request');
        // 販売代行 リクエスト ステップ2
        Route::get('sales-agency/request/step2', [ItemController::class, 'saleRequestTwo'])->name('sales.request.two');
        Route::post('sales-agency/request/step2', [ItemController::class, 'saleRequestTwoPost'])->name('sales.request.two.post');
        // 販売代行 リクエスト 確認
        Route::get('sales-agency/request/confirm', [ItemController::class, 'saleRequestConfirm'])->name('sales.request.confirm');
        Route::post('sales-agency/request/confirm', [ItemController::class, 'saleRequestConfirmPost'])->name('sales.request.confirm.post');
        // 販売代行 リクエスト 完了
        Route::get('sales-agency/request/complete', [ItemController::class, 'salesRequestComplete'])->name('sales.request.complete');

        // レンタル 荷物一覧
        Route::get('rental', [ItemController::class, 'rentalIndex'])->name('rental');
        // レンタル 停止リクエスト
        Route::post('rental/stop-request', [ItemController::class, 'rentalStopRequest'])->name('rental.stop.request');
        // レンタル 荷物詳細
        // Route::get('rental/detail/{id}', [ItemController::class, 'rentalShow'])->name('rental.detail');
        // レンタル 出品リクエスト
        Route::get('rental/request', [ItemController::class, 'rentalRequest'])->name('rental.request');
        // レンタル 出品リクエスト ステップ2
        Route::get('rental/request/step2', [ItemController::class, 'rentalRequestTwo'])->name('rental.request.two');
        Route::post('rental/request/step2', [ItemController::class, 'rentalRequestTwoPost'])->name('rental.request.two.post');
        // レンタル 出品リクエスト 確認
        Route::get('rental/request/confirm', [ItemController::class, 'rentalRequestConfirm'])->name('rental.request.confirm');
        Route::post('rental/request/confirm', [ItemController::class, 'rentalRequestConfirmPost'])->name('rental.request.confirm.post');
        // レンタル 出品リクエスト 完了
        Route::get('rental/request/complete', [ItemController::class, 'rentalRequestComplete'])->name('rental.request.complete');
        // レンタル 停止リクエスト 完了
       //  Route::get('rental/stop-request/complete', [ItemController::class, 'rentalStopRequestComplete'])->name('rental.stop.request.complete');

        // 寄付 リクエスト
        Route::get('donate/request', [ItemController::class, 'donateRequest'])->name('donate.request');
        // 寄付 リクエスト 確認
        Route::get('donate/request/confirm', [ItemController::class, 'donateRequestConfirm'])->name('donate.request.confirm');
        // 寄付 リクエスト 完了
        Route::get('donate/request/complete', [ItemController::class, 'donateRequestComplete'])->name('donate.request.complete');

        // 取引履歴 一覧（出金 / 販売 / レンタル / 寄付）
        Route::get('trade-history', [UserController::class, 'tradeIndex'])->name('trade.history');
        // 取引履歴 詳細
        // Route::get('trade-history/detail/{id}', [UserController::class, 'tradeShow'])->name('trade.history.detail');
        // 出金 リクエスト
        Route::get('payment/request', [UserController::class, 'paymentRequest'])->name('payment.request');
        Route::post('payment/request', [UserController::class, 'paymentRequestPost'])->name('payment.request.post');
        // 出金 リクエスト 確認
        Route::get('payment/request/confirm', [UserController::class, 'paymentRequestConfirm'])->name('payment.request.confirm');
        Route::post('payment/request/confirm', [UserController::class, 'paymentRequestConfirmPost'])->name('payment.request.confirm.post');
        // 出金 リクエスト 完了
        Route::get('payment/request/complete', [UserController::class, 'paymentRequestComplete'])->name('payment.request.complete');

        // アカウント情報 詳細
        Route::get('account', [UserController::class, 'accountShow'])->name('account');
        // アカウント情報 編集
        Route::get('account/edit', [UserController::class, 'accountEdit'])->name('account.edit');
        Route::post('account/update', [UserController::class, 'accountUpdate'])->name('account.update');
        // アカウント情報 パスワード変更
        Route::get('account/password', [UserController::class, 'passwordUpdate'])->name('account.password');
        Route::post('account/password', [UserController::class, 'passwordUpdatePost'])->name('account.password.post');
        // アカウント情報 退会
        Route::get('account/withdrawal', [UserController::class, 'withdrawal'])->name('account.withdrawal');
        Route::post('account/withdrawal', [UserController::class, 'withdrawal'])->name('account.withdrawal');
        // アカウント情報 退会 完了
        Route::get('account/withdrawal/complete', [UserController::class, 'withdrawalComplete'])->name('account.withdrawal.complete');

        // お知らせ 一覧
        Route::get('news', [NewController::class, 'index'])->name('news');
        // お知らせ 詳細
        Route::get('news/detail/{id}', [NewController::class, 'show'])->name('news.detail');
    });
});

// 登録フォーム
Route::get('admin/sign-in', [AdminLogin::class, 'showLoginForm'])->name('admin.sign.in');
Route::post('admin/login', [AdminLogin::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLogin::class, 'logout'])->name('admin.logout');

// 管理者管理画面
// Route::middleware('auth:admin')->group(function () {
// });
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('auth:manager')->group(function () {
        // [リクエスト]
        // 出金リクエスト
        Route::get('request/withdrawal', [AdminController::class, 'withdrawalRequest'])->name('request.withdrawal');
        Route::post('request/withdrawal/post', [AdminController::class, 'withdrawalRequestPost'])->name('request.withdrawal.post');
        Route::post('request/withdrawal/reject', [AdminController::class, 'withdrawalRequestReject'])->name('request.withdrawal.reject');
        // 返却リクエスト
        Route::get('request/return', [AdminController::class, 'returnRequest'])->name('request.return');
        Route::post('request/return/post', [AdminController::class, 'returnRequestPost'])->name('request.return.post');
        Route::post('request/return/reject', [AdminController::class, 'returnRequestReject'])->name('request.return.reject');
        // 返却リクエスト 詳細
        // Route::get('request/return/detail/{id}', [AdminController::class, 'returnDetailResult'])->name('request.return.detail');
        // 販売代行リクエスト
        Route::get('request/sales', [AdminController::class, 'salesRequest'])->name('request.sales');
        Route::post('request/sales/post', [AdminController::class, 'salesRequestPost'])->name('request.sales.post');
        Route::post('request/sales/reject', [AdminController::class, 'salesRequestReject'])->name('request.sales.reject');
        // レンタル出品リクエスト
        Route::get('request/rental', [AdminController::class, 'rentalRequest'])->name('request.rental');
        Route::post('request/rental/post', [AdminController::class, 'rentalRequestPost'])->name('request.rental.post');
        Route::post('request/rental/reject', [AdminController::class, 'rentalRequestReject'])->name('request.rental.reject');

        // [停止リクエスト]
        // 販売代行出品停止リクエスト
        // Route::get('stop-request/sales', [AdminController::class, 'salesStopRequest'])->name('stop.request.sales');
        // Route::post('stop-request/sales/post', [AdminController::class, 'salesStopRequestPost'])->name('stop.request.sales.post');
        // Route::post('stop-request/sales/reject', [AdminController::class, 'salesStopRequestReject'])->name('stop.request.sales.reject');
        // レンタル出品停止リクエスト
        Route::get('stop-request/rental', [AdminController::class, 'rentalStopRequest'])->name('stop.request.rental');
        Route::post('stop-request/rental/post', [AdminController::class, 'rentalStopRequestPost'])->name('stop.request.rental.post');
        Route::post('stop-request/rental/reject', [AdminController::class, 'rentalStopRequestReject'])->name('stop.request.rental.reject');

        // [追加]
        // 箱を追加
        Route::get('add/box', [AdminController::class, 'boxAdd'])->name('add.box');
        Route::post('add/box', [AdminController::class, 'boxAddPost'])->name('add.box.post');
        // 荷物を追加
        Route::post('add/item', [AdminController::class, 'itemAddPost'])->name('add.item.post');
        Route::post('item-image/update/{item_id}', [ItemImageController::class, 'update'])->name('item.update');//image update.
        Route::delete('item-image/delete/{item_id}', [ItemImageController::class, 'delete'])->name('delete');
        // 担当者を追加
        Route::get('add/staff', [AdminController::class, 'staffAdd'])->name('add.staff');
        Route::post('add/staff', [AdminController::class, 'staffAddPost'])->name('add.staff.post');
        // レンタルユーザーを追加
        Route::get('add/rental-user', [AdminController::class, 'rentalUserAdd'])->name('add.rental.user');
        Route::post('add/rental-user', [AdminController::class, 'rentalUserAddPost'])->name('add.rental.user.post');
        // 支店を追加
        Route::get('add/shop', [AdminController::class, 'shopAdd'])->name('add.shop');
        Route::post('add/shop', [AdminController::class, 'shopAddPost'])->name('add.shop.post');

        // [処理]
        // 保管荷物売却完了
        Route::post('list/item/sold', [AdminController::class, 'itemEditSold'])->name('edit.item.sold');
        // 保管荷物販売停止
        Route::post('list/item/sell-stop', [AdminController::class, 'itemEditSellStop'])->name('edit.item.sell.stop');
        // 保管荷物レンタル開始
        Route::post('list/item/rental', [AdminController::class, 'itemEditRental'])->name('edit.item.rental');
        // 保管荷物レンタル返却完了
        Route::post('list/item/return', [AdminController::class, 'itemEditReturn'])->name('edit.item.return');

        // [一覧]
        // ユーザー一覧
        Route::get('list/user', [AdminController::class, 'userList'])->name('list.user');
        Route::get('list/user/{id}', [AdminController::class, 'userShow'])->name('show.user');
        Route::post('list/user/stop', [AdminController::class, 'userEditStop'])->name('edit.user.stop');

        // 担当者一覧
        Route::get('list/staff', [AdminController::class, 'staffList'])->name('list.staff');
        Route::post('list/staff/stop', [AdminController::class, 'staffEditStop'])->name('edit.staff.stop');
        // Route::post('list/user/delete', [AdminController::class, 'userEditDelete'])->name('edit.user.delete');

        // 保管箱一覧
        Route::get('list/box', [AdminController::class, 'boxList'])->name('list.box');
        Route::get('list/box/{id}', [AdminController::class, 'boxShow'])->name('show.box');
        Route::post('list/box/stop', [AdminController::class, 'boxEditStop'])->name('edit.box.stop');

        // 荷物 一覧
        Route::get('list/item', [AdminController::class, 'itemList'])->name('list.item');
        // 荷物 詳細
        Route::get('list/item/{id}', [AdminController::class, 'itemShow'])->name('show.item');
        // 荷物 停止
        Route::post('list/item/stop', [AdminController::class, 'itemEditStop'])->name('edit.item.stop');
        // 荷物 編集
        Route::post('edit/item', [AdminController::class, 'itemEditStore'])->name('edit.item.store');

        // 支店一覧
        Route::get('list/shop', [AdminController::class, 'shopList'])->name('list.shop');
        // 支店詳細
        Route::get('list/shop/{id}', [AdminController::class, 'shopShow'])->name('show.shop');
        // 支店停止
        Route::post('list/shop/stop', [AdminController::class, 'shopEditStop'])->name('edit.shop.stop');
        // 支店編集
        Route::get('edit/shop', [AdminController::class, 'shopEditUpdate'])->name('edit.shop.update');
        Route::post('edit/shop', [AdminController::class, 'shopEditStore'])->name('edit.shop.store');

        // レンタルユーザー一覧
        Route::get('list/rental-user', [AdminController::class, 'rentalUserList'])->name('list.rental.user');
        Route::get('list/rental-user/{id}', [AdminController::class, 'rentalUserShow'])->name('show.rental.user');
        // レンタルユーザー 削除
        Route::post('list/rental-user/stop.', [AdminController::class, 'rentalUserEditStop'])->name('edit.rental.user.stop');
        // レンタルユーザー 編集
        Route::get('edit/rental-user/', [AdminController::class, 'rentalUserEditUpdate'])->name('edit.rental.user.update');
        Route::post('edit/rental-user/', [AdminController::class, 'rentalUserEditStore'])->name('edit.rental.user.store');

        // 販売代行出品中荷物一覧
        Route::get('list/sales-item', [AdminController::class, 'salesItemList'])->name('list.sales.item');
        Route::post('list/sales-item', [AdminController::class, 'salesItemList'])->name('list.sales.item');
        // レンタル荷物一覧
        Route::get('list/rental-item', [AdminController::class, 'rentalItemList'])->name('list.rental.item');
        // 寄付済み荷物一覧
        Route::get('list/donate-item', [AdminController::class, 'donateItemList'])->name('list.donate.item');

        // 履歴
        // 出金履歴
        Route::get('history/withdrawal', [AdminController::class, 'withdrawalHistory'])->name('history.withdrawal');
        // 取引履歴
        Route::get('history/trade', [AdminController::class, 'tradeHistory'])->name('history.trade');
        // 返却履歴
        Route::get('history/return', [AdminController::class, 'returnHistory'])->name('history.return');
    });
});

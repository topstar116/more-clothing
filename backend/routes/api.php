<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\BankController;
use App\Http\Controllers\Api\v1\JapanBankController;
use App\Http\Controllers\Api\v1\OtherBankController;
use App\Http\Controllers\Api\v1\WalletController;
use App\Http\Controllers\Api\v1\GetPointController;
use App\Http\Controllers\Api\v1\WithdrawalPointController;
use App\Http\Controllers\Api\v1\BoxController;
use App\Http\Controllers\Api\v1\ItemController;
use App\Http\Controllers\Api\v1\ItemImageController;
use App\Http\Controllers\Api\v1\RequestReturnController;
use App\Http\Controllers\Api\v1\RequestSaleController;
use App\Http\Controllers\Api\v1\InfoSaleController;
use App\Http\Controllers\Api\v1\InfoRentalController;
use App\Http\Controllers\Api\v1\ShopController;
use App\Http\Controllers\Api\v1\ManagerController;
use App\Http\Controllers\Api\v1\HistoryDonationController;
use App\Http\Controllers\Api\v1\BlogController;
use App\Http\Controllers\Api\v1\StaffController;
use App\Http\Controllers\Api\v1\RenterController;
use App\Http\Controllers\Api\v1\HistoryReturnController;
use App\Http\Controllers\Api\v1\HistoryRentalController;
use App\Http\Controllers\Api\v1\HistorySaleController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {

        //ユーザー仮登録
        Route::post('storeTemporary', [UserController::class, 'storeTemporary'])->name('store.temporary');
        //ユーザー本登録
        Route::post('storeMain', [UserController::class, 'storeMain'])->name('store.main');
        //パスワード再発行用URLリクエスト
        Route::post('requestPassword', [UserController::class, 'requestPassword'])->name('request.password');
        //ユーザーログイン
        Route::post('login', [UserController::class, 'login'])->name('login');
        //ユーザーログアウト
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
    });

    Route::prefix('manager')->name('manager.')->group(function () {
        Route::post('login', [ManagerController::class, 'login'])->name('login');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('v1')->name('v1.')->group(function () {
        Route::prefix('user')->name('user.')->group(function () {

        });
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::prefix('v1')->name('v1.')->group(function () {
            Route::prefix('user')->name('user.')->group(function () {
                //ユーザーのプロフィール更新
                Route::put('updateProfile', [UserController::class, 'updateProfile'])->name('update.profile');
                //ユーザーのパスワード更新
                Route::put('updatePassword', [UserController::class, 'updatePassword'])->name('update.password');
                //ユーザー退会作業
                Route::delete('deleteWithdrawal/{id}', [UserController::class, 'deleteWithdrawal'])->name('delete.Withdrawal');
            });

            Route::prefix('bank')->name('bank.')->group(function () {
                //銀行情報の詳細
                Route::get('show/{bank_id}', [BankController::class, 'show'])->name('show');
                //銀行情報の登録
                Route::post('store', [BankController::class, 'store'])->name('store');
                //銀行情報の論理削除
                Route::delete('delete/{bank_id}', [BankController::class, 'delete'])->name('delete');
            });

            Route::prefix('japanBank')->name('japanBank.')->group(function () {
                //ゆうちょ銀行情報を登録
                Route::post('store', [JapanBankController::class, 'store'])->name('store');
                //ゆうちょ銀行情報を論理削除
                Route::delete('delete/{bank_id}', [JapanBankController::class, 'delete'])->name('delete');
            });
            
            Route::prefix('otherBank')->name('otherBank.')->group(function () {
                //その他銀行情報を登録
                Route::post('store', [OtherBankController::class, 'store'])->name('store');
                //その他銀行情報を論理削除
                Route::delete('delete/{bank_id}', [OtherBankController::class, 'delete'])->name('delete');
            });

            Route::prefix('wallet')->name('wallet.')->group(function () {
                //ユーザーの取引情報一覧（獲得ポイント/失効ポイント/出金ポイント）
                Route::get('index', [WalletController::class, 'index'])->name('index');
                //ユーザーの保有ポイント
                Route::get('indexTotal', [WalletController::class, 'indexTotal'])->name('index.Total');
                //月別のユーザーの保有ポイント
                Route::get('indexByMonth/{month}', [WalletController::class, 'indexByMonth'])->name('index.ByMonth');
                //年別のユーザーの保有ポイント
                Route::get('indexByYear/{year}', [WalletController::class, 'indexByYear'])->name('index.ByYear');
                //ウォレットを論理削除
                Route::delete('delete/{user_id}', [WalletController::class, 'delete'])->name('delete');

                Route::post('store', [WalletController::class, 'store'])->name('store');
            });

            Route::prefix('getPoint')->name('getPoint.')->group(function () {
                //獲得ポイントを登録
                Route::post('store', [GetPointController::class, 'store'])->name('store');
                //獲得ポイントを削除
                Route::delete('delete/{bank_id}', [GetPointController::class, 'delete'])->name('delete');
            });

            Route::prefix('withdrawalPoint')->name('withdrawalPoint.')->group(function () {
                //出金ポイントを登録
                Route::post('store', [WithdrawalPointController::class, 'store'])->name('store');
                //出金完了手続き
                Route::put('updateComplete/{withdrawal_point_id}', [WithdrawalPointController::class, 'updateComplete'])->name('update.Complete');
                //出金ポイントを削除
                Route::delete('delete/{bank_id}', [WithdrawalPointController::class, 'delete'])->name('delete');
            });

            Route::prefix('box')->name('box.')->group(function () {
                //箱一覧
                Route::get('index', [BoxController::class, 'index'])->name('index');
                //箱を削除
                Route::delete('delete/{box_id}', [BoxController::class, 'delete'])->name('delete');
            });

            Route::prefix('item')->name('itme.')->group(function () {
                //レンタル出品中の荷物一覧
                Route::get('indexOfRental/{item_id}', [ItemController::class, 'indexOfRental'])->name('indexOfRental');
                //販売出品中の荷物一覧
                Route::get('indexOfSale/{item_id}', [ItemController::class, 'indexOfSale'])->name('indexOfSale');
                //箱と紐づく荷物一覧
                Route::get('indexOfBox/{box_id}', [ItemController::class, 'indexOfBox'])->name('indexOfBox');
                //荷物詳細
                Route::get('show/{item_id}', [ItemController::class, 'show'])->name('show');
                //荷物の保管方法を変更
                Route::put('updateStorage/{item_id}/{storage}', [ItemController::class, 'updateStorage'])->name('updateStorage');
                //荷物のステータスを変更
                Route::put('updateStatus/{item_id}/{status}', [ItemController::class, 'updateStorage'])->name('updateStorage');
                //荷物を削除
                Route::delete('delete/{item_id}', [ItemController::class, 'delete'])->name('delete');
            });

            Route::prefix('itemImage')->name('itemImage.')->group(function () {
                // 荷物の画像を削除する
                Route::get('delete/{item_id}', [ItemImageController::class, 'delete'])->name('delete');
            });

            Route::prefix('requestReturn')->name('requestReturn.')->group(function () {
                //返却リクエスト詳細
                Route::get('show/{item_id}', [RequestReturnController::class, 'show'])->name('show');
                //返却リクエスト登録
                Route::post('store', [RequestReturnController::class, 'store'])->name('store');
                //返却リクエスト削除
                Route::delete('delete/{request_return_id}', [RequestReturnController::class, 'delete'])->name('delete');
            });

            Route::prefix('requestSale')->name('requestSale.')->group(function () {
                //販売代行依頼詳細
                Route::get('show/{item_id}', [RequestSaleController::class, 'show'])->name('show');
                //販売代行依頼
                Route::post('store', [RequestSaleController::class, 'store'])->name('store');
            });

            Route::prefix('infoSale')->name('infoSale.')->group(function () {
                //販売代行中の荷物一覧
                Route::get('index/{item_id}', [InfoSaleController::class, 'index'])->name('index');
                //販売代行中の荷物詳細
                Route::get('show/{item_id}', [InfoSaleController::class, 'show'])->name('show');
            });

            Route::prefix('infoRental')->name('infoRental.')->group(function () {
                //レンタル出品中の荷物一覧
                Route::get('index', [InfoRentalController::class, 'index'])->name('index');
                //ユーザーがレンタルに出品
                Route::post('store', [InfoRentalController::class, 'store'])->name('store');
                //レンタル出品中の荷物詳細
                Route::get('show/{item_id}', [InfoRentalController::class, 'show'])->name('show');
                //ユーザーがレンタル出品を停止
                Route::delete('delete/{item_id}', [InfoRentalController::class, 'delete'])->name('delete');
            });

            Route::prefix('historyRental')->name('historyRental.')->group(function () {
                //レンタル履歴詳細
                Route::get('show/{item_id}', [HistoryRentalController::class, 'show'])->name('show');
            });

            Route::prefix('historySale')->name('historySale.')->group(function () {
                //レンタル履歴詳細
                Route::get('show/{item_id}', [HistorySaleController::class, 'show'])->name('show');
            });

            Route::prefix('historyDonate')->name('historyDonate.')->group(function () {
                //ユーザーが荷物を寄付する
                Route::post('store', [HistoryDonationController::class, 'store'])->name('store');
                //寄付詳細
                Route::get('show/{blog_id}', [HistoryDonationController::class, 'show'])->name('show');
            });

            Route::prefix('blog')->name('blog.')->group(function () {
                //ブログ一覧
                Route::get('index', [BlogController::class, 'index'])->name('index');
                //ブログ詳細
                Route::get('show/{blog_id}', [BlogController::class, 'show'])->name('show');
            });
        });
    });
});

Route::middleware('auth:api_manager')->group(function () {
    Route::prefix('manager')->name('user.')->group(function () {
        Route::prefix('v1')->name('v1.')->group(function () {

            Route::prefix('shop')->name('shop.')->group(function () {
                //ショップ一覧
                Route::get('index', [ShopController::class, 'index'])->name('index');
                //ショップ登録
                Route::get('store', [ShopController::class, 'store'])->name('store');
                //ショップ更新
                Route::get('update/{shop_id}', [ShopController::class, 'update'])->name('update');
                //ショップ削除
                Route::get('delete/{shop_id}', [ShopController::class, 'delete'])->name('delete');
            });

            Route::prefix('staff')->name('staff.')->group(function () {
                //スタッフ一覧
                Route::get('index', [StaffController::class, 'index'])->name('index');
                //スタッフ詳細
                Route::get('show/{staff_id}', [StaffController::class, 'show'])->name('show');
                //スタッフ登録
                Route::post('store', [StaffController::class, 'store'])->name('store');
                //スタッフ削除
                Route::put('update/{staff_id}', [StaffController::class, 'update'])->name('update');
                //スタッフ更新
                Route::delete('delete/{staff_id}', [StaffController::class, 'delete'])->name('delete');
            });

            Route::prefix('user')->name('user.')->group(function () {
                //ユーザー一覧
                Route::get('index', [UserController::class, 'index'])->name('index');
                //ユーザー詳細
                Route::get('show/{user_id}', [UserController::class, 'show'])->name('show');
                //ユーザー更新
                Route::put('update/{staff_id}', [UserController::class, 'update'])->name('update');
                //ユーザー削除
                Route::delete('delete/{staff_id}', [UserController::class, 'delete'])->name('delete');
            });

            Route::prefix('renter')->name('renter.')->group(function () {
                //スタッフ一覧
                Route::get('index', [RenterController::class, 'index'])->name('index');
                //スタッフ詳細
                Route::get('show/{renter_id}', [RenterController::class, 'show'])->name('show');
                //スタッフ登録
                Route::post('store', [RenterController::class, 'store'])->name('store');
                //スタッフ削除
                Route::put('update/{renter_id}', [RenterController::class, 'update'])->name('update');
                //スタッフ更新
                Route::delete('delete/{renter_id}', [RenterController::class, 'delete'])->name('delete');
            });

            Route::prefix('bank')->name('bank.')->group(function () {
                //銀行一覧
                Route::get('index', [BankController::class, 'index'])->name('index');
                //銀行詳細
                Route::get('show/{bank_id}', [BankController::class, 'show'])->name('show');
            });

            Route::prefix('wallet')->name('wallet.')->group(function () {
                //取引履歴一覧
                Route::get('tradingHistory/{wallet_id}', [WalletController::class, 'tradingHistory'])->name('trading.History');
            });

            Route::prefix('box')->name('box.')->group(function () {
                //箱一覧
                Route::get('index', [BoxController::class, 'index'])->name('index');
                //ユーザーと紐づく荷物一覧
                Route::get('indexOfUser/{user_id}', [BoxController::class, 'indexOfUser'])->name('index.OfUser');
                //箱詳細
                Route::get('show/{box_id}', [BoxController::class, 'show'])->name('show');
                //箱登録
                Route::post('store', [BoxController::class, 'store'])->name('store');
                //箱更新
                Route::put('update/{box_id}', [BoxController::class, 'update'])->name('update');
                //スタッフ更新
                Route::delete('delete/{box_id}', [BoxController::class, 'delete'])->name('delete');
            });

            Route::prefix('item')->name('itme.')->group(function () {
                //荷物一覧
                Route::get('index', [ItemController::class, 'index'])->name('index');
                //箱と紐づく荷物一覧
                Route::get('indexOfBox/{box_id}', [ItemController::class, 'indexOfBox'])->name('index.OfBox');
                //ユーザーと紐づく荷物一覧
                Route::get('indexOfUser/{user_id}', [ItemController::class, 'indexOfUser'])->name('index.OfUser');
                //レンタル中の荷物一覧
                Route::get('indexOfRental', [ItemController::class, 'indexOfRental'])->name('index.OfRental');
                //販売中の荷物一覧
                Route::get('indexOfSale/{item_id}', [ItemController::class, 'indexOfSale'])->name('indexOfSale');
                //荷物詳細
                Route::get('show/{item_id}', [ItemController::class, 'show'])->name('show');
            });

            Route::prefix('itemImage')->name('itemImage.')->group(function () {
                // 荷物の画像一覧
                Route::get('index/{item_id}', [ItemImageController::class, 'index'])->name('index');
                // 荷物の画像を登録
                Route::post('store/{item_id}', [ItemImageController::class, 'store'])->name('store');
            });

            Route::prefix('historyReturn')->name('historyReturn.')->group(function () {
                //返送済み荷物一覧
                Route::post('store', [HistoryReturnController::class, 'store'])->name('store');
            });

            Route::prefix('blog')->name('blog.')->group(function () {
                //ブログ一覧
                Route::get('index', [BlogController::class, 'index'])->name('index');
                //ブログ詳細
                Route::get('show/{blog_id}', [BlogController::class, 'show'])->name('show');
                //ブログ登録
                Route::post('store', [BlogController::class, 'store'])->name('store');
                //ブログ更新
                Route::put('update/{blog_id}', [BlogController::class, 'update'])->name('update');
                //ブログ削除
                Route::get('delete/{blog_id}', [BlogController::class, 'show'])->name('show');
            });
        });
    });
});
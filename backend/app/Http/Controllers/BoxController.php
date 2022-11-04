<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * 荷物 一覧
     *
     * @return view
     */
    public function index() {
        // ユーザーIDと等しい荷物を取得
        $user_id = Auth::user()->id;

        // インスタンス
        $boxInstance = new Box;
        $boxes = $boxInstance->boxListOfUser($user_id);
        $blogs = Blog::orderBy('created_at','DESC')->limit(5)->get();
        return view('user.box.index', compact('boxes', 'blogs'));
    }

    /**
     * 荷物 詳細
     *
     * @return view
     */
    public function show($id) {
        return view('user.box.show', compact('id'));
    }

    /**
     * 荷物 預入リクエスト
     *
     * @return view
     */
    public function storageRequest() {
        return view('user.box.storageRequest');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewController extends Controller
{
    /**
     * ニュース 一覧
     *
     * @return view
     */
    public function index() {
        return view('news.index');
    }

    /**
     * ニュース 詳細
     *
     * @return view
     */
    public function show() {
        return view('news.show');
    }

    /**
     * ニュース 作成
     *
     * @return view
     */
    public function create() {
        return view('news.create');
    }

    /**
     * ニュース 更新
     *
     * @return view
     */
    public function update() {
        return view('news.update');
    }

    /**
     * ニュース 削除
     *
     * @return view
     */
    public function delete() {
        return view('news.delete');
    }
}

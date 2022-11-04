<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * トップページ
     *
     * @return view
     */
    public function home()
    {
        return view('page.home');
    }

    /**
     * 会社概要
     *
     * @return view
     */
    public function company() {
        return view('page.company');
    }

    /**
     * FAQ
     *
     * @return view
     */
    public function faq() {
        return view('page.faq');
    }

    /**
     * 特定商取引法
     *
     * @return view
     */
    public function tokushoho() {
        return view('page.tokushoho');
    }

    /**
     * 利用規約
     *
     * @return view
     */
    public function terms() {
        return view('page.terms');
    }

    /**
     * サービス利用規約
     *
     * @return view
     */
    public function termsService() {
        return view('page.termsService');
    }

    // /**
    //  * 保管サービス利用規約
    //  *
    //  * @return view
    //  */
    // public function termsStorage() {
    //     return view('page.termsStorage');
    // }

    /**
     * 出品代行機能利用規約
     *
     * @return view
     */
    public function termsAgency() {
        return view('page.termsAgency');
    }

    /**
     * サブスクリプション 利用特約
     *
     * @return view
     */
    public function termsSubscription() {
        return view('page.termsSubscription');
    }

    /**
     * プライバシーポリシー
     *
     * @return view
     */
    public function termsPrivacy() {
        return view('page.termsPrivacy');
    }

    /**
     * ベビクロ
     *
     * @return view
     */
    public function babyclo() {
        return view('page.babyclo');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * お問い合わせ
     *
     * @return view
     */
    public function contact() {
        return view('contact.index');
    }
}

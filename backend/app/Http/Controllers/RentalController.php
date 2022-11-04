<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * レンタル商品 一覧
     *
     * @return view
     */
    public function index() {
        return view('rental.index');
    }

    /**
     * レンタル商品 詳細
     *
     * @return view
     */
    public function show($id) {
        return view('rental.show');
    }

    public function rentalIndex() {
        dd('ok');
    }

    public function rentalShow($key) {
        dd($key);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;


class MypageController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('mypage.edit', compact('user'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // 出品 or 購入 切り替え
        if ($request->query('page') === 'buy') {

            // 仮：購入した商品（後でちゃんとリレーション）
            $items = Item::all();

        } else {

            // 仮：自分の出品商品
            $items = Item::where('user_id', $user->id)->get();

        }

        return view('mypage.index', compact('items'));
    }
}

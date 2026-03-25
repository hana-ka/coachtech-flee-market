<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ProfileRequest;


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

        if ($request->query('page') === 'buy') {

            $items = Item::whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

        } else {

            $items = Item::where('user_id', $user->id)->get();

        }

        return view('mypage.index', compact('items', 'user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = [
            'name' => $request->name,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if ($request->hasFile('image')) {
            $data['profile_image'] = $request->file('image')->store('images', 'public');
        }

        $user->update($data);

        return redirect('/mypage');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $exists = Like::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->exists();

        if ($exists) {
            Like::where('user_id', Auth::id())
                ->where('item_id', $item->id)
                ->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
            ]);
        }

        return redirect()->back();
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        $user = Auth::user();

        return view('purchases.create', compact('item', 'user'));
    }

    public function edit(Item $item)
    {
        $user = Auth::user();

        return view('purchases.address', compact('item', 'user'));

    }
}


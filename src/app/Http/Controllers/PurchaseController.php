<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;

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

    public function store(PurchaseRequest $request, Item $item)
    {
        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/');
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\AddressRequest;

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
        session([
        'purchase_data' => [
            'payment_method' => $request->payment_method,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
            ],
        ]);

            if (app()->environment('testing')) {
                return $this->success($item);
            }


            Stripe::setApiKey(env('STRIPE_SECRET'));

            if ($request->payment_method === 'card') {
                $methods = ['card'];
            } else {
                $methods = ['konbini'];
            }

            $session = Session::create([
                'payment_method_types' => $methods,
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/purchase/success/' . $item->id),
                'cancel_url' => url('/purchase/' . $item->id),
            ]);

            return redirect($session->url);
    }

    public function success(Item $item)
    {
        $data = session('purchase_data');

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $data['payment_method'],
            'postcode' => $data['postcode'],
            'address' => $data['address'],
            'building' => $data['building'],
        ]);

        return redirect('/');
    }


    public function update(AddressRequest $request, Item $item)
    {
        $user = Auth::user();

        $user->update([
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.create', $item->id);
    }
}


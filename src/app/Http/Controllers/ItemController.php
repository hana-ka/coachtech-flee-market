<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;


class ItemController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
        $items = Item::with('purchase')
            ->where('user_id', '!=', Auth::id())
            ->get();
        } else {
            $items = Item::with('purchase')->get();
        }

        return view('items.index', compact('items'));

        }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('images', 'public');

        $item = Item::create([
            'image' => $path,
            'name' => $request->name,
            'description' => $request->description,
            'condition_id' => $request->condition_id,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ]);

        $item->categories()->attach($request->categories);

        return redirect('/');
    }
}

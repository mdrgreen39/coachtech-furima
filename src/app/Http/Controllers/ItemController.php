<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('index');

        // $items = Item::all();

        // return view('index', compact('items'));
    }


    public function searchJson(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Item::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($products);
    }
}

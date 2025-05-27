<?php

namespace App\Http\Controllers;

use App\Models\Item;

class LandingController extends Controller
{
    public function index()
    {
        $items = \App\Models\Item::with('itemInstances')->get();
        return view('landingPage', compact('items'));
    }
}

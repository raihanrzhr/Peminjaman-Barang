<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $query = DB::table('item_instances')
            ->join('items', 'item_instances.item_id', '=', 'items.item_id')
            ->select(
                'items.category',
                'item_instances.item_name',
                'item_instances.specifications',
                DB::raw('COUNT(CASE WHEN item_instances.status = "Available" THEN 1 END) as jumlah_tersedia')
            )
            ->groupBy('items.category', 'item_instances.item_name', 'item_instances.specifications')
            ->orderBy('items.category')
            ->orderBy('item_instances.item_name');

        if (request('q')) {
            $query->where('item_instances.item_name', 'like', '%' . request('q') . '%');
        }

        $items = $query->paginate(15)->withQueryString();

        return view('landingPage', compact('items'));
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\RequestItem;
use Illuminate\Http\Request;

class RequestAnItemController extends Controller
{
    public function list()
    {
        $item_requests = RequestItem::with('product')->latest()->paginate(25);
        return view('admin-views.request-item.list', compact('item_requests'));
    }
}

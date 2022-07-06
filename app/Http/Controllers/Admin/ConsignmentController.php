<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Consignments;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{
    public function list()
    {
        $consignments = Consignments::latest()->paginate(25);
        return view('admin-views.consignment.list', compact('consignments'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        $data['ads'] = Ad::orderBy('id','desc')->paginate(12);
        return view('admin-views.ads.view',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'sub_title' => 'required|string|max:100',
            'url' => 'required|max:255',
            'button_name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ], [
            'url.required' => 'url is required!',
            'image.required' => 'Image is required!',
        ]);

        $ad = new Ad;
        $ad->title = $request->title;
        $ad->sub_title = $request->sub_title;
        $ad->url = $request->url;
        $ad->button_name = $request->button_name;
        $ad->image = ImageManager::upload('ads/', 'png', $request->file('image'));
        $ad->save();
        Toastr::success('Ads added successfully!');
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Ad::find($request->id);
            $banner->status = $request->status;
            $banner->save();
            $data = $request->status;
            return response()->json($data);
        }
    }

    public function edit(Request $request)
    {
        $data = Ad::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'sub_title' => 'required|string|max:100',
            'url' => 'required|max:255',
            'button_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:5000',
        ]);
        $Ad = Ad::find($request->id);
        $Ad->title = $request->title;
        $Ad->sub_title = $request->sub_title;
        $Ad->button_name = $request->button_name;
        $Ad->url = $request->url;
        if($request->file('image'))
        {
            $Ad->image = ImageManager::update('ads/', $Ad['photo'], 'png', $request->file('image'));
        }

        $Ad->save();

        // return response()->json();
        Toastr::success('Ad updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $br = Ad::find($request->id);
        ImageManager::delete('/ads/' . $br['photo']);
        $br->delete();
        return response()->json();
    }
}

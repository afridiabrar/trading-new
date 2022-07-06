<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function list() {
        $banners = Banner::orderBy('id', 'desc')->paginate(25);
        return view('admin-views.banner.view', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'sub_title' => 'required|string|max:100',
            'description' => 'required|max:65535',
            'url' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ], [
            'url.required' => 'url is required!',
            'image.required' => 'Image is required!',
        ]);

        $banner = new Banner;
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->description = $request->description;
        $banner->banner_type = $request->banner_type;
        $banner->url = $request->url;
        $banner->photo = ImageManager::upload('banner/', 'png', $request->file('image'));
        $banner->save();
        Toastr::success('Banner added successfully!');
        return back();
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $banner = Banner::find($request->id);
            $banner->published = $request->status;
            $banner->save();
            $data = $request->status;
            return response()->json($data);
        }
    }

    public function edit(Request $request)
    {
        $data = Banner::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'sub_title' => 'required|string|max:100',
            'description' => 'required|max:65535',
            'url' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:5000',
        ]);
        $banner = Banner::find($request->id);
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;
        $banner->description = $request->description;
        $banner->banner_type = $request->banner_type;
        $banner->url = $request->url;
        if($request->file('image'))
        {
            $banner->photo = ImageManager::update('banner/', $banner['photo'], 'png', $request->file('image'));
        }

        $banner->save();

        // return response()->json();
        Toastr::success('Banner updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $br = Banner::find($request->id);
        ImageManager::delete('/banner/' . $br['photo']);
        $br->delete();
        return response()->json();
    }
}

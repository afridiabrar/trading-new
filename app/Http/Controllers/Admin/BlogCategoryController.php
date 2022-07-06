<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BlogCategory;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BlogCategory::where(['deleted_at' => null])->latest()->paginate(25);
        return view('admin-views.blog-category.view', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100'
        ], [
            'name.required' => 'Category name is required!',
        ]);

        BlogCategory::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'))
        ]);

        Toastr::success('Category added successfully!');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = BlogCategory::find($id);
        return view('admin-views.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100'
        ], [
            'name.required' => 'Category name is required!',
        ]);

        $blogCategory = BlogCategory::find($id);
        $blogCategory->name = $request->input('name');
        $blogCategory->slug = Str::slug($request->input('name'));
        $blogCategory->save();

        Toastr::success('Category updated successfully!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogCategory = BlogCategory::find($id);
        $blogCategory->deleted_at = Carbon::now();
        $blogCategory->save();

        Toastr::success('Category deleted successfully!');
        return back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories=Category::where(['position'=>1])->latest()->paginate(25);
        return view('admin-views.category.sub-category-view',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'name.required' => 'Category name is required!',
            'parent_id.required' => 'Main category is required!',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->icon = ImageManager::upload('category/sub-category/', 'png', $request->file('image'));
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        $category->save();
//        $category = new Category;
//        $category->name = $request->name[array_search('en', $request->lang)];
//        $category->slug = Str::slug($request->name[array_search('en', $request->lang)]);
//        $category->parent_id = $request->category;
//        $category->position = 1;
//        $category->save();

//        foreach($request->lang as $index=>$key)
//        {
//            if($request->name[$index] && $key != 'en')
//            {
//                Translation::updateOrInsert(
//                    ['translationable_type'  => 'App\Model\Category',
//                        'translationable_id'    => $category->id,
//                        'locale'                => $key,
//                        'key'                   => 'name'],
//                    ['value'                 => $request->name[$index]]
//                );
//            }
//        }
        Toastr::success('Category added successfully!');
        return back();
    }

    public function edit(Request $request, $id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin-views.category.sub-category-edit', compact('category'));
//        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            $category->icon = ImageManager::update('category/sub-category/', $category->icon, 'png', $request->file('image'));
        }
        $category->parent_id = $request->parent_id;
        $category->position = 1;
        $category->save();
        Toastr::success('Sub category updated successfully!');
        return back();
//        return response()->json();
    }

    public function delete(Request $request)
    {
        $categories = Category::where('parent_id', $request->id)->get();
        if (!empty($categories)) {

            foreach ($categories as $category) {
                Category::destroy($category->id);
            }
        }
        Category::destroy($request->id);
        return response()->json();
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('position', 1)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }
}

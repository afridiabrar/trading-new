<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogCategories = BlogCategory::where(['deleted_at' => null])->limit(3)->get();
        $blogs = Blog::where(['deleted_at' => null, 'published' => 1])
            ->when(count($request->all()) > 0, function ($query) use ($request) {
                if (isset($request->category) && $request->category != 'all') {
                    $query->where('blog_category_id', $request->category);
                }
            })
            ->limit(10)
            ->get();

        $blogsArray = array_chunk($blogs->toArray(),2);
        return view('web-views.blog.index', compact('blogCategories', 'blogsArray'));
    }

    public function show($id)
    {
        $blog = Blog::where('id', $id)->first();

        if (!$blog) {
            return abort(404);
        }

        return view('web-views.blogdetails', compact('blog'));
    }
}

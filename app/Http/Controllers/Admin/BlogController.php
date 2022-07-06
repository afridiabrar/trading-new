<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\BlogCategory;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with('blogCategory')->where(['deleted_at' => null])->latest()->paginate(25);
        return view('admin-views.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::where(['deleted_at' => null])->get();
        return view('admin-views.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'blog_category_id' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5000'
        ], [
            'title.required' => 'Title field is required!',
            'blog_category_id.required' => 'Category field is required!',
            'content.required' => 'Content field is required!',
            'image.required' => 'Image field is required!'
        ]);

        $blog = new Blog;
        $blog->blog_category_id = $request->input('blog_category_id');
        $blog->title = $request->input('title');
        $blog->slug = Str::slug($request->input('title'));
        $blog->image = ImageManager::upload('blog/', 'png', $request->file('image'));;
        $blog->content = $request->input('content');
        $blog->save();

        Toastr::success('Blog created successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::with('blogCategory')->find($id);
        $categories = BlogCategory::where(['deleted_at' => null])->get();
        return view('admin-views.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'blog_category_id' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:5000'
        ], [
            'title.required' => 'Title field is required!',
            'blog_category_id.required' => 'Category field is required!',
            'content.required' => 'Content field is required!'
        ]);

        $blog = Blog::find($id);
        $blog->blog_category_id = $request->input('blog_category_id');
        $blog->title = $request->input('title');
        $blog->slug = Str::slug($request->input('title'));
        if ($request->hasFile('image')) {
            unlink(storage_path('app/public/blog/' . $blog->image));
            $blog->image = ImageManager::upload('blog/', 'png', $request->file('image'));;
        }
        $blog->content = $request->input('content');
        $blog->save();

        Toastr::success('Blog updated successfully!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->deleted_at = Carbon::now();
        $blog->save();

        Toastr::success('Blog deleted successfully!');
        return back();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function published(Request $request)
    {
        Blog::where(['id' => $request['id']])->update([
            'published' => $request['published'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }
}

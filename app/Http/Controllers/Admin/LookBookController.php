<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\LookBook;
use App\Model\LookBookAttachment;
use App\Model\LookBookProduct;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LookBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $look_books = LookBook::latest()->paginate(25);
        return view('admin-views.look-book.index', compact('look_books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|max:150',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $look_book = new LookBook;
        $look_book->title = $request->title;
        $look_book->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $look_book->banner = ImageManager::upload('look-book/', 'png', $request->file('image'));
        }
        $look_book->save();

        Toastr::success('Look book added successfully!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $look_book = LookBook::find($id);
        return view('admin-views.look-book.edit', compact('look_book'));
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
            'title' => 'required|max:150',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $look_book = LookBook::find($request->id);
        $look_book->title = $request->title;
        $look_book->slug = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $look_book->banner = ImageManager::update('look-book/', $look_book->banner, 'png', $request->file('image'));
        }
        $look_book->save();

        Toastr::success('Look book updated successfully!');
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
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        LookBook::where(['id' => $request['id']])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function add_product($id)
    {
        $look_book = LookBook::with(['products.product'])->where('id', $id)->first();
        return view('admin-views.look-book.add-product', compact('look_book'));
    }

    public function add_product_submit(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|numeric',
        ]);


        LookBookProduct::create(
            [
                'look_book_id' => $id,
                'product_id' => $request['product_id']
            ]
        );

        Toastr::success('Product added successfully');
        return back();
    }

    public function delete_product($look_book_id, $product_id)
    {
        LookBookProduct::where(
            [
                'look_book_id' => $look_book_id,
                'product_id' => $product_id
            ]
        )->delete();

        Toastr::success('Product deleted successfully');
        return back();
    }

    public function look_book_gallery($id)
    {
        $look_book = LookBook::with('gallery')->where('id', $id)->first();
        return view('admin-views.look-book.gallery', compact('look_book'));
    }

    public function add_look_book_gallery(Request $request, $id)
    {
        $request->validate([
            'images' => 'required',
        ]);

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $image = ImageManager::upload('look-book/gallery/', 'png', $img);
                LookBookAttachment::create(
                    [
                        'look_book_id' => $id,
                        'image' => $image
                    ]
                );
            }
        }

        Toastr::success('Images added successfully');
        return back();
    }

    public function remove_image($id)
    {
        LookBookAttachment::where('id', $id)->delete();
        Toastr::success('Image removed successfully');
        return back();
    }
}

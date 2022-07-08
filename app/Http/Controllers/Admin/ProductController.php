<?php

namespace App\Http\Controllers\Admin;

use App\CPU\BackEndHelper;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\BaseController;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Color;
use App\Model\DealOfTheDay;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductController extends BaseController
{
    public function add_new()
    {
        $cat = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        return view('admin-views.product.add-new', compact('cat', 'br'));
    }

    public function featured_status(Request $request)
    {
        $product = Product::find($request->id);
        $product->featured = ($product['featured'] == 0 || $product['featured'] == null) ? 1 : 0;
        $product->save();
        $data = $request->status;
        return response()->json($data);
    }

    public function view($id)
    {
        $product = Product::with(['reviews'])->where(['id' => $id])->first();
        return view('admin-views.product.view', compact('product'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            //            'brand_id' => 'required',
            'unit' => 'required',
            'images' => 'required',
            'image' => 'required',
            'tax' => 'required|min:0',
            'unit_price' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
        ], [
            'images.required' => 'Product images is required!',
            'image.required' => 'Product thumbnail is required!',
            'category_id.required' => 'category  is required!',
            //            'brand_id.required' => 'brand  is required!',
            'unit.required' => 'Unit  is required!',
        ]);

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'unit_price',
                    'Discount can not be more or equal to the price!'
                );
            });
        }

        $p = new Product();
        $p->user_id = auth('admin')->id();
        $p->added_by = "admin";
        $p->name = $request->name;
        $p->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

        /* @Is_Trade  */
        if ($request->input('is_trade') == "yes") {
            $p->is_trade = 1;
            $p->trade_qty = $request->input('trade_qty');
        }

        $category = [];

        if ($request->category_id != null) {
            $getCategory = Category::where('id', $request->category_id)->first();
            array_push($category, [
                'id' => $request->category_id,
                'name' => $getCategory->name,
                'slug' => $getCategory->slug,
                'position' => 1,
            ]);
        }

        if ($request->sub_category_id != null) {
            $getCategory = Category::where('id', $request->sub_category_id)->first();
            array_push($category, [
                'id' => $request->sub_category_id,
                'name' => $getCategory->name,
                'slug' => $getCategory->slug,
                'position' => 2,
            ]);
        }

        //        if ($request->sub_sub_category_id != null) {
        //            array_push($category, [
        //                'id' => $request->sub_sub_category_id,
        //                'position' => 3,
        //            ]);
        //        }

        $p->category_ids = json_encode($category, true);
        $p->brand_id = $request->brand_id;
        $p->unit = $request->unit;
        $p->details = $request->details;

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $p->colors = json_encode($request->colors);
        } else {
            $colors = [];
            $p->colors = json_encode($colors);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $p->choice_options = json_encode($choice_options);
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options

        $combinations = Helpers::combinations($options);

        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = BackEndHelper::currency_to_usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_' . str_replace('.', '_', $str)];
                array_push($variations, $item);
                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }

        if ((int)$request['current_stock'] != $stock_count) {
            $validator->after(function ($validator) {
                $validator->errors()->add('total_stock', 'Stock calculation mismatch!');
            });
        }

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $p->images = json_encode($product_images);
        }
        $p->thumbnail = ImageManager::upload('product/thumbnail/', 'png', $request->image);


        //combinations end
        $p->variation = json_encode($variations);
        $p->unit_price = BackEndHelper::currency_to_usd($request->unit_price);
        $p->purchase_price = BackEndHelper::currency_to_usd($request->purchase_price);
        $p->tax = $request->tax_type == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $p->tax_type = $request->tax_type;
        $p->discount = $request->discount_type == 'flat' ? BackEndHelper::currency_to_usd($request->discount) : $request->discount;
        $p->discount_type = $request->discount_type;
        $p->attributes = json_encode($request->choice_attributes);
        $p->current_stock = $request->current_stock;

        $p->meta_title = $request->meta_title;
        $p->meta_description = $request->meta_description;
        $p->meta_image = ImageManager::upload('product/meta/', 'png', $request->image);

        $p->video_provider = 'youtube';
        $p->video_url = $request->video_link;

        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $p->save();

            //            $data = [];
            //            foreach ($request->lang as $index => $key) {
            //                if ($request->name[$index] && $key != 'en') {
            //                    array_push($data, array(
            //                        'translationable_type' => 'App\Model\Product',
            //                        'translationable_id' => $p->id,
            //                        'locale' => $key,
            //                        'key' => 'name',
            //                        'value' => $request->name[$index],
            //                    ));
            //                }
            //                if ($request->description[$index] && $key != 'en') {
            //                    array_push($data, array(
            //                        'translationable_type' => 'App\Model\Product',
            //                        'translationable_id' => $p->id,
            //                        'locale' => $key,
            //                        'key' => 'description',
            //                        'value' => $request->description[$index],
            //                    ));
            //                }
            //            }
            //            Translation::insert($data);

            Toastr::success('Product added successfully!');
            return redirect()->route('admin.product.list', ['in_house']);
        }
    }

    function list($type)
    {
        if ($type == 'in_house') {
            $pro = Product::where(['added_by' => 'admin'])->latest()->paginate(25);
        } else {
            $pro = Product::where(['added_by' => 'seller'])->latest()->paginate(25);
        }

        return view('admin-views.product.list', compact('pro'));
    }

    public function status_update(Request $request)
    {
        Product::where(['id' => $request['id']])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function get_categories(Request $request)
    {
        $cat = Category::where(['parent_id' => $request->parent_id])->get();
        $res = '<option value="' . 0 . '" disabled selected>---Select---</option>';
        foreach ($cat as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }

    public function sku_combination(Request $request)
    {
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = Helpers::combinations($options);
        return response()->json([
            'view' => view('admin-views.product.partials._sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'))->render(),
        ]);
    }

    public function edit($id)
    {
        $product = Product::withoutGlobalScopes()->with('translations')->find($id);

        $product_category = json_decode($product->category_ids);

        if (!empty($product_category->id)) {
            $product_category_id = json_decode($product_category->id);
        } else {
            $product_category_id = json_decode($product_category[0]->id);
        }
// dd($product_category_id);
        if ($product->colors) {
            $product->colors = json_decode($product->colors);
        }

        $categories = Category::where(['parent_id' => 0])->get();

        $br = Brand::orderBY('name', 'ASC')->get();
        // dd($br);

        return view('admin-views.product.edit', compact('categories', 'br', 'product', 'product_category', 'product_category_id'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            //            'brand_id' => 'required',
            'unit' => 'required',
            'tax' => 'required|min:0',
            'unit_price' => 'required|numeric|min:1',
            'purchase_price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Product name is required!',
            'category_id.required' => 'category  is required!',
            //            'brand_id.required' => 'brand  is required!',
            'unit.required' => 'Unit  is required!',
        ]);

        if ($request['discount_type'] == 'percent') {
            $dis = ($request['unit_price'] / 100) * $request['discount'];
        } else {
            $dis = $request['discount'];
        }

        if ($request['unit_price'] <= $dis) {
            $validator->after(function ($validator) {
                $validator->errors()->add('unit_price', 'Discount can not be more or equal to the price!');
            });
        }

        $product = Product::find($id);
        //        $product->name = $request->name[array_search('en', $request->lang)];
        $product->name = $request->name;

        /* @Is_Trade  */
        if ($request->input('is_trade') == "yes") {
            $product->is_trade = 1;
            $product->trade_qty = $request->input('trade_qty');
        } else {
            $product->is_trade = 0;
        }

        $category = [];

        if ($request->category_id != null) {
            $getCategory = Category::where('id', $request->category_id)->first();
            array_push($category, [
                'id' => $request->category_id,
                'name' => $getCategory->name,
                'slug' => $getCategory->slug,
                'position' => 1,
            ]);
        }

        if ($request->sub_category_id != null) {
            $getCategory = Category::where('id', $request->sub_category_id)->first();
            array_push($subcategory, [
                'id' => $request->sub_category_id,
                'name' => $getCategory->name,
                'slug' => $getCategory->slug,
                'position' => 2,
            ]);
        }

        //        if ($request->sub_sub_category_id != null) {
        //            array_push($category, [
        //                'id' => $request->sub_sub_category_id,
        //                'position' => 3,
        //            ]);
        //        }
        $product->category_ids = json_encode($category, true);
        $product->sub_category_id = json_encode($subcategory, true);
        $product->brand_id = $request->brand_id;
        $product->unit = $request->unit;
        $product->details = $request->details;
        $product_images = json_decode($product->images);

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = [];
            $product->colors = json_encode($colors);
        }
        $choice_options = [];
        if ($request->has('choice')) {
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }
        $product->choice_options = json_encode($choice_options);
        $variations = [];
        //combinations start
        $options = [];
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
        $combinations = Helpers::combinations($options);
        $variations = [];
        $stock_count = 0;
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        } else {
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = BackEndHelper::currency_to_usd(abs($request['price_' . str_replace('.', '_', $str)]));
                $item['sku'] = $request['sku_' . str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_' . str_replace('.', '_', $str)];
                array_push($variations, $item);

                $stock_count += $item['qty'];
            }
        } else {
            $stock_count = (int)$request['current_stock'];
        }
        if ((int)$request['current_stock'] != $stock_count) {
            $validator->after(function ($validator) {
                $validator->errors()->add('total_stock', 'Stock calculation mismatch!');
            });
        }

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $product->images = json_encode($product_images);
        }

        if ($request->file('image')) {
            $product->thumbnail = ImageManager::update('product/thumbnail/', $product->thumbnail, 'png', $request->file('image'));
        }
        //combinations end
        $product->variation = json_encode($variations);
        $product->unit_price = BackEndHelper::currency_to_usd($request->unit_price);
        $product->purchase_price = BackEndHelper::currency_to_usd($request->purchase_price);
        $product->tax = $request->tax == 'flat' ? BackEndHelper::currency_to_usd($request->tax) : $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount_type == 'flat' ? BackEndHelper::currency_to_usd($request->discount) : $request->discount;
        $product->attributes = json_encode($request->choice_attributes);
        $product->discount_type = $request->discount_type;
        $product->current_stock = $request->current_stock;

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        if ($request->file('meta_image')) {
            $product->meta_image = ImageManager::update('product/meta/', $product->meta_image, 'png', $request->file('meta_image'));
        }
        $product->video_provider = 'youtube';
        $product->video_url = $request->video_link;

        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $product->save();
            //            foreach ($request->lang as $index => $key) {
            //                if ($request->name[$index] && $key != 'en') {
            //                    Translation::updateOrInsert(
            //                        ['translationable_type' => 'App\Model\Product',
            //                            'translationable_id' => $product->id,
            //                            'locale' => $key,
            //                            'key' => 'name'],
            //                        ['value' => $request->name[$index]]
            //                    );
            //                }
            //                if ($request->description[$index] && $key != 'en') {
            //                    Translation::updateOrInsert(
            //                        ['translationable_type' => 'App\Model\Product',
            //                            'translationable_id' => $product->id,
            //                            'locale' => $key,
            //                            'key' => 'description'],
            //                        ['value' => $request->description[$index]]
            //                    );
            //                }
            //            }
            Toastr::success('Product updated successfully.');
            return back();
        }
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/product/' . $request['image']);
        $product = Product::find($request['id']);
        $array = [];
        if (count(json_decode($product['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($product['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Product::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Product image removed successfully!');
        return back();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        foreach (json_decode($product['images'], true) as $image) {
            ImageManager::delete('/product/' . $image);
        }
        ImageManager::delete('/product/thumbnail/' . $product['thumbnail']);
        $product->delete();
        FlashDealProduct::where(['product_id' => $id])->delete();
        DealOfTheDay::where(['product_id' => $id])->delete();
        Toastr::success('Product removed successfully!');
        return back();
    }

    public function bulk_import_index()
    {
        return view('admin-views.product.bulk-import');
    }

    public function bulk_import_data(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('products_file'));
        } catch (\Exception $exception) {
            Toastr::error('You have uploaded a wrong format file, please upload the right file.');
            return back();
        }

        $data = [];
        $skip = ['youtube_video_url'];
        foreach ($collections as $collection) {
            foreach ($collection as $key => $value) {
                if ($value === "" && !in_array($key, $skip)) {
                    Toastr::error('Please fill all the required fields');
                    return back();
                }
            }

            array_push($data, [
                'name' => $collection['name'],
                'slug' => Str::slug($collection['name'], '-') . '-' . Str::random(6),
                'category_ids' => json_encode([['id' => $collection['category_id'], 'position' => 0], ['id' => $collection['sub_category_id'], 'position' => 1]]),
                'brand_id' => $collection['brand_id'],
                'unit' => $collection['unit'],
                'min_qty' => $collection['min_qty'],
                'refundable' => $collection['refundable'],
                'unit_price' => $collection['unit_price'],
                'purchase_price' => $collection['purchase_price'],
                'tax' => $collection['tax'],
                'discount' => $collection['discount'],
                'discount_type' => $collection['discount_type'],
                'current_stock' => $collection['current_stock'],
                'details' => $collection['details'],
                'video_provider' => 'youtube',
                'video_url' => $collection['youtube_video_url'],
                'images' => json_encode(['def.png']),
                'thumbnail' => 'def.png',
                'status' => 1,
                'colors' => json_encode([]),
                'attributes' => json_encode([]),
                'choice_options' => json_encode([]),
                'variation' => json_encode([]),
                'featured_status' => 1,
                'added_by' => 'admin',
                'user_id' => auth('admin')->id(),
            ]);
        }
        DB::table('products')->insert($data);
        Toastr::success(count($data) . ' - Products imported successfully!');
        return back();
    }

    public function bulk_export_data()
    {
        $products = Product::where(['added_by' => 'admin'])->get();
        return (new FastExcel($products))->download('inhouse_products.xlsx');
    }

    public function importProducts()
    {
        try {
            $rows = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\Products, public_path('Trading.xlsx'));
            if (count($rows) >= 1) {
                foreach (array_chunk($rows[0], 50) as $key => $chunks) {
                    if ($key != 0) {
                        dispatch(new \App\Jobs\UploadImportProductsJob($chunks));
                        echo ($key + 1) . " Job added in Queue successfully!</br>";
                    }
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function filterData($data, $filter)
    {
        foreach ($data as $k => $v) {
            if ($v[4] === $filter) {
                return $v;
            }
        }

        return [];
    }

    public function importLeftProducts()
    {
        try {
            $x = array(
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/1e/8f/5e/5e8f1e022219862af5171584/sa66x134-p1_237.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/05/1e/8f/5e/5e8f1e052219862af5171593/sa66x134-p1_230.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1e/8f/5e/5e8f1e082219862af51715a2/sa66x134-p1_223.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0b/1e/8f/5e/5e8f1e0b2219862af51715b1/sa66x134-p1_258.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1e/8f/5e/5e8f1e0e2219862af51715c0/sa66x134-p1_251.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/11/1e/8f/5e/5e8f1e112219862af51715cf/sa66x134-p1_244.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/14/1e/8f/5e/5e8f1e142219862af51715de/165-p1_196.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/1e/8f/5e/5e8f1e172219862af51715ed/165-p1_203.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1a/1e/8f/5e/5e8f1e1a2219862af51715fc/165-p1_210.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1d/1e/8f/5e/5e8f1e1d2219862af517160b/863-p1_459.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/20/1e/8f/5e/5e8f1e202219862af517161a/863-p1_452.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b4/1d/8f/5e/5e8f1db4280f8c9a7eaa5caf/863-p1_445.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b7/1d/8f/5e/5e8f1db7280f8c9a7eaa5cbe/171-p1_276.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bb/1d/8f/5e/5e8f1dbb280f8c9a7eaa5ccf/171-p1_292.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/be/1d/8f/5e/5e8f1dbe280f8c9a7eaa5ce0/171-p1_284.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c1/1d/8f/5e/5e8f1dc1280f8c9a7eaa5cf1/174-p1_612.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1d/8f/5e/5e8f1dc4280f8c9a7eaa5d00/174-p1_626.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c6/1d/8f/5e/5e8f1dc6280f8c9a7eaa5d0f/174-p1_619.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1d/8f/5e/5e8f1dca280f8c9a7eaa5d1e/186-p1_104.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cc/1d/8f/5e/5e8f1dcc280f8c9a7eaa5d2a/186-p1_111.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/1d/8f/5e/5e8f1dce280f8c9a7eaa5d36/189-p1_622.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d1/1d/8f/5e/5e8f1dd1280f8c9a7eaa5d45/189-p1_629.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d4/1d/8f/5e/5e8f1dd4280f8c9a7eaa5d54/189-p1_636.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d6/1d/8f/5e/5e8f1dd6280f8c9a7eaa5d63/192-p1_15.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/1d/8f/5e/5e8f1dd9280f8c9a7eaa5d74/192-p1_23.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/dd/1d/8f/5e/5e8f1ddd280f8c9a7eaa5d85/192-p1_31.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e1/1d/8f/5e/5e8f1de1280f8c9a7eaa5d96/195-p1_643.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e4/1d/8f/5e/5e8f1de4280f8c9a7eaa5da7/195-p1_651.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e8/1d/8f/5e/5e8f1de8280f8c9a7eaa5db8/195-p1_659.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1d/8f/5e/5e8f1deb280f8c9a7eaa5dc9/198-p1_39.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ee/1d/8f/5e/5e8f1dee280f8c9a7eaa5dda/198-p1_47.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f1/1d/8f/5e/5e8f1df1280f8c9a7eaa5deb/198-p1_55.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f5/1d/8f/5e/5e8f1df5280f8c9a7eaa5dfc/201-p1_343.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f8/1d/8f/5e/5e8f1df8280f8c9a7eaa5e0b/201-p1_350.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/1d/8f/5e/5e8f1dfa280f8c9a7eaa5e1a/201-p1_357.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fd/1d/8f/5e/5e8f1dfd280f8c9a7eaa5e29/204-p1_63.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/1e/8f/5e/5e8f1e00280f8c9a7eaa5e38/204-p1_70.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/03/1e/8f/5e/5e8f1e03280f8c9a7eaa5e47/204-p1_77.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/06/1e/8f/5e/5e8f1e06280f8c9a7eaa5e56/207-p1_84.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/09/1e/8f/5e/5e8f1e09280f8c9a7eaa5e65/207-p1_91.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0c/1e/8f/5e/5e8f1e0c280f8c9a7eaa5e74/207-p1_98.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b4/1d/8f/5e/5e8f1db4ed4e477b86170844/212-p1_535.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b8/1d/8f/5e/5e8f1db8ed4e477b86170857/212-p1_526.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1d/8f/5e/5e8f1dbced4e477b8617086a/212-p1_517.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1d/8f/5e/5e8f1dc0ed4e477b8617087d/215-p1_273.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1d/8f/5e/5e8f1dc4ed4e477b86170890/215-p1_264.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ed4e477b861708a3/215-p1_255.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1d/8f/5e/5e8f1dcded4e477b861708b6/216-p1_186.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d0/1d/8f/5e/5e8f1dd0ed4e477b861708c7/216-p1_202.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ed/1e/8f/5e/5e8f1eed280f8c9a7eaa62cd/872-p1_252.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f0/1e/8f/5e/5e8f1ef0280f8c9a7eaa62dc/875-p1_217.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/1e/8f/5e/5e8f1ef3280f8c9a7eaa62eb/875-p1_224.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f6/1e/8f/5e/5e8f1ef6280f8c9a7eaa62fa/875-p1_231.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f8/1e/8f/5e/5e8f1ef8280f8c9a7eaa6309/878-p1_105.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fb/1e/8f/5e/5e8f1efb280f8c9a7eaa6318/878-p1_112.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fe/1e/8f/5e/5e8f1efe280f8c9a7eaa6327/878-p1_119.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/1f/8f/5e/5e8f1f01280f8c9a7eaa6336/881-p1_59.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1f/8f/5e/5e8f1f08280f8c9a7eaa6357/374-p1_6.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/09/1f/8f/5e/5e8f1f09280f8c9a7eaa6360/883-p1_417.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1f/8f/5e/5e8f1f0e280f8c9a7eaa6379/883-p1_527.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/1f/8f/5e/5e8f1f13280f8c9a7eaa6392/885-p1_429.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/19/1f/8f/5e/5e8f1f19280f8c9a7eaa63af/885-p1_539.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/af/1e/8f/5e/5e8f1eaf6d9228091d17133a/887-p1_443.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/1e/8f/5e/5e8f1eb56d9228091d171357/887-p1_553.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1e/8f/5e/5e8f1ebc6d9228091d171374/889-p1_457.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1e/8f/5e/5e8f1ec46d9228091d171391/889-p1_567.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1e/8f/5e/5e8f1e8eed4e477b86170c06/892-p1_471.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1e/8f/5e/5e8f1e94ed4e477b86170c1f/892-p1_483.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1e/8f/5e/5e8f1e99ed4e477b86170c38/894-p1_495.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/12/1e/8f/5e/5e8f1e12a063beb994aa64aa/894-p1_505.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/1e/8f/5e/5e8f1e17a063beb994aa64bf/896-p1_515.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1c/1e/8f/5e/5e8f1e1ca063beb994aa64d6/896-p1_526.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1e/8f/5e/5e8f1eca6d9228091d1713ae/109-p1_175.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1e/8f/5e/5e8f1ecd6d9228091d1713bd/899-p1_84.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d0/1e/8f/5e/5e8f1ed06d9228091d1713d2/936-p1_29.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d7/1e/8f/5e/5e8f1ed76d9228091d1713f1/936-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/dd/1e/8f/5e/5e8f1edd6d9228091d171410/821-p1_1205.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/1e/8f/5e/5e8f1ee26d9228091d171429/821-p1_1181.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e7/1e/8f/5e/5e8f1ee76d9228091d171442/940-p1_628.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1e/8f/5e/5e8f1eeb6d9228091d171455/940-p1_619.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ef/1e/8f/5e/5e8f1eef6d9228091d171468/942-p1_473.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/1e/8f/5e/5e8f1ef36d9228091d17147d/942-p1_463.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c2/1d/8f/5e/5e8f1dc284bc20132a170eb5/280-p1_586.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f7/1e/8f/5e/5e8f1ef76d9228091d171492/945-p1_375.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fd/1e/8f/5e/5e8f1efd6d9228091d1714aa/945-p1_388.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/1f/8f/5e/5e8f1f026d9228091d1714c2/947-p1_128.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1f/8f/5e/5e8f1f086d9228091d1714df/948-p1_575.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1f/8f/5e/5e8f1f0e6d9228091d1714fc/949-p1_924.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/15/1f/8f/5e/5e8f1f156d9228091d17151b/950-p1_939.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1c/1f/8f/5e/5e8f1f1c6d9228091d17153c/951-p1_1189.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/23/1f/8f/5e/5e8f1f236d9228091d17155b/952-p1_1204.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2b/1f/8f/5e/5e8f1f2b6d9228091d171576/953-p1_537.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/31/1f/8f/5e/5e8f1f316d9228091d171593/954-p1_551.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/38/1f/8f/5e/5e8f1f386d9228091d1715b0/955-p1_565.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3d/1f/8f/5e/5e8f1f3d6d9228091d1715c9/956-p4_589.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/44/1f/8f/5e/5e8f1f446d9228091d1715e6/956-p4_593.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/1f/8f/5e/5e8f1f4b6d9228091d171603/958-p5_604.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/50/1f/8f/5e/5e8f1f506d9228091d17161d/958-p5_608.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/7b/8d/5f/5f8d7bc73e9f62ef9d81d82c/2644-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/7b/8d/5f/5f8d7bce58481f1419e10ca8/2645-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8b/f4/24/60/6024f48bdf20a49a420163c4/2652-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/f4/24/60/6024f4d2cdf5096bd32b8ea4/2653-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/19/f5/24/60/6024f519df20a49a420163c7/2654-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/60/16/60/601660a29decc84758e5441a/2655-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ab/60/16/60/601660ab5a92e959fff5a39b/2656-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/60/16/60/601660c0b0f7e3e181c99073/2657-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/60/16/60/601660cab0f7e3e181c99074/2658-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/60/16/60/601660d3f814747dbe727635/2659-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/da/60/16/60/601660dab0f7e3e181c99076/2660-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/60/16/60/601660e2431acbf4255c7c93/2661-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/60/16/60/601660ebf814747dbe727637/2662-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/60/16/60/601660f3b0f7e3e181c99077/2663-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/61/16/60/60166100431acbf4255c7c95/2664-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0a/61/16/60/6016610a5a92e959fff5a39d/2665-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/14/61/16/60/60166114b0f7e3e181c99078/2666-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/48/1f/8f/5e/5e8f1f48ed4e477b86170f6d/2700-p1_470.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/1f/8f/5e/5e8f1f4bed4e477b86170f7a/2701-p1_452.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4d/1f/8f/5e/5e8f1f4ded4e477b86170f87/2701-p1_464.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4f/1f/8f/5e/5e8f1f4fed4e477b86170f94/2701-p1_458.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/52/1f/8f/5e/5e8f1f52ed4e477b86170fa1/2704-p1_447.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/54/1f/8f/5e/5e8f1f54ed4e477b86170fac/2705-p1_43.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/56/1f/8f/5e/5e8f1f56ed4e477b86170fb7/2706-p1_127.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/5f/1f/8f/5e/5e8f1f5fddd2a02a09aa7743/2707-p1_606.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/61/1f/8f/5e/5e8f1f61ddd2a02a09aa774d/7485-p1_618.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/64/1f/8f/5e/5e8f1f64ddd2a02a09aa775a/7485-p1_612.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/1f/8f/5e/5e8f1f66ddd2a02a09aa7767/2711-p1_37.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa778e/2713-p1_41.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa7791/2714-p1_42.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa7794/2715-p1_43.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/1f/8f/5e/5e8f1f6fddd2a02a09aa7797/2716-p1_44.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/1f/8f/5e/5e8f1f6fddd2a02a09aa779a/2717-p1_45.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/1f/8f/5e/5e8f1f70ddd2a02a09aa779d/2718-p1_46.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/73/1f/8f/5e/5e8f1f73ddd2a02a09aa77af/2719-p1_518.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/1f/8f/5e/5e8f1f77ddd2a02a09aa77be/2719-p1_525.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/1f/8f/5e/5e8f1f82ddd2a02a09aa77fa/2728-p1_196.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/84/1f/8f/5e/5e8f1f84ddd2a02a09aa7807/7407-p1_270.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/87/1f/8f/5e/5e8f1f87ddd2a02a09aa7814/7407-p1_264.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/bb/9d/5e/5e9dbb8e83fbabff2b4e00d4/3274-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/bb/9d/5e/5e9dbbbf8259bb717d3e3954/3275-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/1f/8f/5e/5e8f1fbfb72ee5bca1171046/3300-p1_751.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/1f/8f/5e/5e8f1f74a063beb994aa6b5f/3303-p1_741.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/1f/8f/5e/5e8f1f7ba063beb994aa6b74/3307-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/80/1f/8f/5e/5e8f1f80a063beb994aa6b85/3309-p1_724.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/1f/8f/5e/5e8f1f82a063beb994aa6b8f/3312-p1_739.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/87/1f/8f/5e/5e8f1f87a063beb994aa6ba8/3322-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/89/1f/8f/5e/5e8f1f89a063beb994aa6bb3/3326-p1_4.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8da063beb994aa6bc4/3327-p1_718.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8fa063beb994aa6bd1/3331-p1_139.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6c/22/8f/5e/5e8f226c2219862af5172a5a/3333-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/22/8f/5e/5e8f226e2219862af5172a68/3334-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/90/1f/8f/5e/5e8f1f90a063beb994aa6bd4/3337-p1_696.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1f/8f/5e/5e8f1f94a063beb994aa6be9/3338-p1_671.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1f/8f/5e/5e8f1f99a063beb994aa6bfe/3339-p1_687.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9ca063beb994aa6c11/3340-p1_681.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9f/1f/8f/5e/5e8f1f9fa063beb994aa6c1e/3341-p1_710.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1a063beb994aa6c2b/3350-p1_140.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1a063beb994aa6c2e/3351-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa2a063beb994aa6c31/3352-p1_0.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3a063beb994aa6c34/3353-p1_1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3a063beb994aa6c37/3354-p1_2.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a4/1f/8f/5e/5e8f1fa4a063beb994aa6c3a/3355-p1_3.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a4/1f/8f/5e/5e8f1fa4a063beb994aa6c3d/3356-p1_4.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5a063beb994aa6c40/3357-p1_5.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5a063beb994aa6c43/3358-p1_6.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c46/3359-p1_141.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c49/3360-p1_142.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c4c/3361-p1_143.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a7/1f/8f/5e/5e8f1fa7a063beb994aa6c4f/3362-p1_144.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a7/1f/8f/5e/5e8f1fa7a063beb994aa6c52/3363-p1_145.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8a063beb994aa6c55/3364-p1_7.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8a/1f/8f/5e/5e8f1f8a84bc20132a1716c3/3365-p1_8.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8b/1f/8f/5e/5e8f1f8b84bc20132a1716c6/3366-p1_9.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8c/1f/8f/5e/5e8f1f8c84bc20132a1716c9/3367-p1_10.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8c/1f/8f/5e/5e8f1f8c84bc20132a1716cc/3368-p1_11.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716cf/3369-p1_12.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716d2/3370-p1_13.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716d5/3371-p1_146.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1f/8f/5e/5e8f1f8e84bc20132a1716d8/3372-p1_147.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1f/8f/5e/5e8f1f8e84bc20132a1716db/3423-p1_14.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8f84bc20132a1716de/3469-p1_215.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/93/1f/8f/5e/5e8f1f9384bc20132a1716f3/3470-p1_195.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/97/1f/8f/5e/5e8f1f9784bc20132a171708/3471-p1_205.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9c84bc20132a17171d/3472-p1_245.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a0/1f/8f/5e/5e8f1fa084bc20132a171732/3473-p1_225.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa584bc20132a171747/3474-p1_235.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a9/1f/8f/5e/5e8f1fa984bc20132a17175c/3475-p1_264.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ac/1f/8f/5e/5e8f1fac84bc20132a17176f/3476-p1_255.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b0/1f/8f/5e/5e8f1fb084bc20132a171784/3477-p1_85.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b3/1f/8f/5e/5e8f1fb384bc20132a171793/3478-p1_92.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b6/1f/8f/5e/5e8f1fb684bc20132a1717a2/3479-p1_304.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b9/1f/8f/5e/5e8f1fb984bc20132a1717b5/3480-p1_312.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bd/1f/8f/5e/5e8f1fbd84bc20132a1717c8/3481-p1_99.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1f/8f/5e/5e8f1fc084bc20132a1717d7/3482-p1_280.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1f/8f/5e/5e8f1fc484bc20132a1717ea/3483-p1_296.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1f/8f/5e/5e8f1fc884bc20132a1717fd/3484-p1_288.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cb/1f/8f/5e/5e8f1fcb84bc20132a171810/3485-p1_320.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cf/1f/8f/5e/5e8f1fcf84bc20132a171823/3486-p1_272.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/22/8f/5e/5e8f226f2219862af5172a74/3500-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/22/8f/5e/5e8f22702219862af5172a78/3501-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/1f/8f/5e/5e8f1fd284bc20132a171836/3502.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/22/8f/5e/5e8f22682219862af5172a46/3503-p2.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6a/22/8f/5e/5e8f226a2219862af5172a51/3504-p2.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/22/8f/5e/5e8f226b2219862af5172a57/3505-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/1f/8f/5e/5e8f1fd384bc20132a171839/3507-p1_0.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/1f/8f/5e/5e8f1fd384bc20132a17183c/3508-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9c280f8c9a7eaa662d/3512-p1_3.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9d/1f/8f/5e/5e8f1f9d280f8c9a7eaa6634/3522-p1_14.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9e/1f/8f/5e/5e8f1f9e280f8c9a7eaa6638/3523-p1_15.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9f/1f/8f/5e/5e8f1f9f280f8c9a7eaa663c/3524-p1_5.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1280f8c9a7eaa6644/3525-p1_2.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa2280f8c9a7eaa664c/3526-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3280f8c9a7eaa6654/3527-p1_942.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5280f8c9a7eaa665c/3528-p1_11.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6280f8c9a7eaa6664/3529-p1_8.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/22/8f/5e/5e8f226e2219862af5172a6c/3559-p1_11.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8280f8c9a7eaa6672/3560-p1_935.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a9/1f/8f/5e/5e8f1fa9280f8c9a7eaa667a/3565-p1_933.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/aa/1f/8f/5e/5e8f1faa280f8c9a7eaa6680/3566-p1_931.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/b3/c3/5e/5ec3b3fae595f754a3e5f0f4/3575-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/15/b5/c3/5e/5ec3b5150b331d45e425137b/3576-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fc/b5/c3/5e/5ec3b5fc023d78b32c8dd394/3577-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b9/1f/8f/5e/5e8f1fb9280f8c9a7eaa66cc/3578-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d8/b6/c3/5e/5ec3b6d8e5de76c2c30dd196/3581-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7a/b7/c3/5e/5ec3b77a60da8c4227aa9f49/3582-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/b8/c3/5e/5ec3b8e50b331d45e425138f/3584-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/1f/8f/5e/5e8f1fc7280f8c9a7eaa670d/3585-p1_161.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/b9/c3/5e/5ec3b96f0b331d45e4251399/3586-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cb/1f/8f/5e/5e8f1fcb280f8c9a7eaa6723/3587-p1_248.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cf/1f/8f/5e/5e8f1fcf280f8c9a7eaa6738/3588-p1_228.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d4/1f/8f/5e/5e8f1fd4280f8c9a7eaa674d/3589-p1_170.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d8/1f/8f/5e/5e8f1fd8280f8c9a7eaa6762/3590-p1_258.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8f2219862af5171ca8/3591-p1_238.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1f/8f/5e/5e8f1f942219862af5171cbd/3592-p1_180.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1f/8f/5e/5e8f1f992219862af5171cd2/3593-p1_341.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9d/1f/8f/5e/5e8f1f9d2219862af5171ce7/3594-p1_331.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa22219862af5171cfc/3595-p1_402.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa62219862af5171d11/3596-p1_392.jpg',


                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/20/8f/5e/5e8f2001ddd2a02a09aa7a7e/3656-p1_32.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/20/8f/5e/5e8f2001ddd2a02a09aa7a82/3657-p1_16.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/20/8f/5e/5e8f2002ddd2a02a09aa7a8a/3658-p1_19.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/be/1f/8f/5e/5e8f1fbeed4e477b861711b1/3659-p1_22.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1f/8f/5e/5e8f1fc0ed4e477b861711bb/3660-p1_26.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c2/1f/8f/5e/5e8f1fc2ed4e477b861711c8/3664-p1_29.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c3/1f/8f/5e/5e8f1fc3ed4e477b861711cb/3665-p1_385.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/1f/8f/5e/5e8f1fc7ed4e477b861711e0/3666-p1_16.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1f/8f/5e/5e8f1fcaed4e477b861711f1/3667-p1_9.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1f/8f/5e/5e8f1fcded4e477b86171200/3668-p1_636.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/1f/8f/5e/5e8f1fceed4e477b86171203/3669-p1_475.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d1/1f/8f/5e/5e8f1fd1ed4e477b86171214/3673-p1_217.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/1f/8f/5e/5e8f1fd2ed4e477b8617121d/3674-p1_559.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d7/1f/8f/5e/5e8f1fd7ed4e477b86171232/3675-p1_651.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/da/1f/8f/5e/5e8f1fdaed4e477b86171245/3676-p1_642.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/df/1f/8f/5e/5e8f1fdfed4e477b86171258/3677-p1_634.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/1f/8f/5e/5e8f1fe2ed4e477b86171269/3680-p1_450.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e8/1f/8f/5e/5e8f1fe8ed4e477b86171282/3681-p1_442.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1f/8f/5e/5e8f1febed4e477b86171293/3682-p1_462.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ad/06/20/5f/5f2006adbed4fc08b6aba2fa/3683-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/07/20/5f/5f2007c098b68d60d91c6d5a/3684-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2c/08/20/5f/5f20082ccd66e1dcc45936ca/3685-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/07/20/8f/5e/5e8f2007ed4e477b8617131a/3689-p1_214.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0b/20/8f/5e/5e8f200bed4e477b8617132d/3690-p1_205.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0f/20/8f/5e/5e8f200fed4e477b86171340/3691-p1_809.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/20/8f/5e/5e8f2013ed4e477b86171355/3692-p1_799.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/20/8f/5e/5e8f2017ed4e477b8617136a/3694-p1_118.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1a/20/8f/5e/5e8f201aed4e477b8617137b/3695-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1d/20/8f/5e/5e8f201ded4e477b8617138a/3696-p1_142.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/20/20/8f/5e/5e8f2020ed4e477b86171399/3697-p1_133.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8a063beb994aa6c58/3698-p1_229.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/aa/1f/8f/5e/5e8f1faaa063beb994aa6c63/3700-p1_308.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ad/1f/8f/5e/5e8f1fada063beb994aa6c70/3701-p1_313.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b0/1f/8f/5e/5e8f1fb0a063beb994aa6c7d/3702-p1_318.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b2/1f/8f/5e/5e8f1fb2a063beb994aa6c8a/3705-p1_27.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/1f/8f/5e/5e8f1fb5a063beb994aa6c97/3706-p1_32.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b7/1f/8f/5e/5e8f1fb7a063beb994aa6ca4/3707-p1_37.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/1e/8f/5e/5e8f1e77a063beb994aa668a/3708-p1_42.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ba/1f/8f/5e/5e8f1fbaa063beb994aa6cb1/3709-p1_88.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/79/1e/8f/5e/5e8f1e79a063beb994aa6695/3710-p1_93.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7c/1e/8f/5e/5e8f1e7ca063beb994aa66a0/3711-p1_52.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7e/1e/8f/5e/5e8f1e7ea063beb994aa66ab/3712-p1_12.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1f/8f/5e/5e8f1fbca063beb994aa6cbe/3713-p1_17.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/1f/8f/5e/5e8f1fbfa063beb994aa6ccb/3714-p1_22.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c1/1f/8f/5e/5e8f1fc1a063beb994aa6cd8/3715-p1_57.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1f/8f/5e/5e8f1fc4a063beb994aa6ce5/3716-p1_47.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c6/1f/8f/5e/5e8f1fc6a063beb994aa6cf2/3717-p1_83.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',


                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1f/8f/5e/5e8f1fc8a063beb994aa6cff/3720-p1_151.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/20/8f/5e/5e8f206bed4e477b86171509/5129-p1_422.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6d/20/8f/5e/5e8f206ded4e477b86171512/5130-p1_426.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f2070ed4e477b8617151b/5131-p1_410.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/72/20/8f/5e/5e8f2072ed4e477b86171524/5132-p1_418.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/20/8f/5e/5e8f2074ed4e477b8617152d/5133-p1_414.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/76/20/8f/5e/5e8f2076ed4e477b86171536/5134-p1_705.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/26/20/8f/5e/5e8f202678cc4c8b37aa6a33/5135-p1_760.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/28/20/8f/5e/5e8f202878cc4c8b37aa6a3c/5136-p1_785.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2a/20/8f/5e/5e8f202a78cc4c8b37aa6a45/5137-p1_789.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2c/20/8f/5e/5e8f202c78cc4c8b37aa6a4e/5138-p1_717.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2e/20/8f/5e/5e8f202e78cc4c8b37aa6a57/5139-p1_3.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/30/20/8f/5e/5e8f203078cc4c8b37aa6a60/5140-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/62/22/8f/5e/5e8f2262ed4e477b86171e79/5141-p1_1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/95/21/7d/60/607d2195cf8743fe6ed5d4a5/5150-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/95/21/7d/60/607d2195cf8743fe6ed5d4a5/5150-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/22/65/69/60/606965225e92d6c3f4bf414b/5152-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/22/65/69/60/606965225e92d6c3f4bf414b/5152-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/35/58/60/605835f31137d94a7310b39d/5154-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/23/37/58/60/605837231ab1cc9ce0050c7e/5155-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/fe/a9/60/60a9fef37a140cbaa5fefaf4/5157-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/34/20/8f/5e/5e8f203478cc4c8b37aa6a72/5502-p1_41.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/96/47/5f/5f4796d9531c45b063f7b517/5503-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/96/47/5f/5f4796d9531c45b063f7b517/5503-P1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3c/20/8f/5e/5e8f203c78cc4c8b37aa6aa5/5566-p1_653.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/41/20/8f/5e/5e8f204178cc4c8b37aa6abe/1391-p1_619.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/46/20/8f/5e/5e8f204678cc4c8b37aa6ad5/5570-p1_410.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/20/8f/5e/5e8f204b78cc4c8b37aa6aea/5571-p1_10.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4f/20/8f/5e/5e8f204f78cc4c8b37aa6afd/5572-p1_512.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/56/20/8f/5e/5e8f205678cc4c8b37aa6b28/5745-p1_202.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3f/20/8f/5e/5e8f203f6d9228091d171ab9/5896-p1_245.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/42/20/8f/5e/5e8f20426d9228091d171ac8/5897-p1_252.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/45/20/8f/5e/5e8f20456d9228091d171ad7/5917-p1_259.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/22/8f/5e/5e8f22a184bc20132a17264f/5918-p1_59.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/22/8f/5e/5e8f22a684bc20132a172664/5918-p1_49.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ac/22/8f/5e/5e8f22ac84bc20132a172679/5920-p1_80.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b1/22/8f/5e/5e8f22b184bc20132a172690/5920-p1_69.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/22/8f/5e/5e8f22b584bc20132a1726a7/5922-p1_91.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bb/22/8f/5e/5e8f22bb84bc20132a1726be/5922-p1_102.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4d/20/8f/5e/5e8f204d6d9228091d171afe/5938-p1_59.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4e/20/8f/5e/5e8f204e6d9228091d171b01/5939-p1_60.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4e/20/8f/5e/5e8f204e6d9228091d171b04/5941-p1_302.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/55/20/8f/5e/5e8f20556d9228091d171b23/5941-p1_272.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/5b/20/8f/5e/5e8f205b6d9228091d171b42/5941-p1_287.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/62/20/8f/5e/5e8f20626d9228091d171b61/5943-p1_317.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f20686d9228091d171b7e/5943-p1_345.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/20/8f/5e/5e8f206e6d9228091d171b9b/5943-p1_331.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/20/8f/5e/5e8f20746d9228091d171bb8/5946-p1_359.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7c/20/8f/5e/5e8f207c6d9228091d171bd9/5946-p1_391.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/20/8f/5e/5e8f20826d9228091d171bfa/5946-p1_375.jpg',

                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/89/20/8f/5e/5e8f20896d9228091d171c1b/5949-p1_407.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e6/21/8f/5e/5e8f21e6b72ee5bca1171b1c/7091-p1_558.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ea/21/8f/5e/5e8f21eab72ee5bca1171b31/7083-p1_577.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ee/21/8f/5e/5e8f21eeb72ee5bca1171b44/7086-p1_536.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/21/8f/5e/5e8f21f3b72ee5bca1171b5a/7078-p1_470.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/21/8f/5e/5e8f21fab72ee5bca1171b70/7079-p1_420.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/22/8f/5e/5e8f2200b72ee5bca1171b8b/7080-p1_446.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/06/22/8f/5e/5e8f2206b72ee5bca1171ba4/7090-p1_586.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0a/22/8f/5e/5e8f220ab72ee5bca1171bb7/7091-p1_548.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0f/22/8f/5e/5e8f220fb72ee5bca1171bcc/7092-p1_568.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/22/8f/5e/5e8f2213b72ee5bca1171bdf/7086-p1_524.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/22/8f/5e/5e8f2217b72ee5bca1171bf5/7098-p1_56.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f2070280f8c9a7eaa6a68/7099-p1_42.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f2077280f8c9a7eaa6a8e/7113-p1_204.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/79/20/8f/5e/5e8f2079280f8c9a7eaa6a99/7114-p1_176.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/20/8f/5e/5e8f207b280f8c9a7eaa6aa4/7115-p1_171.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7d/20/8f/5e/5e8f207d280f8c9a7eaa6aaf/7116-p1_166.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7f/20/8f/5e/5e8f207f280f8c9a7eaa6aba/4259-p1_56.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/81/20/8f/5e/5e8f2081280f8c9a7eaa6ac5/4259-p1_61.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/20/8f/5e/5e8f2082280f8c9a7eaa6ad0/7150-p1_499.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/88/20/8f/5e/5e8f2088280f8c9a7eaa6ae9/7126-p1_66.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/64/20/8f/5e/5e8f2064a063beb994aa7013/7142-p1_398.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/20/8f/5e/5e8f2066a063beb994aa701e/7143-p1_403.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f2068a063beb994aa7029/7144-p1_408.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6a/20/8f/5e/5e8f206aa063beb994aa7034/7145-p1_452.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6d/20/8f/5e/5e8f206da063beb994aa703f/7146-p1_526.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/20/8f/5e/5e8f206fa063beb994aa704a/7147-p1_536.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/71/20/8f/5e/5e8f2071a063beb994aa7055/7148-p1_393.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/73/20/8f/5e/5e8f2073a063beb994aa7060/7150-p1_481.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f2077a063beb994aa7073/7150-p1_490.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/20/8f/5e/5e8f207ba063beb994aa7089/7155-p1_125.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7d/20/8f/5e/5e8f207da063beb994aa7094/7156-p1_531.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7f/20/8f/5e/5e8f207fa063beb994aa709f/4472-p1_189.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/83/20/8f/5e/5e8f2083a063beb994aa70b9/7177-p1_17.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/20/8f/5e/5e8f206678cc4c8b37aa6b79/4254-p1_144.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f206878cc4c8b37aa6b84/4254-p1_139.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/20/8f/5e/5e8f206b78cc4c8b37aa6b98/7199-p1_35.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6c/20/8f/5e/5e8f206c78cc4c8b37aa6ba1/7202-p1_38.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/20/8f/5e/5e8f206e78cc4c8b37aa6baa/7216-p1.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f207078cc4c8b37aa6bb5/7217-p1_562.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/72/20/8f/5e/5e8f207278cc4c8b37aa6bc0/7218-p1_552.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/75/20/8f/5e/5e8f207578cc4c8b37aa6bce/7220-p1_557.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f207778cc4c8b37aa6bd9/a66x134b22-p1_23.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7a/20/8f/5e/5e8f207a78cc4c8b37aa6be9/7236-p1_130.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7e/20/8f/5e/5e8f207e78cc4c8b37aa6bfc/7236-p1_139.jpg',
                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/81/20/8f/5e/5e8f208178cc4c8b37aa6c0f/7236-p1_148.jpg'
            );
            //            var_dump($x);die;
            foreach ($x as $k => $v) {
                if (!file_get_contents($v)) {
                    echo $v;
                    echo '</br>';
                    echo '</br>';
                    echo '</br>';
                }
            }
            die;

            //            $rows = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\Products,public_path('Trading.xlsx'));
            ////            return $rows[0];
            //            $x = array(
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/1e/8f/5e/5e8f1e022219862af5171584/sa66x134-p1_237.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/05/1e/8f/5e/5e8f1e052219862af5171593/sa66x134-p1_230.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1e/8f/5e/5e8f1e082219862af51715a2/sa66x134-p1_223.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0b/1e/8f/5e/5e8f1e0b2219862af51715b1/sa66x134-p1_258.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1e/8f/5e/5e8f1e0e2219862af51715c0/sa66x134-p1_251.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/11/1e/8f/5e/5e8f1e112219862af51715cf/sa66x134-p1_244.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/14/1e/8f/5e/5e8f1e142219862af51715de/165-p1_196.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/1e/8f/5e/5e8f1e172219862af51715ed/165-p1_203.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1a/1e/8f/5e/5e8f1e1a2219862af51715fc/165-p1_210.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1d/1e/8f/5e/5e8f1e1d2219862af517160b/863-p1_459.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/20/1e/8f/5e/5e8f1e202219862af517161a/863-p1_452.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b4/1d/8f/5e/5e8f1db4280f8c9a7eaa5caf/863-p1_445.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b7/1d/8f/5e/5e8f1db7280f8c9a7eaa5cbe/171-p1_276.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bb/1d/8f/5e/5e8f1dbb280f8c9a7eaa5ccf/171-p1_292.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/be/1d/8f/5e/5e8f1dbe280f8c9a7eaa5ce0/171-p1_284.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c1/1d/8f/5e/5e8f1dc1280f8c9a7eaa5cf1/174-p1_612.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1d/8f/5e/5e8f1dc4280f8c9a7eaa5d00/174-p1_626.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c6/1d/8f/5e/5e8f1dc6280f8c9a7eaa5d0f/174-p1_619.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1d/8f/5e/5e8f1dca280f8c9a7eaa5d1e/186-p1_104.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cc/1d/8f/5e/5e8f1dcc280f8c9a7eaa5d2a/186-p1_111.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/1d/8f/5e/5e8f1dce280f8c9a7eaa5d36/189-p1_622.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d1/1d/8f/5e/5e8f1dd1280f8c9a7eaa5d45/189-p1_629.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d4/1d/8f/5e/5e8f1dd4280f8c9a7eaa5d54/189-p1_636.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d6/1d/8f/5e/5e8f1dd6280f8c9a7eaa5d63/192-p1_15.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/1d/8f/5e/5e8f1dd9280f8c9a7eaa5d74/192-p1_23.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/dd/1d/8f/5e/5e8f1ddd280f8c9a7eaa5d85/192-p1_31.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e1/1d/8f/5e/5e8f1de1280f8c9a7eaa5d96/195-p1_643.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e4/1d/8f/5e/5e8f1de4280f8c9a7eaa5da7/195-p1_651.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e8/1d/8f/5e/5e8f1de8280f8c9a7eaa5db8/195-p1_659.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1d/8f/5e/5e8f1deb280f8c9a7eaa5dc9/198-p1_39.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ee/1d/8f/5e/5e8f1dee280f8c9a7eaa5dda/198-p1_47.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f1/1d/8f/5e/5e8f1df1280f8c9a7eaa5deb/198-p1_55.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f5/1d/8f/5e/5e8f1df5280f8c9a7eaa5dfc/201-p1_343.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f8/1d/8f/5e/5e8f1df8280f8c9a7eaa5e0b/201-p1_350.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/1d/8f/5e/5e8f1dfa280f8c9a7eaa5e1a/201-p1_357.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fd/1d/8f/5e/5e8f1dfd280f8c9a7eaa5e29/204-p1_63.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/1e/8f/5e/5e8f1e00280f8c9a7eaa5e38/204-p1_70.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/03/1e/8f/5e/5e8f1e03280f8c9a7eaa5e47/204-p1_77.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/06/1e/8f/5e/5e8f1e06280f8c9a7eaa5e56/207-p1_84.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/09/1e/8f/5e/5e8f1e09280f8c9a7eaa5e65/207-p1_91.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0c/1e/8f/5e/5e8f1e0c280f8c9a7eaa5e74/207-p1_98.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b4/1d/8f/5e/5e8f1db4ed4e477b86170844/212-p1_535.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b8/1d/8f/5e/5e8f1db8ed4e477b86170857/212-p1_526.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1d/8f/5e/5e8f1dbced4e477b8617086a/212-p1_517.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1d/8f/5e/5e8f1dc0ed4e477b8617087d/215-p1_273.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1d/8f/5e/5e8f1dc4ed4e477b86170890/215-p1_264.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ed4e477b861708a3/215-p1_255.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1d/8f/5e/5e8f1dcded4e477b861708b6/216-p1_186.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d0/1d/8f/5e/5e8f1dd0ed4e477b861708c7/216-p1_202.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ed/1e/8f/5e/5e8f1eed280f8c9a7eaa62cd/872-p1_252.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f0/1e/8f/5e/5e8f1ef0280f8c9a7eaa62dc/875-p1_217.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/1e/8f/5e/5e8f1ef3280f8c9a7eaa62eb/875-p1_224.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f6/1e/8f/5e/5e8f1ef6280f8c9a7eaa62fa/875-p1_231.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f8/1e/8f/5e/5e8f1ef8280f8c9a7eaa6309/878-p1_105.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fb/1e/8f/5e/5e8f1efb280f8c9a7eaa6318/878-p1_112.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fe/1e/8f/5e/5e8f1efe280f8c9a7eaa6327/878-p1_119.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/1f/8f/5e/5e8f1f01280f8c9a7eaa6336/881-p1_59.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1f/8f/5e/5e8f1f08280f8c9a7eaa6357/374-p1_6.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/09/1f/8f/5e/5e8f1f09280f8c9a7eaa6360/883-p1_417.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1f/8f/5e/5e8f1f0e280f8c9a7eaa6379/883-p1_527.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/1f/8f/5e/5e8f1f13280f8c9a7eaa6392/885-p1_429.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/19/1f/8f/5e/5e8f1f19280f8c9a7eaa63af/885-p1_539.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/af/1e/8f/5e/5e8f1eaf6d9228091d17133a/887-p1_443.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/1e/8f/5e/5e8f1eb56d9228091d171357/887-p1_553.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1e/8f/5e/5e8f1ebc6d9228091d171374/889-p1_457.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1e/8f/5e/5e8f1ec46d9228091d171391/889-p1_567.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1e/8f/5e/5e8f1e8eed4e477b86170c06/892-p1_471.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1e/8f/5e/5e8f1e94ed4e477b86170c1f/892-p1_483.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1e/8f/5e/5e8f1e99ed4e477b86170c38/894-p1_495.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/12/1e/8f/5e/5e8f1e12a063beb994aa64aa/894-p1_505.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/1e/8f/5e/5e8f1e17a063beb994aa64bf/896-p1_515.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1c/1e/8f/5e/5e8f1e1ca063beb994aa64d6/896-p1_526.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1e/8f/5e/5e8f1eca6d9228091d1713ae/109-p1_175.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1e/8f/5e/5e8f1ecd6d9228091d1713bd/899-p1_84.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d0/1e/8f/5e/5e8f1ed06d9228091d1713d2/936-p1_29.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d7/1e/8f/5e/5e8f1ed76d9228091d1713f1/936-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/dd/1e/8f/5e/5e8f1edd6d9228091d171410/821-p1_1205.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/1e/8f/5e/5e8f1ee26d9228091d171429/821-p1_1181.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e7/1e/8f/5e/5e8f1ee76d9228091d171442/940-p1_628.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1e/8f/5e/5e8f1eeb6d9228091d171455/940-p1_619.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ef/1e/8f/5e/5e8f1eef6d9228091d171468/942-p1_473.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/1e/8f/5e/5e8f1ef36d9228091d17147d/942-p1_463.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c2/1d/8f/5e/5e8f1dc284bc20132a170eb5/280-p1_586.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f7/1e/8f/5e/5e8f1ef76d9228091d171492/945-p1_375.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fd/1e/8f/5e/5e8f1efd6d9228091d1714aa/945-p1_388.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/1f/8f/5e/5e8f1f026d9228091d1714c2/947-p1_128.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/08/1f/8f/5e/5e8f1f086d9228091d1714df/948-p1_575.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0e/1f/8f/5e/5e8f1f0e6d9228091d1714fc/949-p1_924.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/15/1f/8f/5e/5e8f1f156d9228091d17151b/950-p1_939.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1c/1f/8f/5e/5e8f1f1c6d9228091d17153c/951-p1_1189.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/23/1f/8f/5e/5e8f1f236d9228091d17155b/952-p1_1204.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2b/1f/8f/5e/5e8f1f2b6d9228091d171576/953-p1_537.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/31/1f/8f/5e/5e8f1f316d9228091d171593/954-p1_551.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/38/1f/8f/5e/5e8f1f386d9228091d1715b0/955-p1_565.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3d/1f/8f/5e/5e8f1f3d6d9228091d1715c9/956-p4_589.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/44/1f/8f/5e/5e8f1f446d9228091d1715e6/956-p4_593.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/1f/8f/5e/5e8f1f4b6d9228091d171603/958-p5_604.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/50/1f/8f/5e/5e8f1f506d9228091d17161d/958-p5_608.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/7b/8d/5f/5f8d7bc73e9f62ef9d81d82c/2644-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/7b/8d/5f/5f8d7bce58481f1419e10ca8/2645-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/7b/8d/5f/5f8d7be53e9f62ef9d81d82f/2648-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/18/34/df/5f/5fdf3418bfd208fd441b623f/2649-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8b/f4/24/60/6024f48bdf20a49a420163c4/2652-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/f4/24/60/6024f4d2cdf5096bd32b8ea4/2653-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/19/f5/24/60/6024f519df20a49a420163c7/2654-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/60/16/60/601660a29decc84758e5441a/2655-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ab/60/16/60/601660ab5a92e959fff5a39b/2656-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/60/16/60/601660c0b0f7e3e181c99073/2657-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/60/16/60/601660cab0f7e3e181c99074/2658-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/60/16/60/601660d3f814747dbe727635/2659-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/da/60/16/60/601660dab0f7e3e181c99076/2660-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/60/16/60/601660e2431acbf4255c7c93/2661-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/60/16/60/601660ebf814747dbe727637/2662-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/60/16/60/601660f3b0f7e3e181c99077/2663-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/61/16/60/60166100431acbf4255c7c95/2664-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0a/61/16/60/6016610a5a92e959fff5a39d/2665-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/14/61/16/60/60166114b0f7e3e181c99078/2666-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/57/24/85/60/60852457842bea42233eebdc/2667-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/48/1f/8f/5e/5e8f1f48ed4e477b86170f6d/2700-p1_470.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/1f/8f/5e/5e8f1f4bed4e477b86170f7a/2701-p1_452.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4d/1f/8f/5e/5e8f1f4ded4e477b86170f87/2701-p1_464.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4f/1f/8f/5e/5e8f1f4fed4e477b86170f94/2701-p1_458.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/52/1f/8f/5e/5e8f1f52ed4e477b86170fa1/2704-p1_447.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/54/1f/8f/5e/5e8f1f54ed4e477b86170fac/2705-p1_43.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/56/1f/8f/5e/5e8f1f56ed4e477b86170fb7/2706-p1_127.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/5f/1f/8f/5e/5e8f1f5fddd2a02a09aa7743/2707-p1_606.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/61/1f/8f/5e/5e8f1f61ddd2a02a09aa774d/7485-p1_618.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/64/1f/8f/5e/5e8f1f64ddd2a02a09aa775a/7485-p1_612.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/1f/8f/5e/5e8f1f66ddd2a02a09aa7767/2711-p1_37.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa778e/2713-p1_41.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa7791/2714-p1_42.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/1f/8f/5e/5e8f1f6eddd2a02a09aa7794/2715-p1_43.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/1f/8f/5e/5e8f1f6fddd2a02a09aa7797/2716-p1_44.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/1f/8f/5e/5e8f1f6fddd2a02a09aa779a/2717-p1_45.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/1f/8f/5e/5e8f1f70ddd2a02a09aa779d/2718-p1_46.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/73/1f/8f/5e/5e8f1f73ddd2a02a09aa77af/2719-p1_518.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/1f/8f/5e/5e8f1f77ddd2a02a09aa77be/2719-p1_525.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/1f/8f/5e/5e8f1f82ddd2a02a09aa77fa/2728-p1_196.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/84/1f/8f/5e/5e8f1f84ddd2a02a09aa7807/7407-p1_270.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/87/1f/8f/5e/5e8f1f87ddd2a02a09aa7814/7407-p1_264.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/bb/9d/5e/5e9dbb8e83fbabff2b4e00d4/3274-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/bb/9d/5e/5e9dbbbf8259bb717d3e3954/3275-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/1f/8f/5e/5e8f1fbfb72ee5bca1171046/3300-p1_751.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/1f/8f/5e/5e8f1f74a063beb994aa6b5f/3303-p1_741.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/1f/8f/5e/5e8f1f7ba063beb994aa6b74/3307-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/80/1f/8f/5e/5e8f1f80a063beb994aa6b85/3309-p1_724.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/1f/8f/5e/5e8f1f82a063beb994aa6b8f/3312-p1_739.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/87/1f/8f/5e/5e8f1f87a063beb994aa6ba8/3322-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/89/1f/8f/5e/5e8f1f89a063beb994aa6bb3/3326-p1_4.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8da063beb994aa6bc4/3327-p1_718.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8fa063beb994aa6bd1/3331-p1_139.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6c/22/8f/5e/5e8f226c2219862af5172a5a/3333-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/22/8f/5e/5e8f226e2219862af5172a68/3334-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/90/1f/8f/5e/5e8f1f90a063beb994aa6bd4/3337-p1_696.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1f/8f/5e/5e8f1f94a063beb994aa6be9/3338-p1_671.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1f/8f/5e/5e8f1f99a063beb994aa6bfe/3339-p1_687.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9ca063beb994aa6c11/3340-p1_681.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9f/1f/8f/5e/5e8f1f9fa063beb994aa6c1e/3341-p1_710.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1a063beb994aa6c2b/3350-p1_140.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1a063beb994aa6c2e/3351-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa2a063beb994aa6c31/3352-p1_0.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3a063beb994aa6c34/3353-p1_1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3a063beb994aa6c37/3354-p1_2.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a4/1f/8f/5e/5e8f1fa4a063beb994aa6c3a/3355-p1_3.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a4/1f/8f/5e/5e8f1fa4a063beb994aa6c3d/3356-p1_4.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5a063beb994aa6c40/3357-p1_5.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5a063beb994aa6c43/3358-p1_6.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c46/3359-p1_141.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c49/3360-p1_142.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6a063beb994aa6c4c/3361-p1_143.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a7/1f/8f/5e/5e8f1fa7a063beb994aa6c4f/3362-p1_144.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a7/1f/8f/5e/5e8f1fa7a063beb994aa6c52/3363-p1_145.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8a063beb994aa6c55/3364-p1_7.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8a/1f/8f/5e/5e8f1f8a84bc20132a1716c3/3365-p1_8.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8b/1f/8f/5e/5e8f1f8b84bc20132a1716c6/3366-p1_9.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8c/1f/8f/5e/5e8f1f8c84bc20132a1716c9/3367-p1_10.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8c/1f/8f/5e/5e8f1f8c84bc20132a1716cc/3368-p1_11.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716cf/3369-p1_12.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716d2/3370-p1_13.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8d/1f/8f/5e/5e8f1f8d84bc20132a1716d5/3371-p1_146.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1f/8f/5e/5e8f1f8e84bc20132a1716d8/3372-p1_147.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8e/1f/8f/5e/5e8f1f8e84bc20132a1716db/3423-p1_14.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8f84bc20132a1716de/3469-p1_215.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/93/1f/8f/5e/5e8f1f9384bc20132a1716f3/3470-p1_195.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/97/1f/8f/5e/5e8f1f9784bc20132a171708/3471-p1_205.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9c84bc20132a17171d/3472-p1_245.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a0/1f/8f/5e/5e8f1fa084bc20132a171732/3473-p1_225.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa584bc20132a171747/3474-p1_235.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a9/1f/8f/5e/5e8f1fa984bc20132a17175c/3475-p1_264.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ac/1f/8f/5e/5e8f1fac84bc20132a17176f/3476-p1_255.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b0/1f/8f/5e/5e8f1fb084bc20132a171784/3477-p1_85.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b3/1f/8f/5e/5e8f1fb384bc20132a171793/3478-p1_92.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b6/1f/8f/5e/5e8f1fb684bc20132a1717a2/3479-p1_304.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b9/1f/8f/5e/5e8f1fb984bc20132a1717b5/3480-p1_312.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bd/1f/8f/5e/5e8f1fbd84bc20132a1717c8/3481-p1_99.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1f/8f/5e/5e8f1fc084bc20132a1717d7/3482-p1_280.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1f/8f/5e/5e8f1fc484bc20132a1717ea/3483-p1_296.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1f/8f/5e/5e8f1fc884bc20132a1717fd/3484-p1_288.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cb/1f/8f/5e/5e8f1fcb84bc20132a171810/3485-p1_320.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cf/1f/8f/5e/5e8f1fcf84bc20132a171823/3486-p1_272.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/22/8f/5e/5e8f226f2219862af5172a74/3500-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/22/8f/5e/5e8f22702219862af5172a78/3501-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/1f/8f/5e/5e8f1fd284bc20132a171836/3502.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/22/8f/5e/5e8f22682219862af5172a46/3503-p2.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6a/22/8f/5e/5e8f226a2219862af5172a51/3504-p2.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/22/8f/5e/5e8f226b2219862af5172a57/3505-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/1f/8f/5e/5e8f1fd384bc20132a171839/3507-p1_0.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d3/1f/8f/5e/5e8f1fd384bc20132a17183c/3508-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9c/1f/8f/5e/5e8f1f9c280f8c9a7eaa662d/3512-p1_3.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9d/1f/8f/5e/5e8f1f9d280f8c9a7eaa6634/3522-p1_14.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9e/1f/8f/5e/5e8f1f9e280f8c9a7eaa6638/3523-p1_15.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9f/1f/8f/5e/5e8f1f9f280f8c9a7eaa663c/3524-p1_5.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/1f/8f/5e/5e8f1fa1280f8c9a7eaa6644/3525-p1_2.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa2280f8c9a7eaa664c/3526-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a3/1f/8f/5e/5e8f1fa3280f8c9a7eaa6654/3527-p1_942.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a5/1f/8f/5e/5e8f1fa5280f8c9a7eaa665c/3528-p1_11.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa6280f8c9a7eaa6664/3529-p1_8.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/22/8f/5e/5e8f226e2219862af5172a6c/3559-p1_11.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8280f8c9a7eaa6672/3560-p1_935.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a9/1f/8f/5e/5e8f1fa9280f8c9a7eaa667a/3565-p1_933.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/aa/1f/8f/5e/5e8f1faa280f8c9a7eaa6680/3566-p1_931.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/b3/c3/5e/5ec3b3fae595f754a3e5f0f4/3575-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/15/b5/c3/5e/5ec3b5150b331d45e425137b/3576-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fc/b5/c3/5e/5ec3b5fc023d78b32c8dd394/3577-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b9/1f/8f/5e/5e8f1fb9280f8c9a7eaa66cc/3578-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d8/b6/c3/5e/5ec3b6d8e5de76c2c30dd196/3581-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7a/b7/c3/5e/5ec3b77a60da8c4227aa9f49/3582-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e5/b8/c3/5e/5ec3b8e50b331d45e425138f/3584-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/1f/8f/5e/5e8f1fc7280f8c9a7eaa670d/3585-p1_161.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/b9/c3/5e/5ec3b96f0b331d45e4251399/3586-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cb/1f/8f/5e/5e8f1fcb280f8c9a7eaa6723/3587-p1_248.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cf/1f/8f/5e/5e8f1fcf280f8c9a7eaa6738/3588-p1_228.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d4/1f/8f/5e/5e8f1fd4280f8c9a7eaa674d/3589-p1_170.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d8/1f/8f/5e/5e8f1fd8280f8c9a7eaa6762/3590-p1_258.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/8f/1f/8f/5e/5e8f1f8f2219862af5171ca8/3591-p1_238.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/94/1f/8f/5e/5e8f1f942219862af5171cbd/3592-p1_180.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/99/1f/8f/5e/5e8f1f992219862af5171cd2/3593-p1_341.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/9d/1f/8f/5e/5e8f1f9d2219862af5171ce7/3594-p1_331.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a2/1f/8f/5e/5e8f1fa22219862af5171cfc/3595-p1_402.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/1f/8f/5e/5e8f1fa62219862af5171d11/3596-p1_392.jpg',
            //
            //
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/20/8f/5e/5e8f2001ddd2a02a09aa7a7e/3656-p1_32.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/01/20/8f/5e/5e8f2001ddd2a02a09aa7a82/3657-p1_16.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/02/20/8f/5e/5e8f2002ddd2a02a09aa7a8a/3658-p1_19.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/be/1f/8f/5e/5e8f1fbeed4e477b861711b1/3659-p1_22.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/1f/8f/5e/5e8f1fc0ed4e477b861711bb/3660-p1_26.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c2/1f/8f/5e/5e8f1fc2ed4e477b861711c8/3664-p1_29.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c3/1f/8f/5e/5e8f1fc3ed4e477b861711cb/3665-p1_385.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c7/1f/8f/5e/5e8f1fc7ed4e477b861711e0/3666-p1_16.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ca/1f/8f/5e/5e8f1fcaed4e477b861711f1/3667-p1_9.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/cd/1f/8f/5e/5e8f1fcded4e477b86171200/3668-p1_636.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ce/1f/8f/5e/5e8f1fceed4e477b86171203/3669-p1_475.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d1/1f/8f/5e/5e8f1fd1ed4e477b86171214/3673-p1_217.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d2/1f/8f/5e/5e8f1fd2ed4e477b8617121d/3674-p1_559.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d7/1f/8f/5e/5e8f1fd7ed4e477b86171232/3675-p1_651.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/da/1f/8f/5e/5e8f1fdaed4e477b86171245/3676-p1_642.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/df/1f/8f/5e/5e8f1fdfed4e477b86171258/3677-p1_634.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e2/1f/8f/5e/5e8f1fe2ed4e477b86171269/3680-p1_450.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e8/1f/8f/5e/5e8f1fe8ed4e477b86171282/3681-p1_442.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/eb/1f/8f/5e/5e8f1febed4e477b86171293/3682-p1_462.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ad/06/20/5f/5f2006adbed4fc08b6aba2fa/3683-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c0/07/20/5f/5f2007c098b68d60d91c6d5a/3684-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2c/08/20/5f/5f20082ccd66e1dcc45936ca/3685-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/07/20/8f/5e/5e8f2007ed4e477b8617131a/3689-p1_214.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0b/20/8f/5e/5e8f200bed4e477b8617132d/3690-p1_205.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0f/20/8f/5e/5e8f200fed4e477b86171340/3691-p1_809.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/20/8f/5e/5e8f2013ed4e477b86171355/3692-p1_799.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/20/8f/5e/5e8f2017ed4e477b8617136a/3694-p1_118.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1a/20/8f/5e/5e8f201aed4e477b8617137b/3695-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/1d/20/8f/5e/5e8f201ded4e477b8617138a/3696-p1_142.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/20/20/8f/5e/5e8f2020ed4e477b86171399/3697-p1_133.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a8/1f/8f/5e/5e8f1fa8a063beb994aa6c58/3698-p1_229.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/aa/1f/8f/5e/5e8f1faaa063beb994aa6c63/3700-p1_308.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ad/1f/8f/5e/5e8f1fada063beb994aa6c70/3701-p1_313.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b0/1f/8f/5e/5e8f1fb0a063beb994aa6c7d/3702-p1_318.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b2/1f/8f/5e/5e8f1fb2a063beb994aa6c8a/3705-p1_27.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/1f/8f/5e/5e8f1fb5a063beb994aa6c97/3706-p1_32.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b7/1f/8f/5e/5e8f1fb7a063beb994aa6ca4/3707-p1_37.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/1e/8f/5e/5e8f1e77a063beb994aa668a/3708-p1_42.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ba/1f/8f/5e/5e8f1fbaa063beb994aa6cb1/3709-p1_88.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/79/1e/8f/5e/5e8f1e79a063beb994aa6695/3710-p1_93.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7c/1e/8f/5e/5e8f1e7ca063beb994aa66a0/3711-p1_52.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7e/1e/8f/5e/5e8f1e7ea063beb994aa66ab/3712-p1_12.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bc/1f/8f/5e/5e8f1fbca063beb994aa6cbe/3713-p1_17.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bf/1f/8f/5e/5e8f1fbfa063beb994aa6ccb/3714-p1_22.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c1/1f/8f/5e/5e8f1fc1a063beb994aa6cd8/3715-p1_57.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c4/1f/8f/5e/5e8f1fc4a063beb994aa6ce5/3716-p1_47.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c6/1f/8f/5e/5e8f1fc6a063beb994aa6cf2/3717-p1_83.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //
            //
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1f/8f/5e/5e8f1fc8a063beb994aa6cff/3720-p1_151.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/20/8f/5e/5e8f206bed4e477b86171509/5129-p1_422.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6d/20/8f/5e/5e8f206ded4e477b86171512/5130-p1_426.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f2070ed4e477b8617151b/5131-p1_410.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/72/20/8f/5e/5e8f2072ed4e477b86171524/5132-p1_418.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/20/8f/5e/5e8f2074ed4e477b8617152d/5133-p1_414.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/76/20/8f/5e/5e8f2076ed4e477b86171536/5134-p1_705.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/26/20/8f/5e/5e8f202678cc4c8b37aa6a33/5135-p1_760.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/28/20/8f/5e/5e8f202878cc4c8b37aa6a3c/5136-p1_785.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2a/20/8f/5e/5e8f202a78cc4c8b37aa6a45/5137-p1_789.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2c/20/8f/5e/5e8f202c78cc4c8b37aa6a4e/5138-p1_717.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/2e/20/8f/5e/5e8f202e78cc4c8b37aa6a57/5139-p1_3.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/30/20/8f/5e/5e8f203078cc4c8b37aa6a60/5140-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/62/22/8f/5e/5e8f2262ed4e477b86171e79/5141-p1_1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/95/21/7d/60/607d2195cf8743fe6ed5d4a5/5150-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/95/21/7d/60/607d2195cf8743fe6ed5d4a5/5150-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/22/65/69/60/606965225e92d6c3f4bf414b/5152-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/22/65/69/60/606965225e92d6c3f4bf414b/5152-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/35/58/60/605835f31137d94a7310b39d/5154-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/23/37/58/60/605837231ab1cc9ce0050c7e/5155-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/fe/a9/60/60a9fef37a140cbaa5fefaf4/5157-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/34/20/8f/5e/5e8f203478cc4c8b37aa6a72/5502-p1_41.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/96/47/5f/5f4796d9531c45b063f7b517/5503-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/d9/96/47/5f/5f4796d9531c45b063f7b517/5503-P1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3c/20/8f/5e/5e8f203c78cc4c8b37aa6aa5/5566-p1_653.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/41/20/8f/5e/5e8f204178cc4c8b37aa6abe/1391-p1_619.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/46/20/8f/5e/5e8f204678cc4c8b37aa6ad5/5570-p1_410.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4b/20/8f/5e/5e8f204b78cc4c8b37aa6aea/5571-p1_10.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4f/20/8f/5e/5e8f204f78cc4c8b37aa6afd/5572-p1_512.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/56/20/8f/5e/5e8f205678cc4c8b37aa6b28/5745-p1_202.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/3f/20/8f/5e/5e8f203f6d9228091d171ab9/5896-p1_245.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/42/20/8f/5e/5e8f20426d9228091d171ac8/5897-p1_252.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/45/20/8f/5e/5e8f20456d9228091d171ad7/5917-p1_259.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a1/22/8f/5e/5e8f22a184bc20132a17264f/5918-p1_59.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/a6/22/8f/5e/5e8f22a684bc20132a172664/5918-p1_49.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ac/22/8f/5e/5e8f22ac84bc20132a172679/5920-p1_80.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b1/22/8f/5e/5e8f22b184bc20132a172690/5920-p1_69.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/b5/22/8f/5e/5e8f22b584bc20132a1726a7/5922-p1_91.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/bb/22/8f/5e/5e8f22bb84bc20132a1726be/5922-p1_102.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4d/20/8f/5e/5e8f204d6d9228091d171afe/5938-p1_59.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4e/20/8f/5e/5e8f204e6d9228091d171b01/5939-p1_60.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/4e/20/8f/5e/5e8f204e6d9228091d171b04/5941-p1_302.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/55/20/8f/5e/5e8f20556d9228091d171b23/5941-p1_272.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/5b/20/8f/5e/5e8f205b6d9228091d171b42/5941-p1_287.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/62/20/8f/5e/5e8f20626d9228091d171b61/5943-p1_317.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f20686d9228091d171b7e/5943-p1_345.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/20/8f/5e/5e8f206e6d9228091d171b9b/5943-p1_331.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/74/20/8f/5e/5e8f20746d9228091d171bb8/5946-p1_359.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7c/20/8f/5e/5e8f207c6d9228091d171bd9/5946-p1_391.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/20/8f/5e/5e8f20826d9228091d171bfa/5946-p1_375.jpg',
            //
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/89/20/8f/5e/5e8f20896d9228091d171c1b/5949-p1_407.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/e6/21/8f/5e/5e8f21e6b72ee5bca1171b1c/7091-p1_558.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ea/21/8f/5e/5e8f21eab72ee5bca1171b31/7083-p1_577.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/ee/21/8f/5e/5e8f21eeb72ee5bca1171b44/7086-p1_536.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/f3/21/8f/5e/5e8f21f3b72ee5bca1171b5a/7078-p1_470.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/fa/21/8f/5e/5e8f21fab72ee5bca1171b70/7079-p1_420.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/00/22/8f/5e/5e8f2200b72ee5bca1171b8b/7080-p1_446.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/06/22/8f/5e/5e8f2206b72ee5bca1171ba4/7090-p1_586.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0a/22/8f/5e/5e8f220ab72ee5bca1171bb7/7091-p1_548.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/0f/22/8f/5e/5e8f220fb72ee5bca1171bcc/7092-p1_568.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/13/22/8f/5e/5e8f2213b72ee5bca1171bdf/7086-p1_524.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/17/22/8f/5e/5e8f2217b72ee5bca1171bf5/7098-p1_56.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f2070280f8c9a7eaa6a68/7099-p1_42.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f2077280f8c9a7eaa6a8e/7113-p1_204.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/79/20/8f/5e/5e8f2079280f8c9a7eaa6a99/7114-p1_176.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/20/8f/5e/5e8f207b280f8c9a7eaa6aa4/7115-p1_171.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7d/20/8f/5e/5e8f207d280f8c9a7eaa6aaf/7116-p1_166.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7f/20/8f/5e/5e8f207f280f8c9a7eaa6aba/4259-p1_56.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/81/20/8f/5e/5e8f2081280f8c9a7eaa6ac5/4259-p1_61.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/82/20/8f/5e/5e8f2082280f8c9a7eaa6ad0/7150-p1_499.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/88/20/8f/5e/5e8f2088280f8c9a7eaa6ae9/7126-p1_66.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/64/20/8f/5e/5e8f2064a063beb994aa7013/7142-p1_398.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/20/8f/5e/5e8f2066a063beb994aa701e/7143-p1_403.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f2068a063beb994aa7029/7144-p1_408.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6a/20/8f/5e/5e8f206aa063beb994aa7034/7145-p1_452.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6d/20/8f/5e/5e8f206da063beb994aa703f/7146-p1_526.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6f/20/8f/5e/5e8f206fa063beb994aa704a/7147-p1_536.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/71/20/8f/5e/5e8f2071a063beb994aa7055/7148-p1_393.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/73/20/8f/5e/5e8f2073a063beb994aa7060/7150-p1_481.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f2077a063beb994aa7073/7150-p1_490.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7b/20/8f/5e/5e8f207ba063beb994aa7089/7155-p1_125.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7d/20/8f/5e/5e8f207da063beb994aa7094/7156-p1_531.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7f/20/8f/5e/5e8f207fa063beb994aa709f/4472-p1_189.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/c8/1d/8f/5e/5e8f1dc8ba6cd3e594aa7042/108-p1_126.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/83/20/8f/5e/5e8f2083a063beb994aa70b9/7177-p1_17.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/66/20/8f/5e/5e8f206678cc4c8b37aa6b79/4254-p1_144.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/68/20/8f/5e/5e8f206878cc4c8b37aa6b84/4254-p1_139.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6b/20/8f/5e/5e8f206b78cc4c8b37aa6b98/7199-p1_35.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6c/20/8f/5e/5e8f206c78cc4c8b37aa6ba1/7202-p1_38.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/6e/20/8f/5e/5e8f206e78cc4c8b37aa6baa/7216-p1.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/70/20/8f/5e/5e8f207078cc4c8b37aa6bb5/7217-p1_562.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/72/20/8f/5e/5e8f207278cc4c8b37aa6bc0/7218-p1_552.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/75/20/8f/5e/5e8f207578cc4c8b37aa6bce/7220-p1_557.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/77/20/8f/5e/5e8f207778cc4c8b37aa6bd9/a66x134b22-p1_23.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7a/20/8f/5e/5e8f207a78cc4c8b37aa6be9/7236-p1_130.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/7e/20/8f/5e/5e8f207e78cc4c8b37aa6bfc/7236-p1_139.jpg',
            //                'https://files.plytix.com/api/v1.1/file/public_files/pim/assets/df/a1/f4/59/59f4a1dff03580228491e87b/images/81/20/8f/5e/5e8f208178cc4c8b37aa6c0f/7236-p1_148.jpg'
            //            );
            ////            return count($x);
            //            $new = [];
            //
            //            foreach ($x as $key=>$value){
            //                $ex = $this->filterData($rows[0],$value);
            //                $new[] = $ex;
            //            }

            //            foreach ($new as $key =>$chunk){
            //
            //            }
            //            foreach (array_chunk($new, 1) as $key =>$chunks){
            //                    dispatch(new \App\Jobs\UploadImportProductsJob($chunks));
            //                    echo ($key+1)." Job added in Queue successfully!</br>";
            //            }die;

            //            var_dump($new);
            //            die;
            //            die;
            //            if(count($rows) >= 1){
            //                foreach (array_chunk($rows[0], 50) as $key =>$chunks){
            //                    if($key != 0){
            //                        dispatch(new \App\Jobs\UploadImportProductsJob($chunks));
            //                        echo ($key+1)." Job added in Queue successfully!</br>";
            //                    }
            //                }
            //            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

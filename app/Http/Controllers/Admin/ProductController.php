<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use DB;
use Illuminate\Http\Request;
use Storage;
use Str;
use Validator;

class ProductController extends Controller
{
    //
    public function Index()
    {

        $categories = Category::get();
        $brands = Brand::get();
        $sizes = Size::get();
        $products = Product::with('sizes')->get();
        return view('Admin.Layout.Product.Index', compact('categories', 'brands', 'products', 'sizes'));
    }

    public function Create()
    {
        $categories = Category::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $sizes = Size::get();
        return view('Admin.Layout.Product.Create', compact('categories', 'brands', 'sizes'));
    }

    public function Store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
                'image' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',


            ],
            [
                'name.required' => 'Vui lòng nhập tên sản phẩm',
                'image.required' => 'Vui lòng chọn ảnh sản phẩm',
                'price.required' => 'Vui lòng nhập giá sản phẩm',
                'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
                'category_id.required' => 'Vui lòng chọn danh mục sản phẩm',
                'brand_id.required' => 'Vui lòng chọn thương hiệu sản phẩm',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        if (!empty($data)) {
            $data['sku'] = Str::upper(Str::slug($data['name']));
            $data['slug'] = Str::slug($data['name']);
            if ($request->hasFile('image')) {

                $image_path = $request->file('image')->store('images', 'public');
                $data['image'] = $image_path;
            }
            $product = Product::create($data);
            $sizes = $data['size'];
            if ($product) {
                foreach ($sizes as $key => $value) {
                    DB::table('productsize')->insert([
                        'size_id' => $value,
                        'product_id' => $product->id,
                    ]);
                }
            }

            
        }
        return response()->json(['message' => 'Thêm thành công','status'=> 201]);


    }

    public function Edit($id)
    {
        $sizes = Size::get();
        $categories = Category::get();
        $brands = Brand::get();
        $product = Product::with('sizes')->find($id);
        return view('Admin.Layout.Product.Edit', compact('sizes', 'categories', 'brands', 'product'));
    }

    public function Update(Request $request)
    {
        $data = $request->all();
        $data = $request->except($data['sizes']);
        $validator = Validator::make(
            $data,
            [
                'name' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',


            ],
            [
                'name.required' => 'Vui lòng nhập tên sản phẩm',
                'price.required' => 'Vui lòng nhập giá sản phẩm',
                'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
                'category_id.required' => 'Vui lòng chọn danh mục sản phẩm',
                'brand_id.required' => 'Vui lòng chọn thương hiệu sản phẩm',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($data['id']);

        if ($request->hasFile('image')) {
            if ($product["image"] && Storage::disk('public')->exists($product["image"])) {
                Storage::disk('public')->delete($product["image"]);
            }
            $image_path = $request->file('image')->store('images', 'public');
            $data['image'] = $image_path;
        } else {
            $data['image'] = $product['image'];
        }
        $data['slug'] = Str::slug($data['name']);
        $data['sku'] = Str::upper(Str::slug($data['name']));

        $product->update($data);

        if ($request->has('sizes')) {
            // sync cho xóa cũ, thêm mới và chỉ dùng cho mqh n-n 
            $product->sizes()->sync($data['sizes']);
        }



        return response()->json(['status' => 200, 'message' => "Cập nhật thành công"]);
        // return response()->json($data);

    }

    public function Delete(Request $request)
    {
        $product = Product::find($request->id);
        if ($product["image"] && Storage::disk('public')->exists($product["image"])) {
            Storage::disk('public')->delete($product['image']);
        }
        $result = $product->delete();
        if ($result)
            return response()->json(['status' => 200, 'message' => "Xóa thành công"]);

    }


    public function CreateSize(Request $request)
    {
        $data = $request->all();
        if (!empty($data))
            $result = Size::create($data);
        if ($result)
            return response()->json(['status' => 201, 'message' => 'Thêm thành công']);

    }


}

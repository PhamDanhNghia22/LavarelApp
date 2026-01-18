<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Validator;

class CategoryController extends Controller
{
    //

    public function Index()
    {
        $Categories = Category::get();

        return view('Admin.Layout.Category.Index', compact('Categories'));
    }

    public function Create()
    {

        return view('Admin.Layout.Category.Create');
    }

    public function Store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
        ]);
        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $category = $request->all();
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            $category['image'] = $image_path;
        }

        $category['slug'] = Str::slug($category['name']);
        $data = Category::create($category);
        if ($data)
            return response()->json(['message' => 'Thêm thành công', 'status' => 201]);



    }

    public function Edit($id)
    {
        $category = Category::find($id);
        return response()->json(['category' => $category]);
    }

    public function Update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
        ]);
        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $category = Category::find($data['id']);


        if ($request->hasFile('NewImage')) {
            if ($data["OldImage"] && Storage::disk('public')->exists($data["OldImage"])) {
                Storage::disk('public')->delete($data['OldImage']);
            }
            $image_path = $request->file('NewImage')->store('images', 'public');
            $category['image'] = $image_path;
        }
        $result = $category->update($data);
        return response()->json(["status" => 200, "message" => "Cập nhật thành công"]);


    }
    public function Delete(Request $request)
    {
        $category = Category::find($request->id);

        if ($category["image"] && Storage::disk('public')->exists($category["image"])) {
            Storage::disk('public')->delete($category['image']);
        }


        $result = $category->delete();
        if ($result)
            return response()->json(["status" => 200, "message" => "Xóa thành công"]);

    }
}

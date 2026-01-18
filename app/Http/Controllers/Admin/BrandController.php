<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Str;

class BrandController extends Controller
{
    //
    public function Index()
    {
        $brands = Brand::get();

        return view('Admin.Layout.Brand.Index', compact('brands'));
    }

    public function Create()
    {

        return view('Admin.Layout.Brand.Create');
    }

    public function Store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên thương hiệu',
        ]);
        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $brand = $request->all();
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            $brand['image'] = $image_path;
        }

        $brand['slug'] = Str::slug($brand['name']);
        $data = Brand::create($brand);
        if ($data)
            return response()->json(['message' => 'Thêm thành công', 'status' => 201]);



    }

    public function Edit($id)
    {
        $brand = Brand::find($id);
        return response()->json(['brand' => $brand]);
    }

    public function Update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên thương hiệu',
        ]);
        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $brand = Brand::find($data['id']);
        $brand['slug'] = Str::slug($data['name']);
        if ($request->hasFile('NewImage') ) {
            if ($data["OldImage"] && Storage::disk('public')->exists($data["OldImage"])) {
                Storage::disk('public')->delete($data['OldImage']);
            }
            $image_path = $request->file('NewImage')->store('images', 'public');
            $brand['image'] = $image_path;
        }
        
        $result = $brand->update($data);
        if ($result)
            return response()->json(["status" => 200, "message" => "Cập nhật thành công"]);



    }
    public function Delete(Request $request)
    {
        $brand = Brand::find($request->id);

        if ($brand["image"] && Storage::disk('public')->exists($brand["image"])) {
            Storage::disk('public')->delete($brand['image']);
        }


        $result = $brand->delete();
        if ($result)
            return response()->json(["status" => 200, "message" => "Xóa thành công"]);

    }
}

<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','sku','slug','image','price','quantity','discount','is_active','is_featured','description','category_id','brand_id'];

    public function sizes(){
        return $this->belongsToMany(Size::class,'productsize','product_id', 'size_id');
    }
    public function size(){
        return $this->hasMany(ProductSize::class,'product_id','id');
    }
}

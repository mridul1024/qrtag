<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function job(){
        return $this->belongsTo(Job::class); //$product->category /
        //select * from category where product_id = 1
    }
    public function subcategorytype(){
        return $this->belongsTo(Subcategorytype::class); //$product->category /
        //select * from category where product_id = 1
    }

    public function productsattributes(){
        return $this->hasMany(ProductAttribute::class); //select * from subcategories where category_id= 2
    }
}

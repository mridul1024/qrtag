<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategorytype extends Model
{
    protected $guarded = [];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class); //$product->category /
        //select * from category where product_id = 1
    }

    public function attributes(){
        return $this->hasMany(Attributes::class); //select * from subcategories where category_id= 2
    }

}

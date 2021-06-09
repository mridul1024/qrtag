<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    // protected $fillable = [
    //     'name', 'description', 'created_by'
    // ];

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class); //$product->category /
        //select * from category where product_id = 1
    }


}


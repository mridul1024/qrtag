<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    protected $guarded = [];

    public function subcategory(){
        return $this->$this->belongsTo(Subcategory::class); //$product->category /
        //select * from category where product_id = 1
    }
    
}

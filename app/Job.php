<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->hasMany(Product::class); //select * from subcategories where category_id= 2
    }
}

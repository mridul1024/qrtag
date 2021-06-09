<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'created_by'
    ];

    public function subcategories(){
        return $this->hasMany(Subcategory::class); //select * from subcategories where category_id= 2
    }
}

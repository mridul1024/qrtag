<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeMaster extends Model
{
    protected $fillable = [
        'name', 'created_by'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $table = TBL_PACKAGE_CATEGORIES;

    protected $fillable = ['title'];

 //   public $timestamps = true;
}

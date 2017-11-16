<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = TBL_PACKAGES;

    protected $fillable = ['title','packages_id','image'];

 //   public $timestamps = true;
}

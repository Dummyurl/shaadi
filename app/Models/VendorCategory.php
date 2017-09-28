<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = ['title'];
    public $timestamps = true;
    protected $table = TBL_VENDOR_CATEGORY;
}

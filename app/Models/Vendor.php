<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Vendor extends Model
{
	protected $table = TBL_VENDOR;
     
    protected $fillable = ['user_id','vendor_category_id'];

    public function VendorCategory()
    {
        return $this->belongsTo(\App\Models\VendorCategory::class)->withTrashed();
    }

}

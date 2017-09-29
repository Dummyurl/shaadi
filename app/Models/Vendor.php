<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Vendor extends Model
{
	use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => array('firstname','lastname'),
                'on_update' => true
            ]
        ];
    }   

    protected $table = TBL_VENDOR;
    protected $fillable = ['user_type_id','vendor_category_id','name','firstname','lastname','email','password','city_id','address','phone','status'];

}

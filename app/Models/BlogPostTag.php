<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPostTag extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = TBL_BLOG_POST_TAGS;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [];


    public function post()
    {
        return $this->belongsTo(\App\BlogPost::class);
    }

}

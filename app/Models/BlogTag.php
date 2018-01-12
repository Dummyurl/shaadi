<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;

class BlogTag extends Model
{
    use SoftDeletes,Sluggable;

    /**
     * The database table used by the model
     *
     * @var string
     */
    protected $table = TBL_BLOG_TAGES;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['title','status'];

    /**
     * Set or unset the timestamps for the model
     *
     * @var bool
     */
    public $timestamps = true;
    
   /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => 
            [
                'source' => 'title',
                'on_update' => true
            ]
        ];
    }            

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    | For more information pleas check out the official Laravel docs at
    | http://laravel.com/docs/5.4/eloquent#relationships
    |
    */

    public function post()
    {
        return $this->belongsToMany(\App\BlogPost::class, 'blog_post_tags', 'tag_id', 'post_id');
    }    

}

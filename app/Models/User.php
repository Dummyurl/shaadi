<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
   // public $timestamps = true;
    use Notifiable, Sluggable;
    protected $table = TBL_USERS;
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_type_id','name','firstname','address','lastname','email','city_id','phone','last_login_at','password','status','slug'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
   /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => array('firstname','lastname'),
                'on_update' => true
            ]
        ];
    }        
    
    
    public function getFullNameAttribute() { 
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }    

    public function getImageUrl()
    {
        $image = $this->image;
        $imageUrl = asset("images/default-user.jpg");
        
        if(!empty($image) && !is_null($image))
        {
            $imageUrl = asset("uploads/users/".$this->id."/".$image);
        }
        
        return $imageUrl;
    }
        
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $description
 * @property string $remark     
 */
class AdminAction extends Model
{
    public $timestamps = false;
    protected $table = TBL_ADMIN_ACTION;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['description', 'remark','id'];
    
    /**
     *
     * Activity Constants
     *
     */
//Dashboard
    public $ADMIN_LOGIN = 1;
    public $ADMIN_LOGOUT = 2;    
    public $UPDATE_PROFILE = 3;
    public $UPDATE_CHANGE_PASSWORD = 4;

//Admin Action
    public $ADD_ADMIN_ACTION = 5;
    public $EDIT_ADMIN_ACTION = 6;
    public $DELETE_ADMIN_ACTION = 7;

//User Action
    public $ADD_USER_ACTION = 8;    
    public $EDIT_USER_ACTION = 9;    
    public $DELETE_USER_ACTION = 10;

//Users Permissions
    public $ADD_ADMIN_MODULES_PAGES = 11;
    public $EDIT_ADMIN_MODULES_PAGES = 12;
    public $DETELE_ADMIN_MODULES_PAGES = 13;

//Update Rights
    public $UPDATE_RIGHTS = 14;   

//Admin
    public $ADD_ADMIN_MODULES = 15;  
    public $EDIT_ADMIN_MODULES = 16;
    public $DELETE_ADMIN_MODULES = 17;

//Countries
    public $ADD_COUNTRIES = 18;
    public $EDIT_COUNTRIES = 19;
    public $DELETE_COUNTRIES = 20;

//State
    public $ADD_STATE = 21;
    public $EDIT_STATE = 22;
    public $DELETE_STATE = 23;

//City
    public $ADD_CITY = 24;
    public $EDIT_CITY = 25;
    public $DELETE_CITY = 26;

//Admin Users
    public $ADD_ADMIN_USERS = 27;
    public $EDIT_ADMIN_USERS = 28;
    public $DELETE_ADMIN_USERS = 29;  

//Admin User Type
    public $ADD_ADMIN_USER_TYPE = 30;
    public $EDIT_ADMIN_USER_TYPE = 31;
    public $DELETE_ADMIN_USER_TYPE = 32;

//Users Type
    public $ADD_USER_TYPE = 33;   
    public $EDIT_USER_TYPE = 34;   
    public $DELETE_USER_TYPE = 35;

//User
    public $ADD_USER = 36;  
    public $EDIT_USER = 37;  
    public $DELETE_USER = 38;  

//Vendors Category
    public $ADD_VENDOR_CATEGORY = 39;   
    public $EDIT_VENDOR_CATEGORY = 40;   
    public $DELETE_VENDOR_CATEGORY = 41;

//Vendor
    public $ADD_VENDOR = 42;   
    public $EDIT_VENDOR = 43;   
    public $DELETE_VENDOR = 44;   
    public $CHANGE_VENDOR_STATUS = 45;

//Protfolio Categories
    public $ADD_PORTFOLIO_CATEGORIES = 46;   
    public $EDIT_PORTFOLIO_CATEGORIES = 47;   
    public $DELETE_PORTFOLIO_CATEGORIES = 48; 

//Protfolio
    public $ADD_PORTFOLIOS = 49;   
    public $EDIT_PORTFOLIOS = 50;   
    public $DELETE_PORTFOLIOS = 51;       
    
//Package Categories    
    public $ADD_PACKAGE_CATEGORIES = 52;   
    public $EDIT_PACKAGE_CATEGORIES = 53;   
    public $DELETE_PACKAGE_CATEGORIES = 54;   

//Package    
    public $ADD_PACKAGES = 55;   
    public $EDIT_PACKAGES = 56;    
    public $DELETE_PACKAGES = 57;

//Blog Category
    public $ADD_BLOG_CATEGORY = 58;
    public $EDIT_BLOG_CATEGORY = 59;
    public $DELETE_BLOG_CATEGORY = 60;
    
//Blog Tages
    public $ADD_BLOG_TAGES = 61;
    public $EDIT_BLOG_TAGES = 62;
    public $DELETE_BLOG_TAGES = 63;
    
//BLog Posts
    public $ADD_BLOG_POSTS = 64;
    public $EDIT_BLOG_POSTS = 65;
    public $DELETE_BLOG_POSTS = 66;

}

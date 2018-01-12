<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = "admins";
    protected $table = TBL_ADMIN_USERS;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone', 'created_at', 'updated_at'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ]; 

    // admin group pages varibales
    public static $error_msg = "You are not authorised to view this page.";

//Admin Users
    public static $LIST_ADMIN_LOG_ACTIONS = 1;
    public static $ADD_ADMIN_LOG_ACTIONS = 2;
    public static $EDIT_ADMIN_LOG_ACTIONS = 3;
    public static $DELETE_ADMIN_LOG_ACTIONS = 4;

//User Permissions    
    public static $LIST_ADMIN_MODULES = 5;
    public static $ADD_ADMIN_MODULES = 6;
    public static $EDIT_ADMIN_MODULES = 7;
    public static $DELETE_ADMIN_MODULES = 8;

    public static $LIST_ADMIN_MODULES_PAGES = 9;
    public static $ADD_ADMIN_MODULES_PAGES = 10;
    public static $EDIT_ADMIN_MODULES_PAGES = 11;
    public static $DETELE_ADMIN_MODULES_PAGES = 12;

//Fronted Users    
    
    public static $LIST_USER = 13;     
    public static $ADD_USER = 14;
    public static $EDIT_USER = 15; 
    public static $DELETE_USER = 16;

//Users Actions
    public static $LIST_USERS_ACTIONS = 17;
    public static $ADD_USERS_ACTIONS = 18;
    public static $EDIT_USERS_ACTIONS = 19;
    public static $DELETE_USERS_ACTIONS = 20;

//Rights
    public static $ADMIN_USERS = 21;
    public static $ASSIGN_RIGHTS = 22;

//Masters Countries
    public static $LIST_COUNTRIES = 23;
    public static $ADD_COUNTRIES = 24;
    public static $EDIT_COUNTRIES = 25;
    public static $DELETE_COUNTRIES = 26;

//Masters States
    public static $LIST_STATE = 27;
    public static $ADD_STATE = 28;
    public static $EDIT_STATE = 29;
    public static $DELETE_STATE = 30;

//Masters City
    public static $LIST_CITY = 31;
    public static $ADD_CITY = 32;
    public static $EDIT_CITY = 33;
    public static $DELETE_CITY = 34;

// Admin Users    
    public static $LIST_ADMIN_USERS = 35;
    public static $ADD_ADMIN_USERS = 36;
    public static $EDIT_ADMIN_USERS = 37;
    public static $DELETE_ADMIN_USERS = 38;

//Admin User Type
    public static $LIST_ADMIN_USER_TYPE = 39;
    public static $ADD_ADMIN_USER_TYPE = 40;
    public static $EDIT_ADMIN_USER_TYPE = 41;
    public static $DELETE_ADMIN_USER_TYPE = 42;

//User Type    
    public static $LIST_USER_TYPE = 43;
    public static $ADD_USER_TYPE = 44;
    public static $EDIT_USER_TYPE = 45;
    public static $DELETE_USER_TYPE = 46;

//Vendors
    public static $LIST_VENDOR = 47;
    public static $ADD_VENDOR = 48;
    public static $EDIT_VENDOR = 49;
    public static $DELETE_VENDOR = 50;
// public static $VIEW_VENDOR = 51;
//public static $CHANGE_VENDOR_STATUS = 52;
    
//Vendors Category
    public static $LIST_VENDOR_CATEGORY = 51;
    public static $ADD_VENDOR_CATEGORY = 52;
    public static $EDIT_VENDOR_CATEGORY = 53;
    public static $DELETE_VENDOR_CATEGORY = 54;        
    
//Portfolio
    public static $LIST_PORTFOLIO = 55;
    public static $ADD_PORTFOLIOS = 56;
    public static $EDIT_PORTFOLIOS = 57;
    public static $DELETE_PORTFOLIOS = 58;

//Protfolio Categories
    public static $LIST_PORTFOLIO_CATEGORIES = 59;
    public static $ADD_PORTFOLIO_CATEGORIES = 60;
    public static $EDIT_PORTFOLIO_CATEGORIES = 61;
    public static $DELETE_PORTFOLIO_CATEGORIES = 62;

//Package    
    public static $LIST_PACKAGES = 63;
    public static $ADD_PACKAGES = 64;
    public static $EDIT_PACKAGES = 65;
    public static $DELETE_PACKAGES = 66;

//Package Categories
    public static $LIST_PACKAGE_CATEGORIES = 67;
    public static $ADD_PACKAGE_CATEGORIES = 68;
    public static $EDIT_PACKAGE_CATEGORIES = 69;
    public static $DELETE_PACKAGE_CATEGORIES = 70;

//Blog Category
    public static $LIST_BLOG_CATEGORY = 71;
    public static $ADD_BLOG_CATEGORY = 72;
    public static $EDIT_BLOG_CATEGORY = 73;
    public static $DELETE_BLOG_CATEGORY = 74;

//Blog Tags
    public static $LIST_BLOG_TAGES = 75;
    public static $ADD_BLOG_TAGES = 76;
    public static $EDIT_BLOG_TAGES = 77;
    public static $DELETE_BLOG_TAGES = 78;

//Blog Posts
    public static $LIST_BLOG_POSTS = 79;
    public static $ADD_BLOG_POSTS = 80;
    public static $EDIT_BLOG_POSTS = 81;
    public static $DELETE_BLOG_POSTS = 82;

    /**
     * check page acces permissions
     *          
     * @var $page_id
     */
    public static function checkPermission($intCurAdminUserRight)
    {
        $userrights = session("admin_user_rights_ids");
        if(is_array($userrights) && !empty($userrights)){
            if (!in_array($intCurAdminUserRight, (array)$userrights)) {
                session()->flash('error_message',\App\Models\Admin::$error_msg);
                return redirect('admin/dashboard');
            }
        }
    }
    /**
     * check page acces permissions
     *
     * @var $page_id
     */        
    public static function isAccess($page_id)
    {
        $array = session("admin_user_rights_ids");
        $status = 0;
        
        if(is_array($array) && in_array($page_id, $array))
        {
            $status = 1;
        }
        return $status;
    }   
}

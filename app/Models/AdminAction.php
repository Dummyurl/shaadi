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
    public $ADMIN_LOGIN = 1;
    public $ADMIN_LOGOUT = 2;
    public $UPDATE_PROFILE = 3;
    public $UPDATE_CHANGE_PASSWORD = 4;
    
    public $ADD_ADMIN_ACTION = 5;
    public $EDIT_ADMIN_ACTION = 6;
    public $DELETE_ADMIN_ACTION = 7;

    public $ADD_USER_ACTION = 8;    
    public $EDIT_USER_ACTION = 9;    
    public $DELETE_USER_ACTION = 10; 
    
    public $ADD_ADMIN_MODULES_PAGES = 11;
    public $EDIT_ADMIN_MODULES_PAGES = 12;
    public $DETELE_ADMIN_MODULES_PAGES = 13;

    public $UPDATE_RIGHTS = 14;   

    public $ADD_ADMIN_MODULES = 15;  
    public $EDIT_ADMIN_MODULES = 16;
    public $DELETE_ADMIN_MODULES = 17;

    public $ADD_COUNTRIES = 18;
    public $EDIT_COUNTRIES = 19;
    public $DELETE_COUNTRIES = 20;

    public $ADD_STATE = 21;
    public $EDIT_STATE = 22;
    public $DELETE_STATE = 23;

    public $ADD_CITY = 24;
    public $EDIT_CITY = 25;
    public $DELETE_CITY = 26;
    
    public $ADD_ADMIN_USERS = 27;
    public $EDIT_ADMIN_USERS = 28;
    public $DELETE_ADMIN_USERS = 29;  

    public $ADD_USER_TYPE = 30;   
    public $EDIT_USER_TYPE = 31;   
    public $DELETE_USER_TYPE = 32;  

    public $ADD_VENDOR_CATEGORY = 33;   
    public $EDIT_VENDOR_CATEGORY = 34;   
    public $DELETE_VENDOR_CATEGORY = 35;

    public $ADD_VENDOR = 36;   
    public $EDIT_VENDOR = 37;   
    public $DELETE_VENDOR = 38;   
    public $CHANGE_VENDOR_STATUS = 39;   
    
    public $ADD_PORTFOLIOS = 40;   
    public $EDIT_PORTFOLIOS = 41;   
    public $DELETE_PORTFOLIOS = 42;   
    
    public $ADD_PORTFOLIO_CATEGORIES = 43;   
    public $EDIT_PORTFOLIO_CATEGORIES = 44;   
    public $DELETE_PORTFOLIO_CATEGORIES = 45;   
    
    public $ADD_PACKAGE_CATEGORIES = 46;   
    public $EDIT_PACKAGE_CATEGORIES = 47;   
    public $DELETE_PACKAGE_CATEGORIES = 48;   
}

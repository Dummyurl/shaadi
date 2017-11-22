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
    public static $LIST_ADMIN_LOG_ACTIONS = 1;
    public static $ADD_ADMIN_LOG_ACTIONS = 2;
    public static $EDIT_ADMIN_LOG_ACTIONS = 3;
    public static $DELETE_ADMIN_LOG_ACTIONS = 4;

    public static $LIST_ADMIN_MODULES = 5;
    public static $ADD_ADMIN_MODULES = 6;
    public static $EDIT_ADMIN_MODULES = 7;
    public static $DELETE_ADMIN_MODULES = 8;
    
    public static $LIST_ADMIN_MODULES_PAGES = 9;
    public static $ADD_ADMIN_MODULES_PAGES = 10;
    public static $EDIT_ADMIN_MODULES_PAGES = 11;
    public static $DETELE_ADMIN_MODULES_PAGES = 12;

    public static $LIST_USERS = 13;     
    public static $ADD_USERS = 14;
    public static $EDIT_USERS = 15; 
    public static $DELETE_USERS = 16;
    
    public static $LIST_USERS_ACTIONS = 17;
    public static $ADD_USERS_ACTIONS = 18;
    public static $EDIT_USERS_ACTIONS = 19;
    public static $DELETE_USERS_ACTIONS = 20;

    public static $ADMIN_USERS = 21;
    public static $ASSIGN_RIGHTS = 22;

    public static $LIST_COUNTRIES = 23;
    public static $ADD_COUNTRIES = 24;
    public static $EDIT_COUNTRIES = 25;
    public static $DELETE_COUNTRIES = 26;

    public static $LIST_STATE = 27;
    public static $ADD_STATE = 28;
    public static $EDIT_STATE = 29;
    public static $DELETE_STATE = 30;

    public static $LIST_CITY = 31;
    public static $ADD_CITY = 32;
    public static $EDIT_CITY = 33;
    public static $DELETE_CITY = 34;
    
    public static $LIST_ADMIN_USERS = 35;
    public static $ADD_ADMIN_USERS = 36;
    public static $EDIT_ADMIN_USERS = 37;
    public static $DELETE_ADMIN_USERS = 38;

    public static $LIST_USER_TYPE = 39;
    public static $ADD_USER_TYPE = 40;
    public static $EDIT_USER_TYPE = 41;
    public static $DELETE_USER_TYPE = 42;

    public static $LIST_VENDOR_CATEGORY = 43;
    public static $ADD_VENDOR_CATEGORY = 44;
    public static $EDIT_VENDOR_CATEGORY = 45;
    public static $DELETE_VENDOR_CATEGORY = 46;

    public static $LIST_VENDOR = 47;
    public static $ADD_VENDOR = 48;
    public static $EDIT_VENDOR = 49;
    public static $DELETE_VENDOR = 50;
    public static $VIEW_VENDOR = 51;
    public static $CHANGE_VENDOR_STATUS = 52;
    
    public static $LIST_PORTFOLIO = 53;
    public static $ADD_PORTFOLIOS = 54;
    public static $EDIT_PORTFOLIOS = 55;
    public static $DELETE_PORTFOLIOS = 56;

    public static $LIST_PORTFOLIO_CATEGORIES = 57;
    public static $ADD_PORTFOLIO_CATEGORIES = 58;
    public static $EDIT_PORTFOLIO_CATEGORIES = 59;
    public static $DELETE_PORTFOLIO_CATEGORIES = 60;
    
    public static $LIST_PACKAGE_CATEGORIES = 61;
    public static $ADD_PACKAGE_CATEGORIES = 62;
    public static $EDIT_PACKAGE_CATEGORIES = 63;
    public static $DELETE_PACKAGE_CATEGORIES = 64;
    
    public static $LIST_PACKAGES = 65;
    public static $ADD_PACKAGES = 66;
    public static $EDIT_PACKAGES = 67;
    public static $DELETE_PACKAGES = 68;



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

    public static function sendHtmlMail($array)
    {
        $from_address = "phpdots1@gmail.com";
        $from_address = env("MAIL_USERNAME");
        
        $from_address_name = "PHPDots";
        $reply_to = "phpdots1@gmail.com";

        $bccEmails = ["phpdots1@gmail.com"];
        

        if(isset($array['reply_to']))
        {
            $reply_to = $array['reply_to'];
        }

        $toEmails[] = $array['to'];   

        if(isset($array['ccEmails']))
        {
            foreach($array['ccEmails'] as $em)
            {
                $toEmails[] =  $em;
            }
        }

        $array['from_address'] = $from_address;
        $array['to_emails'] = $toEmails;
        $array['bccEmails'] = $bccEmails;

       \Mail::send('emails.index', $array, function($message) use ($array)
       {
           $message->from($array['from_address'], "Dental Insider");            
           $message->sender($array['from_address'], "Dental Insider");
           $message->to($array['to'], '')->subject($array['subject']);

            if(isset($array['ccEmails']))
            {
                foreach($array['ccEmails'] as $em)
                {
                    $message->cc($em, '');
                }
            }

            if(isset($array['bccEmails']))
            {
                foreach($array['bccEmails'] as $em)
                {
                    $message->bcc($em, 'SDU');
                }
            }

       });        

       $ccEmailsTemp = "";

        if(isset($array['ccEmails']))
        {
            $ccEmailsTemp = implode(",", $array['ccEmails']);
        }

        $dataToInsert = [
            'to_email' => $array['to'],
            'cc_emails' => $ccEmailsTemp,
            'bcc_emails' => implode(",", $bccEmails),
            'from_email' => $from_address,
            'email_subject' => $array['subject'],
            'email_body' => $array['body'],
            'status' => 'sent',            
            'created_at' => \DB::raw('NOW()'),
            'updated_at' => \DB::raw('NOW()')
        ];

        \DB::table(TBL_EMAIL_SENT)->insert($dataToInsert);       
    }  
}

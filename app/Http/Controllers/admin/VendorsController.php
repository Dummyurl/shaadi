<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Datatables;
use Validator; 
use App\Models\AdminAction;
use App\Models\VendorCategory;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\UserType;
use App\Models\Vendor;
use App\Models\User;

class VendorsController extends Controller
{

    public function __construct() {
    
        $this->moduleRouteText = "vendors";
        $this->moduleViewName = "admin.vendors";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Vendor";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new Vendor();  

        $this->addMsg = $module . " has been added successfully!";
        $this->updateMsg = $module . " has been updated successfully!";
        $this->deleteMsg = $module . " has been deleted successfully!";
        $this->deleteErrorMsg = $module . " can not deleted!";       

        view()->share("list_url", $this->list_url);
        view()->share("moduleRouteText", $this->moduleRouteText);
        view()->share("moduleViewName", $this->moduleViewName);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        
        $data = array();        
        $data['page_title'] = "Manage Vendors";

        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_VENDOR); 
        $data['cityList'] = City::pluck("title","id")->all();
        $data['categoryList'] = VendorCategory::pluck("title","id")->all(); 
               

       return view($this->moduleViewName.".index", $data);
    }

    public function getstates(Request $request){
                
        $data = array();   

        $getstates = State::where('country_id', $request->country_id)->pluck("title","id");
        $options = "";
        
        if(!empty($getstates) && count($getstates) != 0){
            $options .= "<option value=''>select states</option>";
            foreach ($getstates as $key => $state) {
                    $options .= "<option value='$key'>$state</option>";
            }
        }else{
            $options .= "<option value=''>No States</option>";
        }
        echo $options;exit;       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        
        $data = array();
        $data['formObj'] = $this->modelObj;
        $data['page_title'] = "Add ".$this->module;
        $data['action_url'] = $this->moduleRouteText.".store";
        $data['action_params'] = 0;
        $data['buttonText'] = "Save";
        $data["method"] = "POST"; 
        $data['pass_view'] = 1;     

        $data['cityList'] = City::pluck("title","id")->all(); 
        $data['stateList'] = State::pluck("title","id")->all(); 
        $data['countryList'] = Country::pluck("title","id")->all(); 
        $data['categoryList'] = VendorCategory::pluck("title","id")->all(); 
        $data['usertypeList'] = UserType::pluck("title","id")->all(); 

        return view($this->moduleViewName.'.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $status = 1;
        $msg = $this->addMsg;
        $data = array();
        
        $validator = Validator::make($request->all(), [
            //'user_type_id' => 'required|exists:'.TBL_USER_TYPES.',id',  
            'vendor_category_id' => 'required|exists:'.TBL_VENDOR_CATEGORY.',id',
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:'.TBL_USERS.',email',
            'password' => 'required|min:4|same:password',
            'password_confirmation' => 'required|same:password',
            'city_id' => 'required|exists:'.TBL_CITY.',id',
            'state_id' => 'required|exists:'.TBL_STATE.',id',
            'country_id' => 'required|exists:'.TBL_COUNTRY.',id',
            'address' => 'required|min:2',
            'mobile' => 'required|numeric',
            'status' => ['required', Rule::in([1,0])],
        ]);
        if ($validator->fails())         
        {
            $messages = $validator->messages();
            
            $status = 0;
            $msg = "";
            
            foreach ($messages->all() as $message) 
            {
                $msg .= $message . "<br />";
            }
        }         
        else
        {
            $vendor_category_id = $request->get('vendor_category_id');
            $name = $request->get('name');
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $email = $request->get('email');
            $password = $request->get('password');
            $city_id = $request->get('city_id');
            $address = $request->get('address');
            $mobile = $request->get('mobile');
            $status = $request->get('status');

            if(empty($name)){
            $name =  $firstname.' '.$lastname;
            }
            $password =md5($password);

            $user_obj = new User();
                $user_obj->user_type_id = VENDOR;
                $user_obj->name= $name;
                $user_obj->firstname= $firstname;
                $user_obj->lastname= $lastname;
                $user_obj->email= $email;
                $user_obj->password= $password;
                $user_obj->city_id= $city_id;
                $user_obj->address= $address;
                $user_obj->mobile= $mobile;
                $user_obj->status= $status;
                $user_obj->save();
                $user_id = $user_obj->id;

            $vendor_obj = new Vendor();

            $vendor_obj->user_id= $user_id;
            $vendor_obj->vendor_category_id = $vendor_category_id;
            $vendor_obj->save();
            
            $id = $vendor_obj->id;           
            
            //store logs detail
            $params=array();
            $params['adminuserid']  = \Auth::guard('admins')->id();
            $params['actionid']     = $this->adminAction->ADD_VENDOR ;
            $params['actionvalue']  = $id;
            $params['remark']       = "Add Vendor::".$id;
                                    
            $logs= \App\Models\AdminLog::writeadminlog($params);
            
            session()->flash('success_message', $msg);                    
        }
        
        return ['status' => $status, 'msg' => $msg, 'data' => $data];              
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $formObj = Vendor::where(TBL_VENDOR.".user_id",$id)
                ->join(TBL_USERS,TBL_USERS.".id","=",TBL_VENDOR.".user_id")
                ->first();

        if(!$formObj)
        {
            abort(404);
        }

        $data = array();
        $data['formObj'] = $formObj;
        $data['page_title'] = "Edit ".$this->module;
        $data['buttonText'] = "Update";

        $data['action_url'] = $this->moduleRouteText.".update";
        $data['action_params'] = $formObj->id;
        $data['method'] = "PUT";
        $data['pass_view'] = 0;     

        $data['cityList'] = City::pluck("title","id")->all(); 
        $data['stateList'] = State::pluck("title","id")->all(); 
        $data['countryList'] = Country::pluck("title","id")->all(); 
        $data['categoryList'] = VendorCategory::pluck("title","id")->all(); 
        $data['usertypeList'] = UserType::pluck("title","id")->all(); 

        $cityobj = \App\Models\City::find($formObj->city_id);
        $state_id =$cityobj->state_id;

        $stateobj = \App\Models\State::find($state_id);
        if($stateobj){

            $data['def_state_id'] = $stateobj->id;
            $data['def_c_id'] = $stateobj->country_id;

        }

        
        return view($this->moduleViewName.'.add', $data);
    }    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $user_obj = User::find($id);

        $status = 1;
        $msg = $this->updateMsg;
        $data = array();        
        
        $validator = Validator::make($request->all(), [            
            //'user_type_id' => 'required|exists:'.TBL_USER_TYPES.',id',  
            'vendor_category_id' => 'required|exists:'.TBL_VENDOR_CATEGORY.',id',  
            //'name' => 'required|min:2',
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:'.TBL_USERS.',email,'.$id,
            'city_id' => 'required|exists:'.TBL_CITY.',id',
            'state_id' => 'required|exists:'.TBL_STATE.',id',
            'country_id' => 'required|exists:'.TBL_COUNTRY.',id',
            'address' => 'required|min:2',
            'mobile' => 'required|numeric',
            'status' => ['required', Rule::in([1,0])],
        ]);
        
        // check validations
        if(!$user_obj)
        {
            $status = 0;
            $msg = "Record not found !";
        }
        else if ($validator->fails()) 
        {
            $messages = $validator->messages();
            
            $status = 0;
            $msg = "";
            
            foreach ($messages->all() as $message) 
            {
                $msg .= $message . "<br />";
            }
        }         
        else
        {
            $vendor_category_id = $request->get('vendor_category_id');
            $name = $request->get('name');
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $email = $request->get('email');
            $password = $request->get('password');
            $city_id = $request->get('city_id');
            $address = $request->get('address');
            $mobile = $request->get('mobile');
            $status = $request->get('status');
            
            if(empty($name)){
            $name =  $firstname.' '.$lastname;
            }
                $user_obj->user_type_id = VENDOR;
                $user_obj->name= $name;
                $user_obj->firstname= $firstname;
                $user_obj->lastname= $lastname;
                $user_obj->email= $email;
                $user_obj->city_id= $city_id;
                $user_obj->address= $address;
                $user_obj->mobile= $mobile;
                $user_obj->status= $status;
                $user_obj->save();

            $vendor_obj = Vendor::where('user_id',$id)->first();

            $vendor_obj->vendor_category_id = $vendor_category_id;
            $vendor_obj->save();
            
            $id = $vendor_obj->id;
            //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->EDIT_VENDOR;
                $params['actionvalue']  = $id;
                $params['remark']       = "Edit vendor::".$id;

                $logs=\App\Models\AdminLog::writeadminlog($params);         
        }
        
        return ['status' => $status,'msg' => $msg, 'data' => $data];               
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $modelObj = User::find($id); 

        if($modelObj) 
        {
            try 
            {             
                $backUrl = $request->server('HTTP_REFERER');
                $vendor = Vendor::where('user_id',$id)->first();
                $vendor->delete();
                $modelObj->delete();
                session()->flash('success_message', $this->deleteMsg); 

                //store logs detail
                    $params=array();
                    
                    $params['adminuserid']  = \Auth::guard('admins')->id();
                    $params['actionid']     = $this->adminAction->DELETE_VENDOR;
                    $params['actionvalue']  = $id;
                    $params['remark']       = "Delete vendor::".$id;

                    $logs=\App\Models\AdminLog::writeadminlog($params);    

                return redirect($backUrl);
            } 
            catch (Exception $e) 
            {
                session()->flash('error_message', $this->deleteErrorMsg);
                return redirect($this->list_url);
            }
        } 
        else 
        {
            session()->flash('error_message', "Record not exists");
            return redirect($this->list_url);
        }
    }

    public function data(Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $model = User::select(TBL_USERS.".*",TBL_VENDOR_CATEGORY.".title as category_name",TBL_CITY.".title as city_name")
                ->join(TBL_CITY,TBL_CITY.".id","=",TBL_USERS.".city_id")
                ->join(TBL_VENDOR,TBL_USERS.".id","=",TBL_VENDOR.".user_id")
                ->join(TBL_VENDOR_CATEGORY,TBL_VENDOR_CATEGORY.".id","=",TBL_VENDOR.".vendor_category_id")
                ->where(TBL_USERS.'.user_type_id','=',VENDOR);

        return Datatables::eloquent($model)
            
            ->editColumn('status', function ($row) {
                if ($row->status == 1)
                    return "<a class='btn btn-xs btn-success'>Acive</a>";
                else
                    return '<a class="btn btn-xs btn-danger">Inactive</a>';
                }) 
            ->addColumn('action', function(User $row) {
                return view("admin.vendors.actions",
                    [
                        'currentRoute' => $this->moduleRouteText,
                        'row' => $row,                                 
                        'isView' =>\App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_VENDOR),
                        'isStatus' =>\App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_VENDOR),
                        'isEdit' =>\App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_VENDOR),
                        'isDelete' => \App\Models\Admin::isAccess(\App\Models\Admin::$DELETE_VENDOR),                                                         
                    ]
                )->render();
            })
            ->editColumn('created_at', function($row){
                
                if(!empty($row->created_at))          
                    return date("j M, Y h:i:s A",strtotime($row->created_at));
                else
                    return '-';    
            })
            ->rawColumns(['status','action'])           
            ->filter(function ($query) 
            {                                                    
                $search_start_date = request()->get("search_start_date"); 
                $search_end_date = request()->get("search_end_date"); 
                $search_category = request()->get("search_category"); 
                $search_name = request()->get("search_name"); 
                $search_email = request()->get("search_email"); 
                $search_city = request()->get("search_city"); 
                $search_status = request()->get("search_status"); 
                                      
                if (!empty($search_start_date)){

                    $from_date=$search_start_date.' 00:00:00';
                    $convertFromDate= $from_date;

                    $query = $query->where(TBL_VENDOR.".created_at",">=",addslashes($convertFromDate));
                }
                if (!empty($search_end_date)){

                    $to_date=$search_end_date.' 23:59:59';
                    $convertToDate= $to_date;

                    $query = $query->where(TBL_VENDOR.".created_at","<=",addslashes($convertToDate));
                }
                if(!empty($search_category))
                {
                    $query = $query->where(TBL_VENDOR.".vendor_category_id",$search_category);
                }  
                if(!empty($search_name))
                {
                    $query = $query->where(TBL_USERS.".name", 'LIKE', '%'.$search_name.'%');
                }
                if(!empty($search_email))
                {
                    $query = $query->where(TBL_USERS.".email", 'LIKE', '%'.$search_email.'%');
                }
                if(!empty($search_city))
                {
                    $query = $query->where(TBL_USERS.".city_id", $search_city);
                }
                if($search_status == "1" || $search_status == "0")
                    {
                        $query = $query->where(TBL_USERS.".status", $search_status);
                    }

            })
            ->make(true);        
    }

    public function viewData(Request $request)
    {     
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $id = $request->get('vendor_id');

        if(!empty($id)){
            
            $vendor = User::where(TBL_USERS.".id",$id)
                ->join(TBL_VENDOR,TBL_USERS.".id","=",TBL_VENDOR.".user_id")
                ->join(TBL_VENDOR_CATEGORY,TBL_VENDOR_CATEGORY.".id","=",TBL_VENDOR.".vendor_category_id")
                ->first();

        }
        return view("admin.vendors.viewData", ['views'=>$vendor]);
    }

    public function changeStatus($id, $status, Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_VENDOR);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $vendor = \App\Models\User::find($id);
        if($vendor){

            if($status==1) {
                $vendStatus=0;
            } else if($status==0) {
                $vendStatus=1;
            }
            
            $vendor->status = $vendStatus;
            $vendor->save();

            //Start :: Store logs details
            $params=array();

            $params['adminuserid']  = \Auth::guard('admins')->id();
            $params['actionid']     = $this->adminAction->CHANGE_VENDOR_STATUS;
            $params['actionvalue']  = $id;
            if($vendStatus ==1){
                $params['remark']       = "Changed Vendor Status Inactive to Active";
            }else{
                $params['remark']       = "Changed Vendor Status Active to Inactive";                
            }
            $logs=\App\Models\AdminLog::writeadminlog($params);

            session()->flash('success_message', "Status has been changed successfully.");
            return redirect($this->list_url);
        }else{
            session()->flash('success_message', "Status not changed, Please try again");
            return redirect($this->list_url);
        }
    }
}

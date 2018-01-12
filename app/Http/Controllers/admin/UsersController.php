<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Datatables;
use App\Models\User;
use App\Models\UserType;
use App\Models\AdminAction;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
class UsersController extends Controller
{
    public function __construct() {

        $this->moduleRouteText = "users";
        $this->moduleViewName = "admin.users";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "List Users";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new User();  

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $data = array();        
        $data['page_title'] = "Manage Users"; 
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_USER);
        $data['add_url'] = route($this->moduleRouteText.'.create');
        
        return view($this->moduleViewName.".index", $data); 
    }

    /**
     * Show the form for creating a new resource.   
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_USER);
        
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
        $data['cityList'] = City::pluck("title","id")->all(); 
        $data['stateList'] = State::pluck("title","id")->all(); 
        $data['countryList'] = Country::pluck("title","id")->all(); 
        $data['userTypeList'] = UserType::pluck("title","id")->all(); 
        $data['pass_view'] = 1; 

        return view($this->moduleViewName.'.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\m_responsekeys(conn, identifier)
     */
    public function store(Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $status = 1;
        $msg = "User has been created successfully.";
        $data = array();
        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:password',            
            'confirm_password' => 'required|min:8|same:password',
            'city_id' => 'required',
            'address' => 'required|min:2',
            'phone' => 'required|max:15',           
        ]);
        
        // check validations
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
            $password = $request->get("password");
            $confirm_password = $request->get("confirm_password");
            $email = $request->get("email");
            
            if($confirm_password == $password)
            {
                $user = new \App\Models\User;
                $user->firstname = $request->get("firstname");
                $user->lastname = $request->get("lastname");
                $user->phone = $request->get("phone");
                $user->email = $email;
                $user->address = $request->get("address");
                $user->city_id = $request->get("city_id");
                $user->password = bcrypt($password);

                $user->save();
                $id = $user->id;

                 //store logs detail
                $params = array();

                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->ADD_USER;
                $params['actionvalue']  = $id;
                $params['remark']       = "Add User::".$id;

                $logs = \App\Models\AdminLog::writeadminlog($params); 
                
                session()->flash('success_message', $this->addMsg);
            }
            else
            {
                $status = 0;
                $msg = "Password and confirm password not matched.";
            }
        }
        
        return ['status' => $status, 'msg' => $msg, 'data' => $data];       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idate(format)
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
    public function edit($user)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $formObj = $user;

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
        $data['cityList'] = City::pluck("title","id")->all(); 
        $data['stateList'] = State::pluck("title","id")->all(); 
        $data['countryList'] = Country::pluck("title","id")->all(); 
        $data['userTypeList'] = UserType::pluck("title","id")->all(); 
        $data['pass_view'] = 0; 

        return view($this->moduleViewName.'.add', $data);   
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $id = $user->id;
        $status = 1;
        $msg = "User has been updated successfully.";
        $data = array();
        
        // $user = \App\Models\User::find($id);
        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' .$id,
            'phone' => 'required|max:15',
        ]);
        
        // check validations
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
        else if($user)
        {            
            $user->firstname = $request->get("firstname");
            $user->lastname = $request->get("lastname");
            $user->phone = $request->get("phone");
            $user->email = $request->get("email");            

            $user->save(); 
            $id = $user->id;

            //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->EDIT_USER;
                $params['actionvalue']  = $id;
                $params['remark']       = "Edit User::".$id;

                $logs=\App\Models\AdminLog::writeadminlog($params);      
            
            session()->flash('success_message', $this->updateMsg);
                                       
        }
        else
        {
            $status = 0;
            $msg = "User not found !";
        }
        return ['status' => $status, 'msg' => $msg, 'data' => $data];   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user,Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $id = $user->id;
        $modelObj = $this->modelObj->find($id);

        if($modelObj) 
        {
            try 
            {             
                $backUrl = $request->server('HTTP_REFERER');
                $modelObj->delete();
                session()->flash('success_message', $this->deleteMsg); 

                //store logs detail
                    $params=array();
                    
                    $params['adminuserid']  = \Auth::guard('admins')->id();
                    $params['actionid']     = $this->adminAction->DELETE_USER;
                    $params['actionvalue']  = $id;
                    $params['remark']       = "Delete User::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_USER);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $model = User::query();

        return Datatables::eloquent($model)
               
            ->addColumn('action', function(User $row) {
                return view("admin.partials.action",
                    [
                        'currentRoute' => $this->moduleRouteText,
                        'row' => $row,                                 
                        'isEdit' => \App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_USER),
                        'isDelete' => \App\Models\Admin::isAccess(\App\Models\Admin::$DELETE_USER),
                                                     
                    ]
                )->render();
            })                
            ->filter(function ($query) 
            {
                $search_start_date = request()->get("search_start_date");                                         
                $search_end_date = request()->get("search_end_date");                                         
                $search_id = request()->get("search_id");                                         
                $search_fnm = request()->get("search_fnm");                                         
                $search_lnm = request()->get("search_lnm");                                         
                $search_email = request()->get("search_email");                                         
                                                       

                if (!empty($search_start_date)){

                    $from_date=$search_start_date.' 00:00:00';
                    $convertFromDate= $from_date;

                    $query = $query->where(TBL_USERS.".created_at",">=",addslashes($convertFromDate));
                }
                if (!empty($search_end_date)){

                    $to_date=$search_end_date.' 23:59:59';
                    $convertToDate= $to_date;

                    $query = $query->where(TBL_USERS.".created_at","<=",addslashes($convertToDate));
                }

                if(!empty($search_id))
                {
                    $idArr = explode(',', $search_id);
                    $idArr = array_filter($idArr);                
                    if(count($idArr)>0)
                    {
                        $query = $query->whereIn(TBL_USERS.".id",$idArr);
                    } 
                } 
                if(!empty($search_fnm))
                {
                    $query = $query->where(TBL_USERS.".firstname", 'LIKE', '%'.$search_fnm.'%');
                }
                if(!empty($search_lnm))
                {
                    $query = $query->where(TBL_USERS.".lastname", 'LIKE', '%'.$search_lnm.'%');
                }
                if(!empty($search_email))
                {
                    $query = $query->where(TBL_USERS.".email", 'LIKE', '%'.$search_email.'%');
                }
            })
            ->make(true);        
    }        
    
}

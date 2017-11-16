<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use Validator;
use Datatables;
use App\models\AdminLog;
use App\Models\AdminAction;

class PackageCategoryController extends Controller
{
    public function __construct() { 

        $this->moduleRouteText = "package-category";
        $this->moduleViewName = "admin.PackageCategory";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Package Category";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new PackageCategory();  

        $this->addMsg = $module . " has been added successfully!";
        $this->updateMsg = $module . " has been updated successfully!";
        $this->deleteMsg = $module . " has been deleted successfully!";
        $this->deleteErrorMsg = $module . " can not deleted!";       

        view()->share("list_url", $this->list_url);
        view()->share("moduleRouteText", $this->moduleRouteText);
        view()->share("moduleViewName", $this->moduleViewName); 

    }

    public function index()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        
        $data = array();        
        $data['page_title'] = "Manage Package Category";

        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_COUNTRIES);                  
        
       
        return view($this->moduleViewName.".index", $data); 
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_PACKAGE_CATEGORIES);
        
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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $status = 1;
        $msg = $this->addMsg;
        $data = array();

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:package_categories,title|min:2',
            
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
            $input = $request->all();
            $obj = $this->modelObj->create($input);
            $id = $obj->id;

            //store logs detail
            $params=array();    
                                    
            $params['adminuserid']  = \Auth::guard('admins')->id();
            $params['actionid']     = $this->adminAction->ADD_PACKAGE_CATEGORIES ;
            $params['actionvalue']  = $id;
            $params['remark']       = "Add Package Category::".$id;
                                    
            $logs=\App\Models\AdminLog::writeadminlog($params);

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
    public function edit($id)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $formObj = $this->modelObj->find($id);

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

        return view($this->moduleViewName.'.add', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $model = $this->modelObj->find($id);

        $status = 1;
        $msg = $this->updateMsg;
        $data = array();        
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|unique:package_categories,title,'.$id,
            
        ]);
        
        // check validations
        if(!$model)
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
            $input = $request->all();
            $model->update($input); 

           //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->EDIT_PACKAGE_CATEGORIES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Edit Package Category::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

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
                $params['actionid']     = $this->adminAction->DELETE_PACKAGE_CATEGORIES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Delete Package Category::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_PACKAGE_CATEGORIES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        return Datatables::of(PackageCategory::query())        
        
        ->addColumn('action', function(PackageCategory $row) {
                return view("admin.partials.action",
                    [
                        'currentRoute' => $this->moduleRouteText,
                        'row' => $row,                                 
                        'isEdit' =>1,
                        'isDelete' => 1,                                                         
                    ]
                )->render();
            })->rawColumns(['action'])
                    ->filter(function ($query) 
            {                                                    
                $search_start_date = request()->get("search_start_date"); 
                $search_end_date = request()->get("search_end_date"); 
                $search_title = request()->get("search_title"); 
                
                                      
                if (!empty($search_start_date)){

                    $from_date=$search_start_date.' 00:00:00';
                    $convertFromDate= $from_date;

                    $query = $query->where(TBL_PACKAGE_CATEGORIES.".created_at",">=",addslashes($convertFromDate));
                }
                if (!empty($search_end_date)){

                    $to_date=$search_end_date.' 23:59:59';
                    $convertToDate= $to_date;

                    $query = $query->where(TBL_PACKAGE_CATEGORIES.".created_at","<=",addslashes($convertToDate));
                }
                if(!empty($search_title))
                {
                    $query = $query->where(TBL_PACKAGE_CATEGORIES.".title",$search_title);
                }  
                

            })
        ->make(true);
    }


}

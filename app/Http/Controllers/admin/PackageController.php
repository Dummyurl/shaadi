<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageCategory;
use Validator;
use Datatables;
use App\models\AdminLog;
use App\Models\AdminAction;

class PackageController extends Controller
{
    public function __construct() { 

        $this->moduleRouteText = "package";
        $this->moduleViewName = "admin.Package";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Package";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new Package();  

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_PACKAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        
        $data = array();        
        $data['page_title'] = "Manage Package";

        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_COUNTRIES); 
        $data['Package'] = PackageCategory::pluck("title","id")->all();  
       
        return view($this->moduleViewName.".index", $data); 
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_PACKAGES);
        
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
        $data['Package'] = PackageCategory::pluck("title","id")->all();  
        return view($this->moduleViewName.'.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_PACKAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $status = 1;
        $msg = $this->addMsg;
        $data = array();

        $packages_id = request()->get('packages_id');
        $title = request()->get('title');
        $image = request()->file('image');
        

        $validator = Validator::make($request->all(), [
            'packages_id'=>'required|numeric', 
            'title'=>'required',  
            'image'=>'image'
            
        
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
            $destinationPath = public_path().'/themes/admin/assets/upload/package';
            $images=$image->getClientOriginalName();
            $extension =$image->getClientOriginalExtension();
            $images=md5($images);
            $image_name= $images.'.'.$extension;

            $file =$image->move($destinationPath,$image_name);

            $image_record= new Package(); 
                               
            $image_record->packages_id=$packages_id;
            $image_record->image=$image_name;                                  
            $image_record->title=$title;            
            $image_record->save();

            $id = $image_record->id;
        //store logs detail
            $params=array();    
                                    
            $params['adminuserid']  = \Auth::guard('admins')->id();
            $params['actionid']     = $this->adminAction->ADD_PACKAGES ;
            $params['actionvalue']  = $id;
            $params['remark']       = "Add Package::".$id;
                                    
            $logs=\App\Models\AdminLog::writeadminlog($params);

            session()->flash('success_message', $msg);           
            
        }
        
        return ['status' => $status, 'msg' => $msg, 'data' => $data];

    }*/
    public function store(Request $request)
    {
        //echo "<pre/>"; print_r($_POST);exit;
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_PACKAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        $status = 1;
        $msg = "Packag has been created successfully.";
        $data = array();
        
        $validator = Validator::make($request->all(), [
            'packages_id'=>'required|numeric', 
            'title'=>'required',  
            'image'=>'image'
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
            $packages_id = request()->get('packages_id');
            $title = request()->get('title');
            $image = request()->file('image');

            
                $package = new \App\Models\Package;
                $packages_id = $package->id;
                if(!empty($image)){
                
                //$destinationPath = public_path().'/images/users/';  
                $destinationPath = public_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'package'.DIRECTORY_SEPARATOR.$packages_id;

                   $image_name =$image->getClientOriginalName();              
                   $extension =$image->getClientOriginalExtension();
                   $image_name=md5($image_name);
                   $profile_image= $image_name.'.'.$extension;
                   $file =$image->move($destinationPath,$profile_image);

                $package->image = $profile_image;
                } 
                
                $package->packages_id=$packages_id;
                $package->image=$image_name;                                  
                $package->title=$title;            
                $package->save();
                
                $id = $package->id;
                
                //store logs detail
                $params = array();

                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->ADD_PACKAGES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Add Package::".$id;

                $logs = \App\Models\AdminLog::writeadminlog($params); 
                
                session()->flash('success_message', $this->addMsg);
            
            
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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_PACKAGES);
        
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
        $data['Package'] = PackageCategory::pluck("title","id")->all();

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_PACKAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $model = $this->modelObj->find($id);

        $status = 1;
        $msg = $this->updateMsg;
        $data = array();   

        $packages_id = request()->get('packages_id');
        $image = request()->file('image');
        $title = request()->get('title');     
        
        $validator = Validator::make($request->all(), [
            'packages_id'=>'required|numeric',     
            'image'=>'image',
            'title'=>'required'
        
        ]);
        
        // check validations
        if(!$model)
        {
            $status = 0;
            $msg = "Record not found !";
        }
                
        else
        {
            $image_record = Package::find($id);
            if($request->hasFile('image'))
            {

            $destinationPath = public_path().'/themes/admin/assets/upload/package';

            $images=$image->getClientOriginalName();
            $extension =$image->getClientOriginalExtension();
            $images=md5($images);
            $image_name= $images.'.'.$extension;

            $file =$image->move($destinationPath,$image_name);
            $image_record->image=$image_name;  
        }            
            $image_record->packages_id=$packages_id;                                  
            $image_record->title=$title;            
            $image_record->save();

            //store logs detail
            $params=array();    
                                    
            $params['adminuserid']  = \Auth::guard('admins')->id();
            $params['actionid']     = $this->adminAction->EDIT_PACKAGES ;
            $params['actionvalue']  = $id;
            $params['remark']       = "Edit Package::".$id;
                                    
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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_PACKAGES);
        
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
                $params['actionid']     = $this->adminAction->DELETE_PACKAGES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Delete Package::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_PACKAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }

        $model = Package::select(TBL_PACKAGES.".*",TBL_PACKAGE_CATEGORIES.".title as packages_title")
                ->join(TBL_PACKAGE_CATEGORIES,TBL_PACKAGE_CATEGORIES.".id","=",TBL_PACKAGES.".packages_id");

        return Datatables::eloquent($model)  

            ->addColumn('image', function (Package $data) {
                $path = asset("themes/admin/assets/upload/package/".$data->image);
                return '<img src="'.$path.'" class="img-responsive" style="width:100px; height:50px" />';
            })       
            
            ->addColumn('action', function(Package $row) {

                return view("admin.partials.action",
                    [
                        'currentRoute' => $this->moduleRouteText,
                        'row' => $row,                                 
                        'isEdit' =>1,
                        'isDelete' => 1,                                                         
                    ]
                )->render();
            })

            ->editColumn('created_at', function($row){
                    
                if(!empty($row->created_at))          
                    return date("j M, Y h:i:s A",strtotime($row->created_at));
                else
                    return '-';    
            })->rawColumns(['action','image'])

            ->filter(function ($query) 
            {                                                    
                $search_start_date = request()->get("search_start_date"); 
                $search_end_date = request()->get("search_end_date"); 
                $search_title = request()->get("search_title");
                $search_package = request()->get("search_package");
                                      
                if (!empty($search_start_date)){

                    $from_date=$search_start_date.' 00:00:00';
                    $convertFromDate= $from_date;

                    $query = $query->where(TBL_PACKAGES.".created_at",">=",addslashes($convertFromDate));
                }
                if (!empty($search_end_date)){

                    $to_date=$search_end_date.' 23:59:59';
                    $convertToDate= $to_date;

                    $query = $query->where(TBL_PACKAGES.".created_at","<=",addslashes($convertToDate));
                }
                if(!empty($search_title))
                {
                    $query = $query->where(TBL_PACKAGES.".title",$search_title);
                }
                if(!empty($search_package))
                {
                    $query = $query->where(TBL_PACKAGES.".packages_id",$search_package);
                }  
                

            })
        ->make(true);
    }
}



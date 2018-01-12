<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Datatables;
use App\Models\AdminLog;
use App\Models\AdminAction;

class BlogTagsController extends Controller
{
    public function __construct() {

        $this->moduleRouteText = "blog.tags";
        $this->moduleViewName = "admin.BlogTags";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Blog Tages";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new BlogTag();  
      
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
    public function index(Request $request)
    {   
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_BLOG_TAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        } 
        $data = array();        
        $data['page_title'] = "Blog Tags";

        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_BLOG_CATEGORY);                  
        
        return view($this->moduleViewName.".index", $data);     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_BLOG_TAGES);
        
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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_BLOG_TAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }               
        $status = 1;
        $msg = $this->addMsg;
        $data = array();
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2',
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
                $params['actionid']     = $this->adminAction->ADD_BLOG_TAGES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Add Blog Tags::".$id;

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
     * @return \Illuminate\Http\Responseid
     */
    public function edit($id, Request $request)
    {        
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_BLOG_TAGES);
        
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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_BLOG_TAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }       
        
        $model = $this->modelObj->find($id);

        $status = 1;
        $msg = $this->updateMsg;
        $data = array();        
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2',
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
                $params['actionid']     = $this->adminAction->EDIT_BLOG_TAGES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Edit Blog Tags::".$id;

                $logs=\App\Models\AdminLog::writeadminlog($params);

            session()->flash('success_message', $msg);
        }
        
        return ['status' => $status, 'msg' => $msg, 'data' => $data];        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_BLOG_TAGES);
        
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
                $params['actionid']     = $this->adminAction->DELETE_BLOG_TAGES;
                $params['actionvalue']  = $id;
                $params['remark']       = "Detete Blog Tags::".$id;

                $logs=\App\Models\AdminLog::writeadminlog($params);;            

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_BLOG_TAGES);
        
        if($checkrights) 
        {
            return $checkrights;
        }         
        $model = BlogTag::query();

        return Datatables::eloquent($model)
                ->editColumn('status', 'admin.partials.status')
                
                ->editColumn('created_at', function($row){
                
                if(!empty($row->created_at))         
                    return date("j M, Y",strtotime($row->created_at));
                else
                    return '-';    
                })

               ->addColumn('action', function(BlogTag $row) {
                    return view("admin.partials.action",
                            [
                                'currentRoute' => $this->moduleRouteText,
                                'row' => $row,
                                'isEdit' =>  \App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_BLOG_TAGES),
                                'isDelete' =>  \App\Models\Admin::isAccess(\App\Models\Admin::$DELETE_BLOG_TAGES),
                            ]
                            )->render();
                })->rawColumns(['status','action'])                
                ->filter(function ($query) 
                {
                    $search_id = request()->get("search_id");                    
                    $search_text = request()->get("search_text");                    
                    $search_status = request()->get("search_status");  

                    if(!empty($search_id))
                    {
                        $idArr = explode(',', $search_id);
                        $idArr = array_filter($idArr);                
                        if(count($idArr)>0)
                        {
                            $query = $query->whereIn("id",$idArr);
                        } 
                    }
                    if(!empty($search_text))
                    {
                        $query = $query->where('title', 'LIKE', '%'.$search_text.'%');
                    }               

                    if($search_status == "1" || $search_status == "0")
                    {
                        $query = $query->where('status', $search_status);
                    }                           

                })
                ->make(true);        
    }        
}

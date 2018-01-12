<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogPostTag;
use Datatables;
use App\Models\AdminLog;
use App\Models\AdminAction;

class BlogPostsController extends Controller
{
    public function __construct() 
    {

        $this->moduleRouteText = "blog.posts";
        $this->moduleViewName = "admin.BlogPost";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Blog Post";
        $this->module = $module;        

        $this->adminAction= new AdminAction;

        $this->modelObj = new BlogPost;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_BLOG_POSTS);
        
        if($checkrights) 
        {
            return $checkrights;
        }
       
        $data = array();

        $data['category'] = \App\Models\BlogCategory::pluck("title","id")->all();        
        
        $data['page_title'] = "Manage Blog Posts";
        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_BLOG_POSTS);

     
        return view($this->moduleViewName.".index", $data);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_BLOG_POSTS);
        
        if($checkrights) 
        {
            return $checkrights;
        }
        
        $model = $this->modelObj;
        $data = array();
        $data['formObj'] = $this->modelObj;
        $data['categories'] = ['' => 'select category'] + \App\Models\BlogCategory::pluck("title","id")->toArray();
        
        $data['page_title'] = "Add ".$this->module;
        $data['action_url'] = $this->moduleRouteText.".store";
        $data['action_params'] = 0;
        $data['buttonText'] = "Save";
        $data["method"] = "POST";

        $data['tags'] = \DB::table("blog_tags")->orderBy("title","ASC")->get();

        $data['list_tags'] = [];

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$ADD_BLOG_POSTS);
        
        if($checkrights) 
        {
            return $checkrights;
        }        
        
        $status = 1;
        $msg = $this->addMsg;
        $data = array();
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2',
            'category_id'=> 'required|exists:'.TBL_BLOG_CATEGORY.',id',
            'tags'=> 'required|exists:'.TBL_BLOG_TAGES.',id',
            'short_description'=>'required|min:5',
            'content'=>'required|min:5'

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

            $tags = $request->get('tags');
            

            if(is_array($tags))
            {
                foreach ($tags as $tag)
                {
                    $post_insert = new BlogPostTag();

                    $post_insert->post_id=$obj->id;
                    $post_insert->tag_id=$tag;
                    $post_insert->save();
       
                }   
            }
            
            //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->ADD_BLOG_POSTS;
                $params['actionvalue']  = $id;
                $params['remark']       = "Add Blog Posts::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_BLOG_POSTS);
        
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
        $data['categories'] = ['' => 'select category'] + \App\Models\BlogCategory::pluck("title","id")->toArray();

        $data['tags'] = \DB::table("blog_tags")->orderBy("title","ASC")->get();

        $data['list_tags'] = $formObj->getTags(1);

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
        
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$EDIT_BLOG_POSTS);
        
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
            'category_id'=> 'required|exists:'.TBL_BLOG_CATEGORY.',id',
            'tags'=> 'required|exists:'.TBL_BLOG_TAGES.',id',
            'short_description'=>'required|min:10',
            'content'=>'required|min:10'
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
            $title = $request->get('title');
            $short_description = $request->get('short_description');
            $content = $request->get('content');
            $category_id = $request->get('category_id');
            $tags = $request->get('tags');

            $record = BlogPost::find($id);

            $record->title = $title; 
            $record->short_description = $short_description; 
            $record->content = $content; 
            $record->category_id = $category_id; 
            $record->save();

            // Tags
            $table = "blog_post_tags";

            // delete old records
            \DB::table($table)->where('post_id',$record->id)->delete();
            

            if($request->has('tags'))
            {
                if(is_array($tags))
                {
                    foreach($tags as $tag)
                    {                 
                        $blogtags = new BlogPostTag();
                        $blogtags->post_id=$record->id;
                        $blogtags->tag_id=$tag;
                        $blogtags->save();
                    }
                }  
            }

            //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->EDIT_BLOG_POSTS;
                $params['actionvalue']  = $id;
                $params['remark']       = "Edit Blog Posts::".$id;

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
       $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$DELETE_BLOG_POSTS);
        
        if($checkrights) 
        {
            return $checkrights;
        }  
        
        
        $modelObj = $this->modelObj->find($id);

        if($modelObj) 
        {
            try 
            {    
                \DB::table('blog_post_tags')->where('post_id',$id)->delete();

                $backUrl = $request->server('HTTP_REFERER');
                $modelObj->delete();
                session()->flash('success_message', $this->deleteMsg);

                //store logs detail
                $params=array();
                
                $params['adminuserid']  = \Auth::guard('admins')->id();
                $params['actionid']     = $this->adminAction->DELETE_BLOG_POSTS;
                $params['actionvalue']  = $id;
                $params['remark']       = "Delete Blog Posts::".$id;

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
        $checkrights = \App\Models\Admin::checkPermission(\App\Models\Admin::$LIST_BLOG_POSTS);
        
        if($checkrights) 
        {
            return $checkrights;
        } 
        
        $model =  BlogPost::select(TBL_BLOG_POST.".*", TBL_BLOG_CATEGORY.".title as category_title")
                    ->join(TBL_BLOG_CATEGORY,TBL_BLOG_CATEGORY.".id", "=",TBL_BLOG_POST.".category_id");
        
        return Datatables::eloquent($model)
                ->editColumn('status', 'admin.partials.status')
                
                ->editColumn('created_at', function($row){
                
                if(!empty($row->created_at))         
                    return date("j M, Y",strtotime($row->created_at));
                else
                    return '-';    
                })

                ->addColumn('action', function(BlogPost $row) {
                    return view("admin.partials.action",
                                [
                                    'currentRoute' => $this->moduleRouteText,
                                    'row' => $row,
                                    'isEdit' => \App\Models\Admin::isAccess(\App\Models\Admin::$EDIT_BLOG_POSTS),
                                    'isDelete' => \App\Models\Admin::isAccess(\App\Models\Admin::$DELETE_BLOG_POSTS)                           
                                ]
                            )
                            ->render();
                })                
                ->filter(function ($query) 
                {
                    $search_category = request()->get("search_category");                    
                    $search_text = request()->get("search_text");                    
                    $search_status = request()->get("search_status");  

                    if(!empty($search_category))
                    {
                        $query = $query->where(TBL_BLOG_POST.'.category_id', 'LIKE', '%'.$search_category.'%');
                    }

                    if(!empty($search_text))
                    {
                        $query = $query->where(TBL_BLOG_POST.'.title', 'LIKE', '%'.$search_text.'%');
                    }               

                    if($search_status == "1" || $search_status == "0")
                    {
                        $query = $query->where(TBL_BLOG_POST.'.status', $search_status);
                    }                           

                })
                ->make(true);        
    }
}

<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Datatables;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\models\AdminLog;
use App\Models\AdminAction;

class PortfolioController extends Controller
{
    public function __construct() { 

        $this->moduleRouteText = "portfolio";
        $this->moduleViewName = "admin.portfolios";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Portfolio";
        $this->module = $module;  

        $this->adminAction= new AdminAction; 
        
        $this->modelObj = new Portfolio();  

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
        
        $data = array();        
        $data['page_title'] = "Manage Portfolio";

        $data['add_url'] = route($this->moduleRouteText.'.create');
        $data['btnAdd'] = \App\Models\Admin::isAccess(\App\Models\Admin::$ADD_COUNTRIES);                  
        
        $data['Category'] = PortfolioCategory::pluck("title","id")->all();
        return view($this->moduleViewName.".index", $data);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                
        $data = array();
        $data['formObj'] = $this->modelObj;
        $data['page_title'] = "Add".$this->module;
        $data['action_url'] = $this->moduleRouteText.".store";
        $data['action_params'] = 0;
        $data['buttonText'] = "Save";
        $data["method"] = "POST"; 
        $data['Category'] = PortfolioCategory::pluck("title","id")->all();
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

        $status = 1;
        $msg = $this->addMsg;
        $data = array();

        $category_id = request()->get('category_id');
        $image = request()->file('image');
        $title = request()->get('title');

        $validator = Validator::make($request->all(), [
            'category_id'=>'required|numeric',   
            'image'=>'image',
            'title'=>'required'
        
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
            $destinationPath = public_path().'/themes/admin/assets/upload/protfolio';
            $images=$image->getClientOriginalName();
            $extension =$image->getClientOriginalExtension();
            $images=md5($images);
            $image_name= $images.'.'.$extension;

            $file =$image->move($destinationPath,$image_name);

            $image_record= new Portfolio(); 
                               
            $image_record->category_id=$category_id;
            $image_record->image=$image_name;                                  
            $image_record->title=$title;            
            $image_record->save();

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
        $data['Category'] = PortfolioCategory::pluck("title","id")->all();

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
       

        $model = $this->modelObj->find($id);

        $status = 1;
        $msg = $this->updateMsg;
        $data = array();   

        $category_id = request()->get('category_id');
        $image = request()->file('image');
        $title = request()->get('title');     
        
        $validator = Validator::make($request->all(), [
            'category_id'=>'required|numeric',     
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
            $image_record = Portfolio::find($id);
            if($request->hasFile('image'))
            {

            $destinationPath = public_path().'/themes/admin/assets/upload/protfolio';

            $images=$image->getClientOriginalName();
            $extension =$image->getClientOriginalExtension();
            $images=md5($images);
            $image_name= $images.'.'.$extension;

            $file =$image->move($destinationPath,$image_name);
            $image_record->image=$image_name;  
        }            
            $image_record->category_id=$category_id;                                  
            $image_record->title=$title;            
            $image_record->save();

                     
        }
        
        return ['status' => $status,'msg' => $msg, 'data' => $data]; 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        
        $modelObj = $this->modelObj->find($id); 

        if($modelObj) 
        {
            try 
            {             
                $backUrl = $request->server('HTTP_REFERER');
                $modelObj->delete();
                session()->flash('success_message', $this->deleteMsg);                 

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

        $model = Portfolio::select(TBL_PORTFOLIOS.".*",TBL_PORTFOLIOS_CATEGORIES.".title as category_title")
                ->join(TBL_PORTFOLIOS_CATEGORIES,TBL_PORTFOLIOS_CATEGORIES.".id","=",TBL_PORTFOLIOS.".category_id");

        return Datatables::eloquent($model)

            ->addColumn('image', function (Portfolio $data) {
                $path = asset("themes/admin/assets/upload/protfolio/".$data->image);
                return '<img src="'.$path.'" class="img-responsive" style="width:100px; height:50px" />';
            })        
               
            ->addColumn('action', function(Portfolio $row) {
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
            })->rawColumns(['image','action'])            
                        
            ->filter(function ($query) 
            {                                                    
                $search_start_date = request()->get("search_start_date"); 
                $search_end_date = request()->get("search_end_date"); 
                $search_Category = request()->get("search_Category"); 
                $search_title = request()->get("search_title"); 
                $search_email = request()->get("search_email"); 
                $search_id = request()->get("search_id"); 
               
                                      
                if (!empty($search_start_date)){

                    $from_date=$search_start_date.' 00:00:00';
                    $convertFromDate= $from_date;

                    $query = $query->where(TBL_PORTFOLIOS.".created_at",">=",addslashes($convertFromDate));
                }
                if (!empty($search_end_date)){

                    $to_date=$search_end_date.' 23:59:59';
                    $convertToDate= $to_date;

                    $query = $query->where(TBL_PORTFOLIOS.".created_at","<=",addslashes($convertToDate));
                }
                if(!empty($search_id))
                    {
                        $idArr = explode(',', $search_id);
                        $idArr = array_filter($idArr);                
                        if(count($idArr)>0)
                        {
                            $query = $query->whereIn(TBL_PORTFOLIOS.'.id',$idArr);
                        } 
                    }

                if(!empty($search_Category))
                {
                    $query = $query->where(TBL_PORTFOLIOS.".category_id",$search_Category);
                }  
                if(!empty($search_title))
                {
                    $query = $query->where(TBL_PORTFOLIOS.".title", 'LIKE', '%'.$search_title.'%');
                }
                

            })
            ->make(true);               
    } 
}

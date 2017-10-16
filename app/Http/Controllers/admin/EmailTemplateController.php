<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Datatables;
use App\AdminLog;
use App\AdminAction;
use App\Models\EmailSentLog;

class EmailTemplateController extends Controller
{
    public function __construct() {

        $this->moduleRouteText = "email";
        $this->moduleViewName = "admin.email";
        $this->list_url = route($this->moduleRouteText.".index");

        $module = "Email Template";
        $this->module = $module;
        
        $this->adminAction= new \App\Models\AdminAction;

        $this->modelObj = new EmailSentLog;

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
        $array['body']='<h1>test</h1>';
        $array['from_email'] = 'rinkal.shiroya@phpdots.com';
        $array['to_email'] ='phpdots1@gmail.com';
        $array['subject'] = 'Helooo';


             \Mail::send('emails.index', $array, function($message) use ($array)
               {
                   $message->from($array['from_email'], "Dental Insider");            
                   $message->sender($array['from_email'], "Dental Insider");
                   $message->to($array['to_email'], '')->subject($array['subject']);

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
       
        $data = array();        
        $data['page_title'] = "Manage Email Templates";

      

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
        
        $validator = Validator::make($request->all(), [
            'email_subject' => 'required|min:5',
            'email_body' => 'required|min:5',
            'from_email' => 'email',
            'to_email' => 'email',
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
            $input = new EmailSentLog();

            
            $to_email = $request->get('to_email');
            $from_email = $request->get('from_email');
            $email_subject = $request->get('email_subject');
            $email_body = $request->get('email_body');
           
           
            $input->to_email = $to_email;
            $input->from_email = $from_email;
            $input->email_subject = $email_subject;
            $input->email_body = $email_body;

            
            $array['to_email'] = $to_email;

            \Mail::send('emails.index', $array, function($message) use ($array)
               {
                   $message->from($array['rinkal.shiroya@phpdots.com'], "Dental Insider");            
                   $message->sender($array['rinkal.shiroya@phpdots.com'], "Dental Insider");
                   $message->to($array['rinkal.shiroya@phpdots.com'], '')->subject($array['subject']);

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
            
            $input->save();
 
            $id = $input->id;
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
           
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        
    }

    public function data(Request $request)
    {
        $model = EmailSentLog::query();

        return Datatables::eloquent($model)        
               
            

            ->editColumn('created_at', function($row){
                
                if(!empty($row->created_at))          
                    return date("j M, Y h:i:s A",strtotime($row->created_at));
                else
                    return '-';    
            })             
            
            ->make(true);       
    }        
}

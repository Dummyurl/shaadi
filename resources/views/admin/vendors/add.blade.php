@extends('admin.layouts.app')


@section('content')

<div class="page-content">
    <div class="container">
        <div class="row autoResizeHeight">
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user"></i>
                           {{ $page_title }}
                        </div>
                        <a class="btn btn-default pull-right btn-sm mTop5" href="{{ $list_url }}">Back</a>
                    </div>
                    <div class="portlet-body">
                        <div class="form-body">
                           {!! Form::model($formObj,['method' => $method,'files' => true, 'route' => [$action_url,$action_params],'class' => 'sky-form form form-group', 'id' => 'main-frm']) !!} 

                                <div class="row">

                                    <div class="col-md-6">
                                        <label class="control-label">Category: <span class="required">*</span></label>                                        
                                        {!! Form::select('vendor_category_id', [''=>'Select Category'] + $categoryList, null, ['class' => 'form-control', 'data-required' => 'true']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Status: <span class="required">*</span></label>                                        
                                        {!! Form::select('status',['1'=>'Active','2'=>'Inactive'],null,['class' => 'form-control', 'data-required' => true]) !!}
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Personal Details</legend>
                            
                                <div class="row">                                           
                                    <div class="col-md-4">
                                        <label class="control-label">Name: </label>
                                        {!! Form::text('name',null,['class' => 'form-control', 'data-required' => false,'placeholder' => 'Enter Name']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">First Name: <span class="required">*</span></label>
                                        {!! Form::text('firstname',null,['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter First Name']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Last Name: <span class="required">*</span></label>
                                        {!! Form::text('lastname',null,['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter Last Name']) !!}
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">                                           
                                    <div class="col-md-4">
                                        <label class="control-label">Email: <span class="required">*</span></label> 
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        {!! Form::text('email',null,['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter Email Address']) !!}
                                        </div>
                                    </div>
                                    @if($pass_view == 1)
                                    <div class="col-md-4">
                                        <label class="control-label">Password: <span class="required">*</span></label>                                        
                                        {!! Form::password('password',['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter Password']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">re-type Password: <span class="required">*</span></label>
                                        {!! Form::password('password_confirmation',['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter re-type Password']) !!}
                                    </div>
                                    @endif
                                </div>
                            </fieldset>
                            <div class="clearfix">&nbsp;</div>
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Location Details</legend>
                                <div class="row">                                           
                                    <div class="col-md-4">
                                        <label class="control-label">Country: <span class="required">*</span></label>                                        
                                        {!! Form::select('country_id', [''=>'Select Country'] + $countryList, null, ['class' => 'form-control', 'data-required' => 'true','id' => 'cid']) !!}                                     
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">State: <span class="required">*</span></label>                             
                                        {!! Form::select('state_id', [''=>'Select State'] + $stateList, null, ['class' => 'form-control all_state','data-required' => 'true','id' => 'sid']) !!}                                    
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">City: <span class="required">*</span></label>                                        
                                        {!! Form::select('city_id', [''=>'Select City'] + $cityList, null, ['class' => 'form-control all_city','data-required' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>  
                                <div class="row">                                           
                                    <div class="col-md-4">
                                        <label class="control-label">Address: <span class="required">*</span></label>                                        
                                        {!! Form::textarea('address',null,['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter Address','rows'=>'4']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Mobile No: <span class="required">*</span></label>                             
                                        {!! Form::text('mobile',null,['class' => 'form-control', 'data-required' => true,'placeholder' => 'Enter Contact Number']) !!}
                                    </div>
                                </div>
                                </fieldset>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-success pull-right" />
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>            

@endsection

@section('scripts')
<style type="text/css">
fieldset.scheduler-border 
{
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.scheduler-border 
{
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width:auto;
    padding:0 10px;
    border-bottom:none;
}
</style>
<script src="{{ asset('js/jquery.bootstrap-growl.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
   
   var firstTime = 0;
    $(document).ready(function () {
        

        $('#cid').on("change",function() {

                var country_id = $(this).val();
                $('#AjaxLoaderDiv').fadeIn('slow');
               
                $.ajax({
                    type: "POST",
                    url: "{{route('getstates')}}",
                   data: {
                        "_token": "{{ csrf_token() }}",
                        "country_id" : country_id,
                    },
                    success: function(data) {
                        $(".all_state").html('')
                        $(".all_state").html(data);
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        if(firstTime == 0){
                            @if(isset($def_c_id) && $def_c_id > 0)
                              setTimeout(function(){
                                $(".all_state").val({{ $def_state_id }});
                              },400)
                            @endif
                        }
                        firstTime = firstTime + 1;
                    }
                });
            });

        $('#sid').on("change",function() {

                var state_id = $(this).val();
                $('#AjaxLoaderDiv').fadeIn('slow');
               
                $.ajax({
                    type: "POST",
                    url: "{{route('getcities')}}",
                   data: {
                        "_token": "{{ csrf_token() }}",
                        "state_id" : state_id,
                    },
                    success: function(data) {
                        $(".all_city").html('')
                        $(".all_city").html(data);
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        if(firstTime == 0){
                            @if(isset($def_s_id) && $def_s_id > 0)
                              setTimeout(function(){
                                $(".all_city").val({{ $def_state_id }});
                              },400)
                            @endif
                        }
                        firstTime = firstTime + 1;
                    }
                });
            });

        $('#main-frm').submit(function () {
            
            if ($(this).parsley('isValid'))
            {
                $('#AjaxLoaderDiv').fadeIn('slow');
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: function (result)
                    {
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        if (result.status == 1)
                        {
                            $.bootstrapGrowl(result.msg, {type: 'success', delay: 4000});
                            window.location = '{{ $list_url }}';    
                        }   
                        else
                        {
                            $.bootstrapGrowl(result.msg, {type: 'danger', delay: 4000});
                        }
                    },
                    error: function (error) {
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        $.bootstrapGrowl("Internal server error !", {type: 'danger', delay: 4000});
                    }
                });
            }
            
            return false;
        });

        @if(isset($def_c_id) && $def_c_id > 0)
            $("#cid").val({{ $def_c_id }});
            $("#cid").trigger("change");
        @endif

        @if(isset($def_s_id) && $def_s_id > 0)
            $("#sid").val({{ $def_s_id }});
            $("#sid").trigger("change");
        @endif
    });
</script>
@endsection
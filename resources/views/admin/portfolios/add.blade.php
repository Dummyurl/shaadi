@extends('admin.layouts.app')

@section('breadcrumb')

@stop

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

                            <!-- Category id-->
                            <div class="form-group">
                                <label for="sel1"><b>Category</b></label>
                                {!! Form::select('category_id',[''=>'select Category'] + $Category,null,['class'=>'form-control','data-required' => true]) !!} 

                                @if ($errors->has('category_id')) 
                                <span class="help-block">
                                <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                                @endif
                            </div> 
                            <!-- Image -->          
                            <div class="form-group">

                                <label for="title"><b>Image:</b></label>
                                {!! Form::file('image',null,['class' => 'form-control'])!!}                

                                @if ($errors->has('image'))
                                <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>   

                            <!-- Title-->
                            <div class="form-group">
                                <label for="sel1"><b>Title</b></label>
                                {!! Form::text('title', null,['class'=>'form-control','placeholder' => 'Enert Your Title']) !!}

                                @if ($errors->has('title')) 
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>                              
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
<script type="text/javascript">
    $(document).ready(function () {
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
    });
</script>
@endsection



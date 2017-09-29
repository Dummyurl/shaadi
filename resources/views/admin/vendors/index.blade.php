@extends('admin.layouts.app')

@section('content')

<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
    <div class="container">

        <div class="col-md-12">
            
            @include($moduleViewName.".search")           

            <div class="clearfix"></div>    
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i>{{ $page_title }}    
                    </div>
                  
                    @if($btnAdd)
                        <a class="btn btn-default pull-right btn-sm mTop5" href="{{ $add_url }}">Add New</a>
                    @endif                     

                </div>
                <div class="portlet-body">                    
                    <table class="table table-bordered table-striped table-condensed flip-content" id="server-side-datatables">
                        <thead>
                            <tr>
                               <th width="5%">ID</th>                                    
                               <th width="10%">Category</th>                           
                               <th width="20%">Name</th>                           
                               <th width="20%">Email</th>                           
                               <th width="10%">City</th>                           
                               <th width="5%">Status</th>                           
                               <th width="20%">Created At</th>                           
                               <th width="25%" data-orderable="false">Action</th>
                            </tr>
                        </thead>                                         
                        <tbody>
                        </tbody>
                    </table>                                              
                </div>
            </div>              
        </div>
    </div>
</div>
</div>  
<div class="modal fade bs-modal-lg" id="vendor_view" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Vendor Details</h4>
        </div>
        <div class="modal-body">
          <table class="table" id="vendor_detail_table">
            
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>          
@endsection

@section('styles')
  
@endsection

@section('scripts')
    <script type="text/javascript">  

    function openView($id){
      jQuery('#vendor_view').modal();     
      $('#AjaxLoaderDiv').fadeIn('slow');
      
      var vendor_url="{{asset('/admin/vendors/view') }}";  
               
      $.ajax({
          type: "GET",
          url: vendor_url,
          data: 
          {
              vendor_id: $id
          },
          success: function (result)
          {
              $("#vendor_detail_table").html(result);
              $('#AjaxLoaderDiv').fadeOut('slow');
          },
          error: function (error) 
          {
              $('#AjaxLoaderDiv').fadeOut('slow');
          }
      });

    } 

    $(document).ready(function(){

      $(document).on('click', '.btn-update-status', function () {
            $text = 'Are you sure you want to change the status?';
            if (confirm($text)==true){
                return true;
            }
            return false;
        });

        $("#search-frm").submit(function(){
            oTableCustom.draw();
            return false;
        });

        $.fn.dataTableExt.sErrMode = 'throw';

        var oTableCustom = $('#server-side-datatables').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                "url": "{!! route($moduleRouteText.'.data') !!}",
                "data": function ( data ) 
                {

                data.search_start_date = $("#search-frm input[name='search_start_date']").val();
                data.search_end_date = $("#search-frm input[name='search_end_date']").val();
                data.search_category = $("#search-frm select[name='search_category']").val();
                data.search_name = $("#search-frm input[name='search_name']").val();
                data.search_email = $("#search-frm input[name='search_email']").val();
                data.search_city = $("#search-frm select[name='search_city']").val();         
                data.search_status = $("#search-frm select[name='search_status']").val();             
                }
            },            
            "order": [[ 0, "desc" ]],    
            columns: [
                { data: 'id', name: 'id' },                                             
                { data: 'category_name', name: '{{ TBL_VENDOR_CATEGORY }}.title' },           
                { data: 'name', name: 'name' },                                           
                { data: 'email', name: 'email' },                          
                { data: 'city_name', name: '{{ TBL_CITY }}.title' },                  
                { data: 'status', name: 'status' },                                   
                { data: 'created_at', name: 'created_at' },                      
                { data: 'action', orderable: false, searchable: false},            
            ]
        });        
    });
    </script>
@endsection

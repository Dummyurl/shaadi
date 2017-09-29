<div class="btn-group">
@if($isView)
<a data-id="{{ $row->id }}" class="btn btn-xs btn-success" onclick="openView({{$row->id}})" title="view">
    <i class="fa fa-eye"></i>
</a>          
@endif

@if($isEdit)
<a href="{{ route($currentRoute.'.edit',['id' => $row->id]) }}" class="btn btn-xs btn-primary" title="edit">
    <i class="fa fa-edit"></i>
</a>         
@endif

@if($isDelete)
<a data-id="{{ $row->id }}" href="{{ route($currentRoute.'.destroy',['id' => $row->id]) }}" class="btn btn-xs btn-danger btn-delete-record" title="delete">
    <i class="fa fa-trash-o"></i>
</a>          
@endif

@if($isStatus)
<a href="{{ url('admin/vendors/change-status/'.$row->id.'/'.$row->status)}}" class="btn btn-xs btn-warning btn-update-status" title="Change Status">
		<i class="fa fa-check-circle-o" aria-hidden="true"></i>
	</a>
@endif
</div>
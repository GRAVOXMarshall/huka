@extends('back.index')

@section('dash-content')
    <div class="row d-flex align-items-center">
        <div class="col-md-8 pt-3 pb-2 mb-3">
        	<h1 class="h2 mb-0 text-gray-800">Admins</h1>
        </div>
        <div class="col-sm-4 d-flex align-items-end flex-column mt-2 mb-1">
            <h5>
            	<a href="{{ route('dash.new.admin') }}" class="btn btn-outline-primary btn-sm" role="button"><i class="fas fa-plus"></i> Add admin</a>
            </h5>
        </div>
    </div>
    @if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif
	<table class="data-table table table-striped table-bordered">
		<thead>
			<tr>
				<th class="text-center w-5">ID</th>
				<th class="w-30">Firstname</th>
				<th class="w-45">Lastname</th>
				<th class="w-5">Email</th>
				<th class="w-15">Group name</th>
				@if(Auth::guard('admins')->user()->is_admin === 2 )
					<th class="w-15">Delete</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($admins as $admin)
			<tr>
				<td class="text-center">{{ $admin->id }}</td>
				<td class="text-center">{{ $admin->firstname }}</td>
				<td class="text-center">{{ $admin->lastname }}</td>
				<td class="text-center">{{ $admin->email }}</td>
				<td class="text-center">{{ $admin->name }}</td>
				@if(Auth::guard('admins')->user()->is_admin === 2 && $admin->group_id != 1)
					<td class="text-center">
						<form action="{{ route('delete.admin') }}" method="post">	
							@csrf
							<input type="text" value="{{ encrypt($admin->id) }}" name="admin_id">
							<button class="btn btn-danger">Delete</button>
						</form>
					</td>
				@elseif(Auth::guard('admins')->user()->is_admin === 2 && $admin->group_id == 1)
					<td class="text-center"><strong>Main administrator</strong></td>
				@endif
			@endforeach
		</tbody>
	</table>
	@push('extra_scripts')
	  <script type="text/javascript">
	  	$('input[name=admin_id]').hide();
	  </script>
  @endpush
@endsection
@extends('back.index')

@section('dash-content')
    <div class="row d-flex align-items-center">
        <div class="col-md-8 pt-3 pb-2 mb-3">
        	<h1 class="h2 mb-0 text-gray-800">Admins</h1>
        </div>
        <div class="col-sm-4 d-flex align-items-end flex-column mt-2 mb-1">
            <h5>
            	<a href="{{ route('add.page') }}" class="btn btn-outline-primary btn-sm" role="button"><i class="fas fa-plus"></i> Add admin</a>
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
			</tr>
		</thead>
		<tbody>
			@foreach($admins as $admin)
			<tr>
				<td class="text-center">{{ $admin->id }}</td>
				<td class="text-left">{{ $admin->firstname }}</td>
				<td class="text-left">{{ $admin->lastname }}</td>
				<td class="text-left">{{ $admin->email }}</td>
				<td class="text-left">{{ $admin->name }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection
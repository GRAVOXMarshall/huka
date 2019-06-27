@extends('back.index')

@section('dash-content')
	<div class="row d-flex align-items-center">
        <div class="col-md-8 pt-3 pb-2 mb-3">
        	<h1 class="h2 mb-0 text-gray-800">Layouts</h1>
        </div>
        <div class="col-sm-4 d-flex align-items-end flex-column mt-2 mb-1">
            <h5>
            	<a href="{{ route('add.layout') }}" class="btn btn-outline-primary btn-sm" role="button"><i class="fas fa-plus"></i> Add layout</a>
            </h5>
        </div>
    </div>
    @if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif
	<table class="data-table table table-striped table-bordered">
		<!-- @important la clase w-5, w-10, w-15, w-20, w-30, w-40 y w-45 no existe en boostrap por lo cual se debe crear en el nuevo template-->
		<thead>
			<tr>
				<th class="w-5">ID</th>
				<th class="w-30">Name</th>
				<th class="w-5">Show</th>
				<th class="w-15"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($layouts as $layout)
			<tr>
				<td class="text-center">{{ $layout->id }}</td>
				<td class="text-left">{{ $layout->name }}</td>
				<td class="text-center">{{ $layout->active }}</td>
				<td class="text-center">
					<div class="btn-group btn-block">
						<a href="{{ route('edit.layout.design', ['layout' => $layout->id]) }}" class="btn btn-outline-primary btn-sm" role="button"><i class="far fa-edit"></i> Edit design</a>
					  <div class="btn-group" role="group">
					    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    </button>
					    <div class="dropdown-menu dropdown-menu-right">
					    	<a href="{{ route('edit.layout', ['layout' => $layout->id]) }}" class="dropdown-item"><i class="far fa-edit"></i> Edit information</a>
					    	<div class="dropdown-divider"></div>
							<a href="#" onclick="alert('Are you sure you want to delete this layout?', '{{ route('delete.layout', ['layout' => $layout->id]) }}' )" class="dropdown-item"><i class="far fa-trash-alt"></i> Delete</a>
					    </div>
					  </div>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection
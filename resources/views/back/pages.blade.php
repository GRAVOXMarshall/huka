@extends('back.index')

@section('dash-content')
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="row d-flex align-items-center">
	        <div class="col-md-8 pt-3 pb-2 mb-3">
	            <h2>Pages</h2>
	        </div>
	        <div class="col-sm-4 d-flex align-items-end flex-column mt-2 mb-1">
	            <h5>
	            	<a href="{{ route('add.page') }}" class="btn btn-outline-primary btn-sm" role="button"><i class="fas fa-plus"></i> Add page</a>
	            </h5>
	        </div>
	    </div>
	    @if (session('status'))
		    <div class="alert alert-success">
		        {{ session('status') }}
		    </div>
		@endif
		<div class="row mb-3">
		  <div class="col-12">
		    <div class="list-group list-group-horizontal-md" role="tablist">
		    	<a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-front" role="tab" aria-controls="front">
		    		<h2 align="center">Front-End</h2>
		    	</a>
		    	<a class="list-group-item list-group-item-action" data-toggle="list" href="#list-back" role="tab" aria-controls="back">
		    		<h2 align="center">Back-End</h2>
		    	</a>
		    </div>
		  </div>
		</div>
		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="list-front" role="tabpanel">
				<table class="data-table table table-striped table-bordered">
					<!-- @important la clase w-5, w-10, w-15, w-20, w-30, w-40 y w-45 no existe en boostrap por lo cual se debe crear en el nuevo template-->
					<thead>
						<tr>
							<th class="w-5">ID</th>
							<th class="w-30">Name</th>
							<th class="w-45">Description</th>
							<th class="w-5">Show</th>
							<th class="w-15"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($front as $page)
						<tr>
							<td class="text-center">{{ $page->id }}</td>
							<td class="text-left">{{ $page->name }}</td>
							<td class="text-left">{{ $page->description }}</td>
							<td class="text-center">{{ $page->active }}</td>
							<td class="text-center">
								<div class="btn-group btn-block">
								  <a href="{{ route('view.page', ['page' => $page->id]) }}" target="_blank" class="btn btn-outline-primary btn-sm" role="button"><i class="far fa-eye"></i> View</a>
								  <div class="btn-group" role="group">
								    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    </button>
								    <div class="dropdown-menu dropdown-menu-right">
								    	<a href="{{ route('edit.page', ['page' => $page->id]) }}" class="dropdown-item"><i class="far fa-edit"></i> Edit</a>
								    	<div class="dropdown-divider"></div>
										<a href="#" onclick="alert('Are you sure you want to delete this page?', '{{ route('delete.page', ['page' => $page->id]) }}' )" class="dropdown-item"><i class="far fa-trash-alt"></i> Delete</a>
								    </div>
								  </div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="list-back" role="tabpanel">
				<table class="data-table table table-striped table-bordered">
					<thead>
						<tr>
							<th class="w-5">ID</th>
							<th class="w-30">Name</th>
							<th class="w-45">Description</th>
							<th class="w-5">Show</th>
							<th class="w-15"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($back as $page)
						<tr>
							<td class="text-center">{{ $page->id }}</td>
							<td class="text-left">{{ $page->name }}</td>
							<td class="text-left">{{ $page->description }}</td>
							<td class="text-center">{{ $page->active }}</td>
							<td class="text-center">
								<div class="btn-group btn-block">
								  <a href="{{ route('view.page', ['page' => $page->id]) }}" target="_blank" class="btn btn-outline-primary btn-sm" role="button"><i class="far fa-eye"></i> View</a>
								  <div class="btn-group" role="group">
								    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    </button>
								    <div class="dropdown-menu dropdown-menu-right">
								    	<a href="{{ route('edit.page', ['page' => $page->id]) }}" class="dropdown-item"><i class="far fa-edit"></i> Edit</a>
								    	<div class="dropdown-divider"></div>
										<a href="#" onclick="alert('Are you sure you want to delete this page?', '{{ route('delete.page', ['page' => $page->id]) }}' )" class="dropdown-item"><i class="far fa-trash-alt"></i> Delete</a>
								    </div>
								  </div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	    </div>
    </main>
@endsection
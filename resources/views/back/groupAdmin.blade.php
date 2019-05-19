@extends('back.admins')

@section('user-content')
<br><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" align="center">
			<h3>Group</h3>
		</div>
	</div><br>
	<div class="col-md-12">
           @if(session()->has('txt'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('txt') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          </div>
          <div class="col-md-12">
        @endif 
        @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
        @endif
      </div><br>
	<div class="row">
		<div class="col-md-12" align="right">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
			 Add Group
			</button>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-12">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Name</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  
			  	@if(isset($group) && $group != [])
		        	@foreach($group as $groups)
		        	 <tbody>
			  		<tr>
		        	<th scope="row">{{$groups['id']}}</th>
		        	<td>{{$groups['name']}}</td>
			      	<td>
			      		<div class="dropdown">
						  <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Options
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="{{ route('configuration.group', ['id' => $groups['id']]) }}">Configurar</a>

						    <a class="dropdown-item" href="{{ route('delete.group', ['id' => $groups['id']]) }}">Borrar</a>
						    
						  </div>
						</div>
					</td>
			      	</tr>
			 		 </tbody>
			        @endforeach
		        @else
			        <tbody>
				  	<tr>
		        	<th scope="row">0</th>
		        	<td>No Data</td>
			      	<td>No Data</td>
			      	</tr>
			  		</tbody>
		        @endif
		        
			</table>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<div class="col-md-4"></div>
	        <div class="col-md-4" align="center"><h5 class="modal-title" id="exampleModalLabel" >Add Group</h5></div>
	        <div class="col-md-4">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
	        </div>
	      </div>
	      <div class="modal-body">
	       <form action="{{ route('add.group.admin') }}" method="post">
	       	@csrf
	       	<div class="row">
				<div class="col-md-12 col-12">
					<p><strong>Name</strong><span class="text-danger">*</span></p> 
					<input type="text" class="form-control" name="group" required>
				</div>
			</div><br>
	       <div class="modal-footer">
	        <button class="btn btn-primary">Save changes</button>
	      </div>
	      </form>
	      </div>
	    </div>
	  </div>
	</div>
</div>
 
@endsection
@extends('back.index')

@section('dash-content')
    <div class="row d-flex align-items-center">
        <div class="col-md-8 pt-3 pb-2 mb-3">
        	<h1 class="h2 mb-0 text-gray-800">Add admin</h1>
        </div>
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
      </div>
    </div>
    <form action="{{ route('dash.add.admin') }}" method="post">
    	@csrf
     	<div class="row">
     		<div class="col-md-6">
     			<label>Firstname</label>
     			<input type="text" placeholder="Firstname" class="form-control" name="firstname">
     		</div>
     		<div class="col-md-6">
     			<label>Lastname</label>
     			<input type="text" placeholder="Lastname" class="form-control" name="lastname">
     		</div>
     	</div><br>
     	<div class="row">
     		<div class="col-md-6">
     			<label>Email</label>
     			<input type="email" placeholder="Example@example.com" class="form-control" name="email">
     		</div>
     		<div class="col-md-6">
     			<label>Password</label>
     			<input type="password" class="form-control" name="pass">
     		</div>
     	</div><br>
     	<div class="row">
     		<div class="col-md-12">
     			<label>Groups</label>
     			<select class="form-control" name="group" required>
     				<option value="">[Select a group..]</option>
     				@foreach($groups as $group)
     					<option value="{{$group->id}}">{{ $group->name }}</option>
     				@endforeach
     			</select>
     			<input type="button" value="Add new group or Assign permissions" class="btn btn-outline-secondary form-control" data-toggle="modal" data-target="#exampleModal" name="">
     			<!--<button class="btn btn-secondary form-control" data-toggle="modal" data-target="#exampleModal">Add new group or Assign permissions</button> -->
     		</div>
     	</div><br><br><br>
     	<div class="row">
     		<div class="col-md-5"></div>
     		<div class="col-md-2" align="center"><button class="btn btn-primary form-control">Submit!</button></div>
     		<div class="col-md-5"></div>
     	</div>
     </form>
     <!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
	        	<div class="col-md-12 btn-group btn-group-toggle" data-toggle="buttons">
				  <label class="btn btn-outline-primary active">
				    <input type="radio" name="options" id="option1" value="group" checked> Group
				  </label>
				  <label class="btn btn-outline-primary">
				    <input type="radio" name="options" id="option2" value="permit"> Permit
				  </label>
				</div>
	        	<!--<div class="col-md-6" align="center"><button class="form-control asxd">Groups</button></div>
	        	<div class="col-md-6" align="center"><button class="form-control">Permits</button></div>-->
	        </div><br>
	        <!-- CONTENT GROUPS -->
	        <div class="row groupBlock">
	        	<div class="col-md-12" align="center">
	        		<form action="{{ route('add.group') }}" method="post">
	        			@csrf
	        			<label>Name:</label>
	        			<input type="text" class="form-control" name="group"><br>
	        			<button class="btn btn-primary">Save changes</button>
	        		</form>
	        	</div>
	        </div>
	        <!-- CONTENT PERMITS -->
	        <div class="row permitBlock" align="center">
	        	<div class="texto col-md-12"></div>
	        	<div class="col-md-5">
	        		<label>Groups</label>
	        		<div style="border: gray 1px solid; border-radius: 8px; padding: 10px; height: 160px; overflow-x: hidden; overflow-y: auto;">
	        			@foreach($groups as $group)
							<div class="row">
			        			<div class="col-md-10" align="left">
			        				<div class="form-check">
									  <input class="form-check-input groups" route="{{ route('load.group') }}" data="{{ $group->id }}-{{$group->name}}" type="radio" name="groupRadios" id="group{{$group->id}}"  value="{{$group->id}}">
									  <label class="form-check-label" for="group{{$group->id}}">
									   	{{ $group->name }}
									  </label>
									</div>
			        			</div>
			        			@if(!in_array($group->id, array_column($admin->toArray(), 'group_id')))		
				        			<div class="col-md-2">
				        				<a href="{{ route('delete.group', [ '$id' => $group->id ]) }}"><i class="fa fa-trash"></i></a>
				        			</div>
			        			@endif
			        		</div>
			        		<hr style="color: gray;">
	        			@endforeach
	        		</div>
	        	</div>
	        	<div class="col-md-2"><br><br></div>
	        	<div class="col-md-5">
	        		<label>Permits</label>
	        		<div class="permits" style="border: gray 1px solid; border-radius: 8px; padding: 10px; height: 160px; overflow-x: hidden; overflow-y: auto;">
	        			
	        		</div>
	        	</div>
	        </div>
	      </div>
	      <!--<div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        
	      </div>-->
	    </div>
	  </div>
	</div>
  @push('extra_scripts')
  <script type="text/javascript">
  	$(".permitBlock").hide();
  	$("input[name=options]").change(function(){
  		if ($(this).is(":checked")) {
  			console.log($(this).val());
  			if ($(this).val() == "group") {
  				$(".groupBlock").show();
  				$(".permitBlock").hide();
  			}else{
  				$(".permitBlock").show();
  				$(".groupBlock").hide();
  			}
  		}
  	});
  </script>
  @endpush
 <!--$(".asxd").click(function(){
          alert("holaa");
        });-->
@endsection

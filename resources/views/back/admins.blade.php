@extends('back.index')

@section('dash-content')
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        @if(Auth::guard('admins')->user())
          <h4 class="text-primary">{{ Auth::guard('admins')->user()->email }}</h4>
        @endif
      </div>
       <!-- Input -->
    <div class="js-form-message mb-4">
      <div class="row">
        <div class="col-md-3 col-6"> 
        	<form action="{{ route('dash.users') }}" method="get">
        		<button class="btn btn-outline-primary form-control">Admin list</button>
        	</form>   
        </div>
        <div class="col-md-3 col-6">
        	<form action="{{ route('register.admin') }}" method="get">
        		<button class="btn btn-outline-primary form-control">Register</button>
        	</form>
        </div>
        <div class="col-md-3 col-6">
        	<form action="{{ route('group.admin') }}" method="get">
        		<button class="btn btn-outline-primary form-control">Groups</button>
        	</form>
        </div>
        <div class="col-md-3 col-6">
        	<form action="{{ route('permits.admin') }}" method="get">
        		<button class="btn btn-outline-primary form-control">Permits</button>
        	</form>      
        </div>
      </div>
    </div>
    <!-- End Input -->

    	<!-- Content -->
        @yield('user-content')
        <!-- End Content -->

        @if(request()->is('admin/dashboard/users'))
        <br><br>
        	<div class="container-fluid">
				<div class="row">
					<div class="col-md-12" align="center">
						<h1 class="h3 text-primary font-weight-normal mb-0"><strong>List of administrators</strong></span></h1>
					</div>
				</div><br>
				<div class="row">
								<div class="col-md-12">
									<!-- Transaction Table -->
									<div class="table-responsive-md u-datatable">
									  <table class="js-datatable table "
									         data-dt-info="#datatableInfo"
									         data-dt-search="#datatableSearch"
									         data-dt-entries="#datatableEntries"
									         data-dt-page-length="12"
									         data-dt-is-responsive="false"
									         data-dt-is-show-paging="true"

									         data-dt-pagination-classes="pagination mb-0"
									         data-dt-pagination-items-classes="page-item"
									         data-dt-pagination-links-classes="page-link"

									         data-dt-pagination-next-classes="page-item"
									         data-dt-pagination-next-link-classes="page-link"
									         data-dt-pagination-next-link-markup='<span aria-hidden="true">»</span>'

									         data-dt-pagination-prev-classes="page-item"
									         data-dt-pagination-prev-link-classes="page-link"
									         data-dt-pagination-prev-link-markup='<span aria-hidden="true">«</span>'>
									    <thead>
									      <tr class="text-uppercase font-size-1" >
									        <th scope="col" class="font-weight-medium">
									          <div class="d-flex justify-content-between align-items-center">
									            Name
									            <div class="ml-2">
									              <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									              <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									            </div>
									          </div>
									        </th>
									        <th scope="col" class="font-weight-medium">
									          <div class="d-flex justify-content-between align-items-center">
									            Group
									            <div class="ml-2">
									              <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									              <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									            </div>
									          </div>
									        </th>
									        <th scope="col" class="font-weight-medium">
									          <div class="d-flex justify-content-between align-items-center">
									            Type
									            <div class="ml-2">
									              <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									              <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									            </div>
									          </div>
									        </th>
									        <th scope="col" class="font-weight-medium">
									          <div class="d-flex justify-content-between align-items-center">
									            State
									            <div class="ml-2">
									              <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									              <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									            </div>
									          </div>
									        </th>
									        <th scope="col" class="font-weight-medium">
									          <div class="d-flex justify-content-between align-items-center">
									            Delete
									            <div class="ml-2">
									              <span class="fas fa-angle-up u-datatable__thead-icon"></span>
									              <span class="fas fa-angle-down u-datatable__thead-icon"></span>
									            </div>
									          </div>
									        </th>
									      </tr>
									    </thead>
				@if($admin)
					@foreach($admin as $admins)
						@if($admins->is_admin != 2 && $admins->email != Auth::guard('admins')->user()->email)
							
									    <tbody class="font-size-1">
									      <tr>
									        <td  >{{ $admins->firstname }} {{ $admins->lastname }}</td>
									        @if(isset($group) && $group != [])
									        	@foreach($group as $groups)
										        	@if($admins->group_id === $groups['id'])
										        		<td>{{$groups['name']}}</td>
										        	@endif
										        	@if($admins->group_id == 0)
										        		<td>No Group</td>
										        	@endif
										        @endforeach
									        @else
									        	<td>No Group</td>
									        @endif
									        <td>
									        @if($admins->is_admin === 1)
												<p class="text-success">Authorize</p> 
											@endif
											@if($admins->is_admin === 0)
												 <p class="text-danger">Not authorize</p>
											@endif
											</td>
									        
									        <td align="center">
									          <form action="{{ route('change.status') }}" method="post">
													@csrf
													<input type="number" hidden value="{{ $admins->id }}" name="id">
													@if($admins->is_admin === 1)
														<button class="btn btn-danger" style="width: 150px;">Not authorize <span class="fas fa-times"></span></button>
													@endif
													@if($admins->is_admin === 0)
														<button class="btn btn-success" style="width: 150px;">Authorize <span class="fas fa-check"></span></button>
														
													@endif
												</form>
									        </td>
									        <td class="align-middle" align="center">
									        	<form action="{{ route('delete.admin') }}" method="post">
													@csrf
													<input type="number" hidden value="{{ $admins->id }}" name="id">
													<button class="btn btn-light"><span class="fas fa-trash-alt fa-lg"></span></button>
												</form>
									        </td>
									      </tr>
									    </tbody>
									 
								<!--<div class="col-md-4">
									<p>{{ $admins->email }}</p>
								</div>
								<div class="col-md-4">
								@if($admins->is_admin === 1)
									<p class="text-success">Autorizado</p>
								@endif
								@if($admins->is_admin === 0)
									<p class="text-danger">No Autorizado</p>
								@endif
								</div>
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-6">
										<form action="{{ route('change.status') }}" method="post">
											@csrf
											<input type="number" hidden value="{{ $admins->id }}" name="id">
											@if($admins->is_admin === 1)
												<button class="btn btn-primary">no autorizar</button>
											@endif
											@if($admins->is_admin === 0)
												<button class="btn btn-primary">autorizar</button>
											@endif
										</form>
									</div>
									<div class="col-md-6">
										<form action="{{ route('delete.admin') }}" method="post">
											@csrf
											<input type="number" hidden value="{{ $admins->id }}" name="id">
											<button class="btn btn-danger">eliminar</button>
										</form>
									</div>
									</div>
								</div>-->
								 
							
						@endif
					@endforeach
				@endif
				 </table>
				</div>
				<!-- End Transaction Table -->
			</div>
			</div><br><br>
			</div>
        @endif
     
    </main>
@endsection
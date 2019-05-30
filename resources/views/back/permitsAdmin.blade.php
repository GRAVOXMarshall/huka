@extends('back.admins')

@section('user-content')
<br><br>
<div class="container-fluid">
		 <div class="texto"></div>
		<div class="row">
			<div class="col-md-3">

				
				<h1 class="h3 text-primary font-weight-normal mb-0" align="center"><strong>Groups</strong></span><span style="font-size: 15px; color: gray;" class="iden"></span></h1><br>
				<div class="list-group border border-primary">
					@if($group->isEmpty())
					<button class="list-group-item list-group-item-action" style="text-align: center; background-color: #A4A3A3; color: white;" disabled>No Data.</button>
					@else
						@foreach($group as $groups)
							<!--<li>{{ $groups->id }} - {{ $groups->name }}</li>-->
							<button route="{{ route('load.group') }}" data="{{ $groups->id }}-{{$groups->name}}" class="list-group-item list-group-item-action groups" style="text-align: center;">{{ $groups->name }}</button>
						@endforeach
					@endif
					
				   
				</div>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-8">
				<h1 class="h3 text-primary font-weight-normal mb-0" align="center"><strong>Permits</strong></span></h1><br>
				<div class=" row permits">
					
				</div>
			</div>
		</div>
</div>
 
@endsection
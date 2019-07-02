@extends('back.index')

@section('dash-content')
	<!-- This content has form to add and edit layout -->
	<div class="row d-flex align-items-center">
        <div class="col-md-12 pt-3 pb-2 mb-3">
        	<h1 class="h2 mb-0 text-gray-800">{{ isset($layout) ? 'Edit layout' : 'Add layout' }}</h1>
        </div>
    </div>
	<form method="post" action="{{ isset($layout) ? route('edit.layout.action') : route('add.layout.action') }}">
		{{ csrf_field() }}
		@if(isset($layout) && $layout->id > 0)
			<input type="hidden" name="layout" value="{{ $layout->id }}">
		@endif
		<div class="custom-control custom-switch mb-3">
			<input type="checkbox" class="custom-control-input" id="active-layout" name="active" {{ (isset($layout) && $layout->active || old('active') == 'on') ? 'checked' : '' }}>
			<label class="custom-control-label" for="active-layout">Active layout</label>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label>Name</label>
				<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ (isset($layout) && $layout->name != '') ? $layout->name : old('name') }}" placeholder="Example: Main-Layout" required >
				{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
			</div>
		</div>
		<div class="row d-flex align-items-center">
			<div class="col-sm-8 d-none d-sm-block">
				<a href="#" class="btn btn-outline-danger" role="button" aria-pressed="true">Cancel</a>
			</div>
			<div class="col-sm-4 d-flex align-items-end flex-column">
				<button type="submit" class="btn btn-outline-success">Save</button>
			</div>
		</div>
	</form>
@endsection
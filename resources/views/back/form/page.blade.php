@extends('back.index')

@section('dash-content')
	<!-- This content has form to add and edit page -->
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="row d-flex align-items-center">
	        <div class="col-md-12 pt-3 pb-2 mb-3">
	            <h2>{{ isset($page) ? 'Edit Page' : 'Add page' }}</h2>
	        </div>
	    </div>
		<form method="post" action="{{ isset($page) ? route('edit.page.action') : route('add.page.action') }}">
			{{ csrf_field() }}
			@if(isset($page) && $page->id > 0)
				<input type="hidden" name="page" value="{{ $page->id }}">
			@endif
			<div class="form-row">
				<div class="form-group col-md-6">
					<div class="custom-control custom-switch mb-3">
						<input type="checkbox" class="custom-control-input" id="active-page" name="active" {{ (isset($page) && $page->active || old('active') == 'on') ? 'checked' : '' }}>
						<label class="custom-control-label" for="active-page">Active Page</label>
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" id="main_page" type="checkbox" name="main_page" {{ (isset($page) && $page->main || old('main_page') == 'on') ? 'checked' : '' }}>
						<label class="custom-control-label" for="main_page">Set as main page</label>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label>Name</label>
					<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ (isset($page) && $page->name != '') ? $page->name : old('name') }}" placeholder="Example: Home" required >
					{!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
				</div>
				<div class="form-group col-md-6">
					<label>Title</label>
					<input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ (isset($page) && $page->title != '') ? $page->title : old('title') }}" placeholder="Example: Page > Home" required>
					{!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label>Type Page</label>
					<select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" required>
						<option value="F" {{ (isset($page) && $page->type === 'F' || old('type') === 'F') ? 'selected' : '' }}>Front-End</option>
						<option value="B" {{ (isset($page) && $page->type === 'B' || old('type') === 'B') ? 'selected' : '' }}>Back-End</option>
					</select>
					{!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
				</div>
				<div class="form-group col-md-6">
					<label>Select Layout (Opcional)</label>
					<select class="form-control {{ $errors->has('layout') ? 'is-invalid' : '' }}" name="layout">
						<option value="0">None</option>
						@if(isset($layouts) && count($layouts) > 0)
							@foreach($layouts as $layout)
								<option value="{{ $layout->id }}" {{ (isset($page) && !is_null($page->parent_layout) && $page->parent_layout === $layout->id || old('layout') == $layout->id) ? 'selected' : '' }}>{{ $layout->name }}</option>
							@endforeach
						@endif
					</select>
					{!! $errors->first('layout', '<div class="invalid-feedback">:message</div>') !!}
				</div>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="3" name="description" required>{{ (isset($page) && $page->description != '') ? $page->description : old('description') }}</textarea>
				{!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
			</div>
			<div class="form-group">
				<label>Friendly link</label>
				<input type="text" class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" name="link" value="{{ (isset($page) && $page->link != '') ? $page->link : old('link') }}" placeholder="Example: home-user" required>
				{!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
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
    </main>
@endsection
@extends('extra.form.config')

@section('title', 'Authentication')

@section('content')
  <form class="module-modal" action="{{ route('authentication.save.config') }}" method="post">
    <div class="form-row">
      <div class="form-group col-md-12">
        <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
          <label class="btn btn-outline-primary active">
            <input type="radio" name="type" value="1" autocomplete="off" checked>
            <h4>Classic</h4>
            <small>This login is executed after a redirect, which loads page</small>
          </label>
          <label class="btn btn-outline-primary">
            <input type="radio" name="type" value="2" autocomplete="off">
            <h4>Modal</h4>
            <small>This login is executed in a modal within of the same page</small>
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-6">
        <label for="session_time">Session time in minutes</label>
        <input id="session_time" class="form-control" type="number" name="session_time" value="10">
      </div>
      <div class="form-group col-6">
        <label for="fail_number">Limit of failures when logging in</label>
        <input id="fail_number" class="form-control" type="number" name="fail_number" value="3">
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-6 text-left">
        <button type="button" class="btn btn-danger btn-close-modal">Cancel</button>
      </div>
      <div class="col-6 text-right">
        <button type="submit" class="btn btn-primary btn-submit-modal">Save</button>
      </div>
    </div>
  </form>
@endsection
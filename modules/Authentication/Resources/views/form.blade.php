@extends('extra.form.config')

@section('title', 'Authentication')

@section('content')
  <form class="module-modal" action="{{ route('authentication.save.config') }}" method="post">
    <div class="form-row">
      <div class="form-group col-md-12">
        <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
          <label class="btn btn-outline-primary {{ !isset($configuration->type) || $configuration->type == 1 ? 'active' : '' }}">
            <input type="radio" name="type" value="1" autocomplete="off" {{ !isset($configuration->type) || $configuration->type == 1 ? 'checked' : '' }}>
            <h4>Classic</h4>
            <small>This login is executed after a redirect, which loads page</small>
          </label>
          <label class="btn btn-outline-primary {{ isset($configuration->type) && $configuration->type == 2 ? 'active' : '' }}">
            <input type="radio" name="type" value="2" autocomplete="off" {{ isset($configuration->type) && $configuration->type == 2 ? 'checked' : '' }}>
            <h4>Modal</h4>
            <small>This login is executed in a modal within of the same page</small>
          </label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-6">
        <label for="session_time">Session time in minutes</label>
        <input id="session_time" class="form-control" type="number" name="session_time" value="{{ isset($configuration->session_time) ? $configuration->session_time : 10 }}">
      </div>
      <div class="form-group col-6">
        <label for="fail_number">Limit of failures when logging in</label>
        <input id="fail_number" class="form-control" type="number" name="fail_number" value="{{ isset($configuration->fail_number) ? $configuration->fail_number : 3 }}">
      </div>
    </div>
    <div class="table-responsive">
      <label>Fields to register a user</label>
      <table class="table table-sm">
          <thead>
            <tr>
              <th width="45%%">
                Name
              </th>
              <th width="40%">
                Type
              </th>
              <th width="10%" align="center">
                Use to login
              </th>
              <th width="5%">
                <button type="button" class="btn btn-sm btn-block btn-primary" onclick="addNewRowToTable(this.parentElement.parentElement.parentElement.parentElement, `<tr><td width='45%' align='center'><div class='input-group input-group-sm'><input class='form-control' type='text' name='input_auth[]' value=''></div></td><td width='40%' align='center'><div class='input-group input-group-sm'><select class='custom-select' name='select_auth[]'><option value='TEXT'>Text</option><option value='EMAIL'>Email</option><option value='PASSWORD'>Password</option><option value='NUMBER'>Number</option><option value='DATE'>Date</option></select></div></td><td width='10%' align='center'><div class='input-group input-group-sm'><select class='custom-select' name='check_login[]'><option value='0' {{ isset($field->login) && !$field->login ? 'selected' : '' }}>No</option><option value='1' {{ isset($field->login) && $field->login ? 'selected' : '' }}>Yes</option></select></div></td><td width='5%' align='center'><button type='button' class='btn btn-sm btn-block btn-danger'><i class='fas fa-trash-alt'></i></button></td></tr>`)"><i class="fas fa-plus"></i></button>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($fields as $field)
              <tr>
                <td width="45%" align="center">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="input_auth[]" value="{{ (isset($field->name)) ? $field->name : $field['name'] }}">
                    </div>
                </td>
                <td width="40%" align="center">
                    <div class="input-group input-group-sm">
                      <select class="custom-select" name="select_auth[]">
                        <option value="TEXT" {{ isset($field->type) && $field->type == 'TEXT' ? 'selected' : '' }}>Text</option>
                        <option value="EMAIL" {{ isset($field->type) && $field->type == 'EMAIL' ? 'selected' : '' }}>Email</option>
                        <option value="PASSWORD" {{ isset($field->type) && $field->type == 'PASSWORD' ? 'selected' : '' }}>Password</option>
                        <option value="NUMBER" {{ isset($field->type) && $field->type == 'NUMBER' ? 'selected' : '' }}>Number</option>
                        <option value="DATE" {{ isset($field->type) && $field->type == 'DATE' ? 'selected' : '' }}>Date</option>
                      </select>
                    </div>
                </td>
                <td width="10%" align="center">
                  <div class="input-group input-group-sm">
                    <select class="custom-select" name="check_login[]">
                      <option value="0" {{ isset($field->login) && !$field->login ? 'selected' : '' }}>No</option>
                      <option value="1" {{ isset($field->login) && $field->login ? 'selected' : '' }}>Yes</option>
                    </select>
                  </div>
                </td>
                <td width="5%" align="center">
                    <button type="button" class="btn btn-sm btn-block btn-danger" onclick="removeElement(this.parentElement.parentElement)"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
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
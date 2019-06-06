@extends('extra.configurations')

@section('content')
  @if(!is_null($configurations) && count($configurations) > 0)
    <div class="tab-pane fade" id="config-database" role="tabpanel">
      <form action="{{ route('authentication.configuration.database') }}" method="post">
        @csrf
        <input type="hidden" name="configuration" value="0">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="input-columns">1.- Select columns to register</label>
            @foreach($columns as $column)
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="column-check custom-control-input" name="columns[]" id="column-{{ $column }}" value="{{ $column }}">
                <label class="custom-control-label" for="column-{{ $column }}">{{ $column }}</label>
              </div>
            @endforeach
          </div>
          <div class="form-group col-md-8">
            <label class="mb-2">2.- Select columns to login</label>
            <div class="mb-4">
              <label>Select username column</label>
              <select id="primary-column" class="form-control column-select" name="username">
              </select>
            </div>
            <div class="mb-4">
              <label>Select password column</label>
              <select id="password-column" class="form-control column-select" name="password">
              </select>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="tab-pane fade" id="login-type" role="tabpanel">
      <form action="{{ route('authentication.configuration.type.login') }}" method="post">
        @csrf
        <input type="hidden" name="configuration" value="0">
        <label>Select Login type</label>
        <div class="form-row">
          <div class="form-group col-md-12">
            <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
              <label class="btn btn-outline-primary active">
                <input type="radio" name="type" value="1" autocomplete="off" checked>
                <h1>Classic</h1>
                <hr>
                <p>This login is executed after a redirection, which loads page<br> to do this action</p>
              </label>
              <label class="btn btn-outline-primary">
                <input type="radio" name="type" value="2" autocomplete="off">
                <h1>Modal</h1>
                <hr>
                <p>This login is executed in a modal within of the same page</p>
              </label>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="tab-pane fade" id="login-type" role="tabpanel">
      <form action="{{ route('authentication.configuration.type.login') }}" method="post">
        @csrf
        <input type="hidden" name="configuration" value="0">
        <label>Select Login type</label>
        <div class="form-row">
          <div class="form-group col-md-12">
            <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
              <label class="btn btn-outline-primary active">
                <input type="radio" name="type" value="1" autocomplete="off" checked>
                <h1>Classic</h1>
                <hr>
                <p>This login is executed after a redirection, which loads page<br> to do this action</p>
              </label>
              <label class="btn btn-outline-primary">
                <input type="radio" name="type" value="2" autocomplete="off">
                <h1>Modal</h1>
                <hr>
                <p>This login is executed in a modal within of the same page</p>
              </label>
            </div>
          </div>
        </div>
      </form>
    </div>
  @endif
@endsection

@push('scripts')
    <script type="text/javascript">
      var page;
      $(document).ready(function() {
        // Set firts step configuration 
        nextStep(1);
        var first_step = (configurations[0].value) ? JSON.parse(configurations[0].value) : null;
        if (first_step) {
          first_step.columns.forEach(function(column) {
            $(`#column-${column}`).prop('checked', true);
            $('.column-select').append(`<option value="${column}">${column}</option>`);
          });
          $(`#primary-column option[value=${first_step.username}]`).attr('selected', 'selected');
          $(`#password-column option[value=${first_step.password}]`).attr('selected', 'selected');
        }
      

        $('.column-check').change(function(event) {
          if( $(this).prop('checked') ) {
              $('.column-select').append(`<option value="${$(this).val()}">${$(this).val()}</option>`);
          }else{
            $(`option[value="${$(this).val()}"]`).remove();
          }
        });

        $("#btn-next").click(function(event) {
          /* Act on the event */
          var current_step = $(".status-steps.current").children('.list-steps');
          var panel = $($(current_step).attr('href'));
          var form = $(panel).children('form');
          var step =  parseInt($(current_step).attr('data-step'));
          var url = $(form).attr("action");
          var data = $(form).serialize();

          if (step == 1 && $('#primary-column').val() == $('#password-column').val()) {
            alert('The primary columns can not be the same');
            return false;
          }          

          ajaxProcess(url, data, function(output){
            if (output.is_error) {
              alert(output.result);
            }else{
              steps[step] = output.result.value;
              // Add configuration if it already exists
              if (steps[step+1]) {
                var step_config = JSON.parse(steps[step+1]);
                switch (step+1){
                  case 2:
                    //
                  break;

                  case 3:
                  case 5:
                  case 7:
                    // Select page selected
                    $(`#select-page-input option[value=${step_config.page}]`).attr('selected', 'selected');
                  break;

                }
              }

              // Add elements to view 
              if (step == 3 || step == 5 || step == 7) {
                page = (output.result.value) ? JSON.parse(output.result.value).page : null;
                if (page != null && page > 0) {
                  loadEditor(page);

                  editor.on('storage:load', function(e) {
                    switch (step) {
                      case 3:
                        // Add login element if not exit
                        if (!steps[4]) {
                          var domComponents = editor.DomComponents;
                          var login = domComponents.addComponent({
                            tagName: 'div',
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                            style: {
                              'width': '50%',
                              'padding': '1rem'
                            }
                          });
                          var formLogin = login.get('components').add({
                            type: 'form',
                            tagName: 'form',
                            attributes: {
                              action: '{{ route('authentication.login') }}',
                              method: 'post',
                            },
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                          });

                          formLogin.get('components').add({
                            type: 'text',
                            content: 'Sign In With!', // Text inside component
                            attributes: { title: 'Sign In With!'},
                            style: {
                              'font-size': '30px',
                              'border-bottom': '10px'
                            }
                          });

                          var inputs;
                          var dataStep = JSON.parse(steps[1]);
                          var username = dataStep.username;
                          var password = dataStep.password;
                          var label;

                          label = username.charAt(0).toUpperCase() + username.slice(1).toLowerCase();
                          inputs = formLogin.get('components').add({
                            tagName: 'div',
                            style: { 
                              'margin-bottom': '1rem',
                            }
                          });

                          inputs.get('components').add([
                            {
                              type: 'text',
                              content: label,
                              attributes: { 
                                for: 'input-'+username
                              },
                            },
                            {
                              tagName: 'input',
                              type: 'text',
                              attributes: { 
                                id: 'input-'+username,
                                name: username,
                                type: 'text'
                              },
                              style: { 
                                'width': '100%',
                                'height': 'calc(1.5em + 0.75rem + 2px)',
                                'padding': '0.375rem 0.75rem',
                                'font-size': '1rem',
                                'font-weight': '400',
                                'line-height': '1.5',
                                'color': '#495057',
                                'background-color': '#fff',
                                'background-clip': 'padding-box',
                                'border': '1px solid #ced4da',
                                'border-radius': '0.25rem',
                                'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
                              }
                            },
                          ]);

                          label = password.charAt(0).toUpperCase() + password.slice(1).toLowerCase();
                          inputs = formLogin.get('components').add({
                            tagName: 'div',
                            style: { 
                              'margin-bottom': '1rem',
                            }
                          });

                          inputs.get('components').add([
                            {
                              type: 'text',
                              content: label,
                              attributes: { 
                                for: 'input-'+password
                              },
                            },
                            {
                              tagName: 'input',
                              type: 'text',
                              attributes: { 
                                id: 'input-'+password,
                                name: password,
                                type: 'password'
                              },
                              style: { 
                                'width': '100%',
                                'height': 'calc(1.5em + 0.75rem + 2px)',
                                'padding': '0.375rem 0.75rem',
                                'font-size': '1rem',
                                'font-weight': '400',
                                'line-height': '1.5',
                                'color': '#495057',
                                'background-color': '#fff',
                                'background-clip': 'padding-box',
                                'border': '1px solid #ced4da',
                                'border-radius': '0.25rem',
                                'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
                              }
                            },
                          ]);
                      
                          formLogin.get('components').add({
                            tagName: 'button',
                            type: 'submit',
                            attributes: {
                              type: 'submit',
                            },
                            content: 'Sign in',
                            style: { 
                              'color': '#fff',
                              'background-color': '#007bff',
                              'border-color': '#007bff',
                              'display': 'inline-block',
                              'font-weight': '400',
                              'text-align': 'center',
                              'vertical-align': 'middle',
                              '-webkit-user-select': 'none',
                              '-moz-user-select': 'none',
                              '-ms-user-select': 'none',
                              'user-select': 'none',
                              'border': '1px solid transparent',
                              'padding': '0.375rem 0.75rem',
                              'font-size': '1rem',
                              'line-height': '1.5',
                              'border-radius': '0.25rem',
                              'transition': 'color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
                            }
                          });
                        }
                        // End if validate
                      break;

                      case 5:
                        // Add login element if not exit
                        if (!steps[6]) {
                          var domComponents = editor.DomComponents;
                          var logout = domComponents.addComponent({
                            tagName: 'div',
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                            style: {
                              'width': '50%',
                              'padding': '1rem'
                            }
                          });

                          var formLogout = logout.get('components').add({
                            type: 'form',
                            tagName: 'form',
                            attributes: {
                              action: '{{ route('authentication.logout') }}',
                              method: 'post',
                            },
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                          });

                          formLogout.get('components').add({
                            tagName: 'button',
                            type: 'submit',
                            attributes: {
                              type: 'submit',
                            },
                            content: 'Logout',
                          });

                        }
                        // End if validate
                      break;

                      case 7:
                        // Add login element if not exit
                        if (!steps[8]) {
                          var domComponents = editor.DomComponents;
                          var register = domComponents.addComponent({
                            tagName: 'div',
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                            style: {
                              'width': '50%',
                              'padding': '1rem'
                            }
                          });

                          var formRegister = register.get('components').add({
                            type: 'form',
                            tagName: 'form',
                            attributes: {
                              action: '{{ route('authentication.register') }}',
                              method: 'post',
                            },
                            removable: false, // Can't remove it
                            draggable: true, // Can't move it
                            copyable: false, // Disable copy/past
                          });

                          var inputs;
                          var dataStep = JSON.parse(steps[1]);
                          var columns = dataStep.columns;
                          var password = dataStep.password;
                          var label;

                          columns.forEach(function(column) {
                            label = column.charAt(0).toUpperCase() + column.slice(1).toLowerCase();
                            inputs = formRegister.get('components').add({
                              tagName: 'div',
                              style: { 
                                'margin-bottom': '1rem',
                              }
                            });
                            inputs.get('components').add([
                              {
                                type: 'text',
                                content: label,
                                attributes: { 
                                  for: 'input-'+column
                                },
                              },
                              {
                                tagName: 'input',
                                type: 'text',
                                attributes: { 
                                  id: 'input-'+column,
                                  name: column,
                                  type: (column != password) ? 'text' : 'password'
                                },
                                style: { 
                                  'width': '100%',
                                  'height': 'calc(1.5em + 0.75rem + 2px)',
                                  'padding': '0.375rem 0.75rem',
                                  'font-size': '1rem',
                                  'font-weight': '400',
                                  'line-height': '1.5',
                                  'color': '#495057',
                                  'background-color': '#fff',
                                  'background-clip': 'padding-box',
                                  'border': '1px solid #ced4da',
                                  'border-radius': '0.25rem',
                                  'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
                                }
                              },
                            ]);

                          });

                          formRegister.get('components').add({
                            tagName: 'button',
                            type: 'submit',
                            attributes: {
                              type: 'submit',
                            },
                            content: 'Register',
                          });

                        }
                        // End if validate
                      break;
                    }
                    

                  });

                }
              }

              // Save view in database
              if (step == 4 || step == 6 || step == 8) {
                editor.store();
              }

              nextStep(step+1);

            }
          });


        });

      });

    </script>
@endpush
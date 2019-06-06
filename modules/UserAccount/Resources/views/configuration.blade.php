@extends('extra.configurations')

@section('content')
  @if(!is_null($configurations) && count($configurations) > 0)
    <div class="tab-pane fade" id="config-variables" role="tabpanel">
      <form action="{{ route('useraccount.configuration.variables') }}" method="post">
        @csrf
        <input type="hidden" name="configuration" value="0">
        <p>1.- Assign dynamic variables</p>
        <div class="form-row">
          <div class="form-group col-md-3">
            <input id="variable-name" type="text" class="form-control" value="" placeholder="Name of variable">
          </div>
          <div class="form-group col-md-1">
            <label class="form-control-plaintext text-center text-primary">
              <i class="fas fa-angle-double-right"></i>
              <i class="fas fa-angle-double-right"></i>
            </label>
          </div>
          <div class="form-group col-md-3">
            <select id="variable-value" class="form-control">
              <option value="">Value of variable</option>
              @foreach($columns as $column)
                <option value="{{ $column }}">{{ $column }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-2 mr-3">
            <button id="add-variable" type="button" class="btn btn-primary"><i class="fas fa-plus"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-9">
            <table class="table table-sm">
              <tbody id="tbody-variables">
              </tbody>
            </table>
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
          /*
          first_step.columns.forEach(function(column) {
            $(`#column-${column}`).prop('checked', true);
            $('.column-select').append(`<option value="${column}">${column}</option>`);
          });
          $(`#primary-column option[value=${first_step.username}]`).attr('selected', 'selected');
          $(`#password-column option[value=${first_step.password}]`).attr('selected', 'selected');
          */
        }

        $("#add-variable").click(function(event) {
          /* Act on the event */
          if ($("#variable-name").val() != '' && $("#variable-value").val() != '') {
            $("#tbody-variables").append(`
              <tr>
                <th class="align-middle" style="width: 32.5%;">
                  ${$("#variable-name").val()}
                </th>
                <th class="align-middle text-center text-primary" style="width: 13%;">
                  <i class="fas fa-equals"></i>
                </th>
                <th class="align-middle" style="width: 32.5%;">
                  <input type="text" readonly class="form-control-plaintext" name="${$("#variable-name").val()}"  value="${$("#variable-value").val()}">
                </th>
                <th class="align-middle" style="width: 22%;">
                  <button type="button" class="btn btn-outline-danger ml-1"><i class="fas fa-trash-alt"></i></button>
                </th>
              </tr>
            `);
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
                    // Select page selected
                    $(`#select-page-input option[value=${step_config.page}]`).attr('selected', 'selected');
                  break;

                }
              }

              // Add elements to view 
              if (step == 2) {
                page = (output.result.value) ? JSON.parse(output.result.value).page : null;
                if (page != null && page > 0) {
                  loadEditor(page);

                  editor.on('storage:load', function(e) {  
                    // Add login element if not exit
                    if (!steps[3]) {
                      var domComponents = editor.DomComponents;
                      var account = domComponents.addComponent({
                        type: 'module',
                        module: 'UserAccount',
                        tagName: 'div',
                        removable: false, // Can't remove it
                        draggable: true, // Can't move it
                        copyable: false, // Disable copy/past
                        style: {
                          'padding': '1rem'
                        }
                      });

                      var row = account.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem'
                        }
                      });

                      row.addClass('row');

                      var leftColumn = row.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                          'border-radius': '0.25rem',
                          'border': '1px solid #dee2e6'
                        }
                      });

                      leftColumn.addClass('hk-md-3 hk-lg-3');


                      leftColumn.get('components').add({
                        tagName: 'br'
                      });

                      var userImage = leftColumn.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                          'text-align': 'center',
                          'margin-bottom': '1.5rem'
                        }
                      });

                      userImage.get('components').add({
                        type: 'image',
                        tagName: 'img',
                        attributes: {
                          'src': 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png'
                        },
                        style: {
                          'width': '80px',
                          'height': '80px',
                          'border-radius': '50%',
                          'border': '1px solid #6c757d',
                        }
                      });

                      var linkUser = leftColumn.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                          'display': '-ms-flexbox',
                          'display': 'flex',
                          '-ms-flex-direction': 'column',
                          'flex-direction': 'column',
                          'padding-left': '0',
                          'margin-bottom': '0',
                        }
                      });

                      linkUser.get('components').add({
                        type: 'link',
                        tagName: 'a',
                        attributes: {
                          'href': '#'
                        },
                        style: {
                          'position': 'relative',
                          'display': 'block',
                          'padding': '0.75rem 1.25rem',
                          'margin-bottom': '-1px',
                          'background-color': '#fff',
                          'border': '1px solid rgba(0, 0, 0, 0.125)',
                          'color': '#212529',
                          'background-color': '#e9ecef'
                        },
                        content: 'Account',
                      });

                      linkUser.get('components').add({
                        type: 'link',
                        tagName: 'a',
                        attributes: {
                          'href': '#'
                        },
                        style: {
                          'position': 'relative',
                          'display': 'block',
                          'padding': '0.75rem 1.25rem',
                          'margin-bottom': '-1px',
                          'background-color': '#fff',
                          'border': '1px solid rgba(0, 0, 0, 0.125)',
                          'color': '#212529',
                          'background-color': '#e9ecef'
                        },
                        content: 'Edit Profile',
                      });

                      var rightColumn = row.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                          'border-radius': '0.25rem',
                          'border': '1px solid #dee2e6'
                        }
                      });

                      rightColumn.addClass('hk-md-9 hk-lg-9');

                      var title = rightColumn.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                          'border-bottom': '1px solid #dee2e6'
                        }
                      });

                      title.get('components').add({
                        tagName: 'h1',
                        content: 'Account',
                      });

                      var userContent = rightColumn.get('components').add({
                        tagName: 'div',
                        style: {
                          'padding': '1rem',
                        }
                      });

                      var dataStep = JSON.parse(steps[1]);
                      var label;

                      Object.entries(dataStep).forEach(([key, value]) => {
                        label = key.toLowerCase();
                        userContent.get('components').add({
                          tagName: 'label',
                          content: label+' :',
                        });
                        userContent.get('components').add({
                          type: 'variable',
                          content: '${'+label+'}',
                          removable: false,
                          copyable: false,
                        });

                      });

                      var btnEdit = userContent.get('components').add({
                        tagName: 'a',
                        content: 'Edit Profile',
                        attributes: {
                          'href': '#',
                          'role': 'button',
                        },
                      });

                      btnEdit.addClass('btn btn-secondary btn-sm');              
                      
                    }
                    // End if validate
                  });

                }
              }

              // Save view in database
              if (step == 3) {
                editor.store();
              }

              nextStep(step+1);

            }
          });


        });

      });

    </script>
@endpush
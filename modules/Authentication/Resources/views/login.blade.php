@extends('extra.configurations')

@section('content')
  @foreach($configurations as $configuration)
    <div class="tab-pane fade {{ $configuration->step == 1 ? 'show active' : '' }}" id="configuration-{{ $configuration->step }}" role="tabpanel" aria-labelledby="{{ $configuration->name }}">
      <p>Step description: {{ $configuration->description }}</p>
      @switch($configuration->step)
        @case(1)
            <form id="config-form-{{ $configuration->step }}" class="database-form" action="{{ route('configuration.database') }}" method="post" url-validator="{{ route('authentication.ajax.validator') }}">
              {{ csrf_field() }}
              <input type="hidden" name="configuration" value="{{ $configuration->id }}">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="input-columns">1.- Select columns to login</label>
                  @foreach($columns as $column)
                    <div class="custom-control custom-checkbox">
                      @if(isset(json_decode($configuration->value)->columns))
                        <input type="checkbox" class="column-check custom-control-input" name="columns[]" id="column-{{ $column }}" value="{{ $column }}" {{ (in_array($column, json_decode($configuration->value)->columns)) ? 'checked' : '' }}>
                      @else
                        <input type="checkbox" class="column-check custom-control-input" name="columns[]" id="column-{{ $column }}" value="{{ $column }}">
                      @endif
                      <label class="custom-control-label" for="column-{{ $column }}">{{ $column }}</label>
                    </div>
                  @endforeach
                </div>
                <div class="form-group col-md-8">
                  <label class="mb-2">2.- Select import columns</label>
                  <div class="mb-4">
                    <label>Select primary column</label>
                    <select id="primary-column" class="form-control column-select" name="username">
                      @if(!is_null($configuration->value))
                        @foreach(json_decode($configuration->value)->columns as $column)
                          <option value="{{ $column }}" {{ ($column === json_decode($configuration->value)->username) ? 'selected' : ''}}>{{ $column }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="mb-4">
                    <label>Select password column</label>
                    <select id="password-column" class="form-control column-select" name="password">
                      @if(!is_null($configuration->value))
                        @foreach(json_decode($configuration->value)->columns as $column)
                          <option value="{{ $column }}" {{ ($column === json_decode($configuration->value)->password) ? 'selected' : ''}}>{{ $column }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
            </form>
            @break

        @case(2)
            <form id="config-form-{{ $configuration->step }}" action="{{ route('configuration.type.login') }}" method="post" url-data="{{ route('authentication.ajax.configurations') }}">
              {{ csrf_field() }}
              <input type="hidden" name="configuration" value="{{ $configuration->id }}">
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
            @break

        @case(3)
            <form id="config-form-{{ $configuration->step }}" action="{{ route('configuration.page') }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="configuration" value="{{ $configuration->id }}">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="input-tables">Select page</label>
                  <select id="input-tables" class="custom-select" name="page" size="8">
                    @foreach($pages as $page)
                      @if(isset(json_decode($configuration->value)->page))
                        <option value="{{ $page->id }}" {{ ($page->id == json_decode($configuration->value)->page) ? 'selected' : ''}}>{{ $page->name }}</option>
                      @else
                        <option value="{{ $page->id }}">{{ $page->name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </form>
            @break

        @case(4)
            <form id="config-form-{{ $configuration->step }}" action="{{ route('configuration.design.login') }}" method="post" url-data="{{ route('authentication.ajax.loginPage') }}">
              {{ csrf_field() }}
              <input type="hidden" name="configuration" value="{{ $configuration->id }}">
              <div id="editor" style="max-height: 360px;"></div>
            </form>
            @break
      @endswitch
    </div>
  @endforeach
  <script type="text/javascript">
    var formLogin;
    $(document).ready(function() {
      
      $('.column-check').change(function(event) {
        if( $(this).prop('checked') ) {
            $('.column-select').append(`<option value="${$(this).val()}">${$(this).val()}</option>`);
        }else{
          $(`option[value="${$(this).val()}"]`).remove();
        }
      });

      $(".btn-next").click(function(event) {
        /* Act on the event */
        var form = $(".nav-link.active").attr("form-submit");
        var step = form.split('-')[2];
        var url = $("#"+form).attr("action");
        var data = $("#"+form).serialize();

        if (step == 1 && $('#primary-column').val() == $('#password-column').val()) {
          alert('The primary columns can not be the same');
          return false;
        }
        ajaxProcess(url, data, function(output){
          if (output.is_error) {
            alert(output.result);
          }else{
            nextStep(step);
          }
        });

      });

      /*
        Estas funciones shown.bs.tab se deben cambiar ya que no son dinamicas por lo cual se deberan crear variables javascript estaticas las cuales se deberan ir actualziando siempre que haya algun cambio en el controlador del modulo por ejemplo una variable configuraciones las cual se va ir actualizando con los valores que se vallan registrando en los pasos y por cada cambio se debera aplicar la actualizacion
      */

      $('a[id="step-2"]').on('shown.bs.tab', function (e) {
        var form = $(".nav-link.active").attr("form-submit");
        var urlData = $("#"+form).attr("url-data");
        var data = $("#"+form).serialize();
        ajaxProcess(urlData, data, function(output){
          if (output.is_error) {
            alert(output.result);
          }else{
            var columns = JSON.parse(output.result[1]).columns;
            columns.forEach(function(column) {
              $("#primary-column").append((column == 'email') ? "<option value='"+column+"' selected>"+column+"</option>" : "<option value='"+column+"'>"+column+"</option>");
              $("#password-column").append((column == 'password') ? "<option value='"+column+"' selected>"+column+"</option>" : "<option value='"+column+"'>"+column+"</option>");
            });
          }
        });

      });

      $('a[id="step-4"]').on('shown.bs.tab', function (e) {
        var form = $(".nav-link.active").attr("form-submit");
        var urlData = $("#"+form).attr("url-data");
        var data = $("#"+form).serialize();
        ajaxProcess(urlData, data, function(output){
          if (output.is_error) {
            alert(output.result);
          }else{
            loadEditor(output.result);
          }
        });

      });



    });

    function ajaxProcess(url, data, handleData) {
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success:function(value){
          handleData(value);
        }
      })
      .fail(function(jqXHR, textStatus, errorThrown ){
        alert(textStatus);
        //$("#alert-error-login").append('<p class="text-danger">'+textStatus+'</p>');
      });
    };

    function nextStep(current){

      var next = parseInt(current) + 1;

      if (!$("#step-"+(next + 1)).length) {
        $('.btn-next').text('Finish');
      }
      if ($("#step-"+next).length) {

        if ($("#step-"+next).hasClass('disabled')) {

          $("#step-"+next).removeClass('disabled');

        }

        $("#step-"+next).tab("show");

      }else{

        alert('Successfully configured module');

      }
    };

    function loadEditor(steps){
      var page = JSON.parse(steps[3]);
      var configurate = JSON.parse(steps[4]);
      var builder = (page.builder != '') ? page.builder : '[]'; // Get configurate page
      var images = (builder["gjs-assets"] && builder["gjs-assets"] != '[]') ? builder["gjs-assets"] : [] ; // This variable storage images that user load in this page
      var token = "{{ csrf_token() }}";
      var editor = grapesjs.init({
        typeEditor: 'Module',
        module: 'authentication',
        fromElement: 1,
        clearOnRender: true,
        container: '#editor',
        storageManager: {
          autosave: false,
          setStepsBeforeSave: 1,
          type: 'remote',
          urlStore: '/admin/editor/store/' + page.id, // Url where we storage page in db
          urlLoad: '/admin/editor/' + page.id + '/load', // Url where we load page
          contentTypeJson: true,
          params: { _token:token },
        },

        assetManager: {
          assets: images,
          storeOnChange : true,
          storeAfterUpload : true,
          upload: '/admin/editor/store/images/' + page.id,
          uploadName: 'images',
          params: { _token:token, enctype:'multipart/form-data', action:'add' },
          autoAdd: 1,
        },

      });

      @if(count($elements) > 0)
        // If exist elements in db we load to block manager 
        var blockManager = editor.BlockManager;
        @foreach($elements as $element)
          blockManager.add("{{ $element->name }}", {
            label: "{{ $element->label }}",
            category: "Element",
            attributes: {!! $element->attributes !!},
            content: {!! $element->content !!}
          });
        @endforeach
      @endif

      var pn = editor.Panels;
      var modal = editor.Modal;
      var cmdm = editor.Commands;
      var assets = editor.AssetManager.getAll();

      assets.on('remove', function(asset) {
        var removefile = asset.get('src');
        $.ajax({
        url: '/admin/editor/store/images/' +e.id,
        type: 'POST',
        data: { file:removefile, _token:token, action:'remove', enctype:'multipart/form-data' },
        success: function(response){
          assets.remove(asset.get('src'));
        }
        });

      });


      // Add save button in the top Panel
      pn.addButton('options',[{
        id: 'save-db',
        className: 'fa fa-floppy-o',
        command: 'save-db',
        attributes: {title: 'Save'}
      }]);

      // Add action to save button
      cmdm.add('save-db', {
        run: function(editor, sender){
          sender && sender.set('active');
          var comModule = formLogin.getAttributes();
          delete comModule.onsubmit;
          formLogin.setAttributes(comModule);
          editor.store();
        }
      });

      cmdm.add('set-device-desktop', {
        run: ed => ed.setDevice('Desktop'),
        stop() {},
      });
      cmdm.add('set-device-tablet', {
        run: ed => ed.setDevice('Tablet'),
        stop() {},
      });
      cmdm.add('set-device-mobile', {
        run: ed => ed.setDevice('Mobile portrait'),
        stop() {},
      });

      pn.removeButton("options", ["export-template", "gjs-toggle-images", "gjs-open-import-template"]);

      editor.on('storage:store', function(e) {
        var form = $(".nav-link.active").attr("form-submit");
        var step = form.split('-')[2];
        var url = $("#"+form).attr("action");
        var data = $("#"+form).serialize();

        ajaxProcess(url, data, function(output){
         
          if (output.is_error) {
            alert(output.result);
          }else{
            nextStep(step);
          }
        });
        //console.log('Stored ', e);
      });

      editor.on('storage:load', function(e) {
        // Add login element if not exit
        if (!configurate) {
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

          formLogin = login.get('components').add({
            type: 'form',
            tagName: 'form',
            attributes: {
              action: '{{ route('authentication.login') }}',
              method: 'post',
              onsubmit: 'return false;',
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
          var columns = dataStep.columns;
          var password = dataStep.password;
          var label;

          columns.forEach(function(column) {
            label = column.charAt(0).toUpperCase() + column.slice(1).toLowerCase();
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

      });

    };

  </script>
@endsection
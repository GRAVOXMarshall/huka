@extends('back.index')

@section('dash-content')
    <div class="row">
      <div class="col-2 side-content">
        <div class="step-vertical-menu" role="tablist">
          <ul>
            @if(!is_null($configurations) && count($configurations) > 0)
              @foreach($configurations as $configuration)
                <li class="status-steps {{ ($configuration->step != 1 && !is_null($configuration->value)) ? 'complete' : '' }} {{ ($configuration->step == 1) ? 'current' : '' }} {{ ($configuration->step != 1 && is_null($configuration->value)) ? 'locked' : '' }}" >
                  <a class="list-steps" data-step="{{ $configuration->step }}" data-toggle="list" href="#{{ $configuration->type }}" role="tab">{{ $configuration->step.'- '.$configuration->name }} <span class="icon-step">{!! (($configuration->step != 1 && !is_null($configuration->value)) ? '<i class="ico fa fa-check ico-green"></i>' : '').(($configuration->step != 1 && is_null($configuration->value)) ? '<i class="ico fa fa-lock ico-muted"></i>' : '') !!}</span>
                  <span class="desc">{{ $configuration->description }}</span>
                  </a>
                </li>
              @endforeach
            @endif
          </ul>
        </div>
      </div>
      <div class="col-10">
        <div id="configuration-content" style="min-height: 400px;">
          <div class="card mb-2">
            <div class="row card-body">
              <div class="col-12 tab-content" id="step-content" style="min-height: 420px;">
                @if(Route::has(strtolower($module->name).'.configuration.page'))
                  <div class="tab-pane fade" id="select-page" role="tabpanel">
                    <form action="{{ route(strtolower($module->name).'.configuration.page') }}" method="post">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label class="mr-3">Add content to: </label>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="page-option" class="custom-control-input content-page" name="content_option" value="page">
                            <label class="custom-control-label" for="page-option">Page</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="layout-option" class="custom-control-input content-page" name="content_option" value="layout">
                            <label class="custom-control-label" for="layout-option">Layout</label>
                          </div>
                        </div>
                      </div>
                      <div id="select-page-content" class="form-row">
                        <div class="form-group col-md-12">
                          <label for="select-page-input">Select page</label>
                          <select id="select-page-input" class="custom-select" name="page" size="8">
                            @if(isset($pages) && count($pages) > 0)
                              @foreach($pages as $page)
                                <option value="{{ $page->id }}" type-page="{{ $page->type }}">{{ $page->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div id="select-layout-content" class="form-row">
                        <div class="form-group col-md-12">
                          <label for="select-layout-input">Select layout</label>
                          <select id="select-layout-input" class="custom-select" name="layout" size="8">
                            @if(isset($layouts) && count($layouts) > 0)
                              @foreach($layouts as $layout)
                                <option value="{{ $layout->id }}">{{ $layout->name }}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                @endif
                @if(Route::has(strtolower($module->name).'.configuration.design'))
                  <div class="tab-pane fade" id="design-page" role="tabpanel">
                    <form action="{{ route(strtolower($module->name).'.configuration.design') }}" method="post">
                      @csrf
                      <div class="panel__top">
                        <div class="panel__devices"></div>
                        <div class="panel__options"></div>
                        <div class="panel__switcher"></div>
                      </div>
                      <div class="editor-row">
                        <div class="editor-canvas">
                          <div class="editor"></div>
                        </div>
                        <div class="panel__right">
                          <div class="layers-container"></div>
                          <div class="styles-container"></div>
                          <div class="elements-container"></div>
                        </div>
                      </div>
                    </form>
                  </div>
                @endif
                @yield('content')
              </div>
            </div>
          </div>
          <div class="row justify-content-between">
            <div class="col-6 text-left">
              <button type="button" class="btn btn-primary">Previous</button>
            </div>
            <div class="col-6 text-right">
              <button id="btn-next" type="button" class="btn btn-primary">Next</button>
            </div>
          </div>
        </div>
        <div id="configuration-ready" style="display: none;">
          <h1>Successfully configured module</h1>
        </div>
      </div>
    </div>

    @push('extra_scripts')

      <script type="text/javascript">
        var editor;
        var domComponents;
        let steps = @json($steps);
        let configurations = @json($configurations);
        // These pages are getting through the controller and only get pages corresponding to selected type are set
        const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
        
        // Show first step to configure module

        function nextStep(step){

          var lists = document.getElementsByClassName('status-steps');
          var find_step = false;
          Array.prototype.forEach.call(lists, list => {
            var elements = list.childNodes;
            var content;
            var new_content;
            var elements_child;
            var exist_input;
            Array.prototype.forEach.call(elements, element => {
              if (element.className == 'list-steps') {
                content = document.getElementById(element.getAttribute('href').slice(1));
                // Deactivate current panel 
                if (list.classList.contains('current')) {
                  list.classList.remove('current');
                  if (content.classList.contains('show')) {
                    content.classList.remove('show');
                  }
                  if (content.classList.contains('active')) {
                    content.classList.remove('active');
                  }
                  if (!list.classList.contains('complete')) {
                    list.classList.add('complete');
                    // Add icon 
                    Array.prototype.forEach.call(element.childNodes, child => {
                      if (child.className == 'icon-step') {
                        child.innerHTML = '<i class="ico fa fa-check ico-green"></i>';
                      }
                      
                    });
                  
                  }
                }

                // Active new configuration panel
                if (element.getAttribute('data-step') == step) {

                  find_step = true;

                  if (!content.classList.contains('show')) {
                    content.classList.add('show');
                  }
                  if (!content.classList.contains('active')) {
                    content.classList.add('active');
                  }

                  if (list.classList.contains('complete')) {
                    list.classList.remove('complete');
                  }
                  if (list.classList.contains('locked')) {
                    list.classList.remove('locked');
                  }

                  if (!list.classList.contains('current')) {
                    list.classList.add('current');
                    // Remove icon
                    Array.prototype.forEach.call(element.childNodes, child => {
                      if (child.className == 'icon-step') {
                        child.innerHTML = '';
                      }
                      
                    });

                  }

                  // Add input configuration or change value of this input
                  elements_child = content.childNodes;

                  Array.prototype.forEach.call(elements_child, child => {
                    if (child.tagName && (child.tagName).toLowerCase() == 'form') {
                      exist_input = false;
                      var config_input;
                      Array.prototype.forEach.call(child, input => {
                        if (input.getAttribute('name') == 'configuration') {
                          exist_input = true;
                          config_input = input;
                        }
                      });
                      var config_id = 0;
                      Array.prototype.forEach.call(configurations, config => {
                        if (config.step == step) {
                          config_id = config.id;
                        }
                      });
                      if (exist_input) {
                        config_input.value = config_id;
                      }else{
                        config_input = document.createElement("input");
                        config_input.setAttribute("type", "hidden");
                        config_input.setAttribute("name", "configuration");
                        config_input.setAttribute("value", config_id);
                        child.appendChild(config_input);
                      }

                    }
                    
                  });

                }

              }

            });

          });

          if (!find_step) {
            document.getElementById("configuration-content").style.display = "none";
            document.getElementById("configuration-ready").style.display = "block";
            window.location.replace("/admin/dashboard/products/modules");
          }

          var next_button = document.getElementById('btn-next');
          if (Object.keys(steps).length == step) {
            next_button.innerHTML = 'Finish';
          }else if(next_button.innerHTML == 'Finish'){
            next_button.innerHTML = 'Next';
          }
          
        };

        function loadEditor(page, option = 'page'){
          var urlStore = '';
          var urlLoad = '';
          switch(option){
            case 'page':
              urlStore = '/admin/editor/store/' + page;
              urlLoad = '/admin/editor/' + page + '/load';
            break;

            case 'layout':
              urlStore = '/admin/dashboard/layouts/edit/design/store/' + page;
              urlLoad = '/admin/dashboard/layouts/edit/design/' + page + '/load';
            break;
          }
          if (!editor) {
            // grapesjs.init will load the editor with the corresponding configuration
            editor = grapesjs.init({
              // Set assigned template
              canvas: {
                styles: [
                  '{{ asset("css/bootstrap-new.css") }}',
                ]
              },
              fromElement: 1,
              clearOnRender: true,
              height: '400px',
              // Select container of editor
              container  : '.editor',
              // Config the storege and load page

              storageManager: {
                autosave: false,
                setStepsBeforeSave: 1,
                type: 'remote',
                urlStore: urlStore, // Url where we storage page in db
                urlLoad: urlLoad, // Url where we load page
                contentTypeJson: true,
                params: { _token:token },
              },
              // Config storage of images
              assetManager: {
                assets: [
                  @foreach($images as $image)
                    {
                      "type":"image",
                      "src":"{{ $image->src }}",
                      "unitDim":"px",
                      "height":350,
                      "width":250,
                      "name":["{{ $image->name }}"]
                    },
                  @endforeach
                ],
                storeOnChange : true,
                storeAfterUpload : true,
                upload: '{{ route('storage.images') }}', // Url where we load images
                uploadName: 'images',
                params: { _token:token, enctype:'multipart/form-data', action:'add' },
                autoAdd: 1,
              },

              layerManager: {
                appendTo: '.layers-container'
              },
              // Avoid any default panel
              panels: {
                defaults: [
                  {
                    id: 'layers',
                    el: '.panel__right',
                    // Make the panel resizable
                    resizable: {
                      maxDim: 250,
                      minDim: 150,
                      tc: 0, // Top handler
                      cl: 1, // Left handler
                      cr: 0, // Right handler
                      bc: 0, // Bottom handler
                      // Being a flex child we need to change `flex-basis` property
                      // instead of the `width` (default)
                      keyWidth: 'flex-basis',
                    },
                  },

                  {
                    id: 'panel-switcher',
                    el: '.panel__switcher',
                    buttons: [
                      {
                        id: 'show-layers',
                        active: true,
                        label: '<i class="fas fa-layer-group"></i>',
                        command: 'show-layers',
                        // Once activated disable the possibility to turn it off
                        togglable: false,
                      },

                      {
                        id: 'show-style',
                        active: true,
                        label: '<i class="fas fa-paint-brush"></i>',
                        command: 'show-styles',
                        togglable: false,
                      },

                      {
                        id: 'show-elements',
                        active: true,
                        label: '<i class="fas fa-puzzle-piece"></i>',
                        command: 'show-elements',
                        togglable: false,
                      },

                    ],
                  },

                  {
                    id: 'panel-devices',
                    el: '.panel__devices',
                    buttons: [
                      {
                        id: 'device-desktop',
                        active: true,
                        label: '<i class="fas fa-desktop"></i>',
                        command: 'set-device-desktop',
                        togglable: false,
                      },

                      {
                        id: 'device-mobile',
                        active: true,
                        label: '<i class="fas fa-mobile-alt"></i>',
                        command: 'set-device-mobile',
                        togglable: false,
                      }

                    ],
                  },

                  {
                    id: 'panel-options',
                    el: '.panel__options',
                    buttons: [
                      {
                        id: 'visibility',
                        active: true, // active by default
                        className: 'btn-toggle-borders',
                        label: '<i class="fas fa-vector-square"></i>',
                        command: 'sw-visibility', // Built-in command
                      },
                    ],
                  }

                ]
              },
              
              // Set default styles manager 
              styleManager: {
                appendTo: '.styles-container',
                sectors: [
                  {
                    name: 'General',
                    open: false,
                    buildProps: ['display', 'position', 'top', 'right', 'left', 'bottom']
                  },

                  {
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self']
                  },

                  {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding']
                  },

                  {
                  name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-shadow'],
                    properties: [
                      {
                      property: 'text-align',
                      list: [{ value: 'left', className: 'fa fa-align-left' }, { value: 'center', className: 'fa fa-align-center' }, { value: 'right', className: 'fa fa-align-right' }, { value: 'justify', className: 'fa fa-align-justify' }]
                      }
                    ]
                  },

                  {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background']
                  },

                ]
              },

              // Set default elements
              blockManager: {
                appendTo: '.elements-container',
                blocks: [
                  // These elements getting through the controller and only get active
                  @if(count($elements) > 0)
                    @foreach($elements as $element)
                      {
                        id: '{{ $element->name }}', 
                        label: '{{ $element->label }}',
                        attributes: { class:'gjs-block-section' },
                        category: 'Element',
                        attributes: {!! $element->attributes !!},
                        content: {!! $element->content !!} // Content can be String or JSON
                      },
                    @endforeach
                  @endif
                ]
              },

              // Set default devices manager
              deviceManager: {
                devices: [
                  {
                    name: 'Desktop',
                    width: '', // default size
                  }, 

                  {
                    name: 'Mobile',
                    width: '320px', // this value will be used on canvas width
                    widthMedia: '480px', // this value will be used in CSS @media
                  }
                ]
              },

            }); // End editor init
            
            domComponents = editor.DomComponents;
            var pn = editor.Panels;
            var modal = editor.Modal;
            var cmdm = editor.Commands;
            var assets = editor.AssetManager.getAll();
            // Add extra panel to editor
            pn.addPanel({
              id: 'panel-top',
              el: '.panel__top',
            });

            // Define commands
            cmdm.add('show-layers', {
              getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
              getLayersEl(row) { return row.querySelector('.layers-container') },

              run(editor, sender) {
                const lmEl = this.getLayersEl(this.getRowEl(editor));
                lmEl.style.display = '';
              },

              stop(editor, sender) {
                const lmEl = this.getLayersEl(this.getRowEl(editor));
                lmEl.style.display = 'none';
              }
            });

            cmdm.add('show-styles', {
              getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
              getStyleEl(row) { return row.querySelector('.styles-container') },

              run(editor, sender) {
                const smEl = this.getStyleEl(this.getRowEl(editor));
                smEl.style.display = '';
              },

              stop(editor, sender) {
                const smEl = this.getStyleEl(this.getRowEl(editor));
                smEl.style.display = 'none';
              }
            });

            cmdm.add('show-elements', {
              getRowEl(editor) { return editor.getContainer().closest('.editor-row'); },
              getStyleEl(row) { return row.querySelector('.elements-container') },

              run(editor, sender) {
                const smEl = this.getStyleEl(this.getRowEl(editor));
                smEl.style.display = '';
              },

              stop(editor, sender) {
                const smEl = this.getStyleEl(this.getRowEl(editor));
                smEl.style.display = 'none';
              }
            });

            cmdm.add('set-device-desktop', {
              run(editor, sender) {
                editor.setDevice('Desktop');
                sender.set('active', true);
              },

              stop(editor, sender) {
                sender.set('active', false);
              }
            });

            cmdm.add('set-device-mobile', {
              run(editor, sender) {
                editor.setDevice('Mobile');
                sender.set('active', true);
              },

              stop(editor, sender) {
                sender.set('active', false);
              }
            });

            // Function to remove images
            assets.on('remove', function(asset) {
              var removefile = asset.get('src');
              $.ajax({
                url: '/admin/editor/store/images',
                type: 'POST',
                data: { file:removefile, _token:token, action:'remove', enctype:'multipart/form-data' },
                success: function(response){
                  if (response.error) {
                    console.log(response.message);
                  }else{
                    assets.remove(asset.get('src'));
                  }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  alert("Status: " + textStatus);
                  alert("Error: " + errorThrown); 
                }  
              });

            });

            // Define traits to elements
            editor.DomComponents.addType('buttonLarge', {
              model: {
                defaults: {
                  traits: [
                    // Trait to button element
                    { 
                      type: 'select', 
                      label: 'Color/Size', 
                      name: 'class', 
                      options: [
                        { value: '', name: 'Default' },
                        { value: 'btn-primary', name: 'Primary' },
                        { value: 'btn-primary form-control', name: 'Primary Large' },
                        { value: 'btn-secondary', name: 'Secondary' },
                        { value: 'btn-secondary form-control', name: 'Secondary Large' },
                        { value: 'btn-success', name: 'Success' },
                        { value: 'btn-success form-control', name: 'Success Large' },
                        { value: 'btn-info', name: 'Info' },
                        { value: 'btn-info form-control', name: 'Info Large' },
                        { value: 'btn-warning', name: 'Warning' },
                        { value: 'btn-danger', name: 'Danger' },
                        { value: 'btn-dark', name: 'Dark' },
                        { value: 'btn-outline-primary', name: 'Outline-primary' },
                        { value: 'btn-outline-secondary', name: 'Outline-secondary' },
                        { value: 'btn-outline-success', name: 'Outline-success' },
                        { value: 'btn-outline-info', name: 'Outline-info' },
                        { value: 'btn-outline-warning', name: 'Outline-warning' },
                        { value: 'btn-outline-warning form-control', name: 'Outline-warning Large' },
                        { value: 'btn-outline-danger', name: 'Outline-danger' },
                        { value: 'btn-outline-danger form-control', name: 'Outline-danger Large' },
                        { value: 'btn-outline-dark', name: 'Outline-dark' }, 
                        { value: 'btn-link', name: 'Link' }  
                      ] 
                    }, 

                  ]
                }
              }
            });

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

          }else{
            var current_url = editor.StorageManager.get('remote').get('urlStore');
            var current_page = current_url.split('/')[4];
            if (page != current_page) {
              // Change urls to load and store
              editor.StorageManager.get('remote').set({
                urlStore: urlStore, 
                urlLoad: urlLoad
              });

              editor.DomComponents.clear(); // Clear components
              editor.CssComposer.clear();  // Clear styles
              editor.UndoManager.clear(); // Clear undo history
              
              // Load page to editor
              editor.load();  
            }
            
          }

        } // End function

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
            console.log(jqXHR);
            alert(textStatus);
            //$("#alert-error-login").append('<p class="text-danger">'+textStatus+'</p>');
          });
        };
        
        $(document).on('click', '.list-steps', function(e) {
          var current = $('.current').children('.list-steps');
          if (current && $(current).attr('data-step') != $(this).attr('data-step')) {
            var last_step = parseInt($(this).attr('data-step')) - 1;
            if (last_step > 0 && steps[last_step]) {
              nextStep($(this).attr('data-step'));
            }
          }
          
        });

        $(document).on('change', '.content-page', function(e) {

          var value = $('input:radio[name=content_option]:checked').val();

          if (value == 'page') {
            $('#select-layout-content').hide('slow/400/fast');
            $('#select-page-content').show('slow/400/fast');
          }else if(value == 'layout'){
            $('#select-page-content').hide('slow/400/fast');
            $('#select-layout-content').show('slow/400/fast');
          }

        });

      </script>

      @stack('scripts')

    @endpush

@endsection

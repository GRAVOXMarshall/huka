<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Huka Editor</title> 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
      body,

      html {
        height: 100%;
        margin: 0;
        overflow: hidden;
      }

      /* Theming */

      /* Primary color for the background */
      .gjs-one-bg {
        background-color: #363E46;
      }

      /* Secondary color for the text color */
      .gjs-two-color {
        color: rgba(246, 246, 246, 1);
      }

      /* Tertiary color for the background */
      .gjs-three-bg {
        background-color: #FC9627;
        color: white;
      }

      /* Quaternary color for the text color */
      .gjs-four-color,
      .gjs-four-color-h:hover {
        color: #FC9627;
      }

      /* Reset some default styling */
      .gjs-cv-canvas {
        top: 0;
        width: 100%;
        height: 100%;
      }
      .panel__top {
        padding: 0;
        width: 100%;
        height: 7%;
        min-height: 43px;
        max-height: 45px;
        display: flex;
        position: initial;
        justify-content: center;
        justify-content: space-between;
      }
      .panel__basic-actions {
        width: 9%;
        max-width: 126px;
        position: initial;
        border: 2px solid rgba(0,0,0,0.2);
      }

      .panel__devices {
        margin-left: 38%;
        position: initial;
      }

      .panel__options {
        margin-left: 20%;
        position: initial;
      }

      .panel__switcher {
        width: 14.5%;
        max-width: 200px;
        border: 2px solid rgba(0,0,0,0.2);
        position: initial;
      }

      .editor-row {
        display: flex;
        justify-content: flex-start;
        align-items: stretch;
        flex-wrap: nowrap;
        height: 100%;
      }

      .editor-canvas {
        flex-grow: 1;
      }

      .panel__right {
        flex-basis: 200px;
        position: relative;
        overflow-y: auto;
        height: 100%;
      }
      .panel__left {
        flex-basis: 125px;
        position: relative;
        overflow-y: auto;
        height: 100%;
      }
      .pages-btn{
        width: 100%; 
        background: rgba(0,0,0,0.1); 
        color: white; 
        padding-right: 10px;
        outline: none; 
        border: 1px solid rgba(0,0,0,0.25);
      }
      .pages-btn:focus{
        background: rgba(255,255,255,0.1);
      }

      
    </style>
  </head>
  <body>
    <div class="panel__top">
      <div class="panel__basic-actions">
        <label style="font-size: 20px; color: #FC9627;"><i class="fas fa-align-justify"></i> Pages</label>
      </div>
      <div class="panel__devices"></div>
      <div class="panel__options"></div>
      <div class="panel__switcher"></div>
    </div>
    <div class="editor-row">
      <div class="panel__left">
        <div class="pages-container">
          <dd>
            @foreach($pages as $page)
              <dt>
                <button class="pages-btn" value="{{ $page->id }}">
                  <i class="fas fa-chevron-right fa-xs" style="padding-right: 5px;"></i> {{ $page->name }}
                </button>
              </dt>
            @endforeach 
          </dd>
        </div>
      </div>
      <div class="editor-canvas">
        <div id="editor"></div>
      </div>
      <div class="panel__right">
        <div class="layers-container"></div>
        <div class="styles-container"></div>
        <div class="elements-container"></div>
      </div>
    </div>
    <script type="text/javascript">
      // These pages are getting through the controller and only get pages corresponding to selected type are set
      const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
      const pages = [
      @foreach($pages as $page)
        {
          id: {{ $page->id }},
          name: '{{ $page->name }}',
          title: '{{ $page->title }}',
          builder: {!! !empty($page->builder) ? $page->builder : '[]' !!},
        },
      @endforeach
      ];
      // Pages 0 will be the default page when loading the editor
      var page = pages[0];
      // grapesjs.init will load the editor with the corresponding configuration
      const editor = grapesjs.init({
        // Set assigned template
        canvas: {
          styles: [
            '{{ asset("css/bootstrap-new.css") }}',
          ]
        },
        fromElement: 1,
        clearOnRender: true,
        // Select container of editor
        container  : '#editor',
        // Config the storege and load page
        storageManager: {
          autosave: false,
          setStepsBeforeSave: 1,
          type: 'remote',
          urlStore: '/admin/editor/store/' + page.id, // Url where we storage page in db
          urlLoad: '/admin/editor/' + page.id + '/load', // Url where we load page
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
              id: 'pages',
              el: '.panel__left',
              resizable: {
                maxDim: 150,
                minDim: 100,
                tc: 0,
                cr: 1,
                bc: 0,
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

                {
                  id: 'view-page',
                  className: 'btn-toggle-borders',
                  label: '<i class="far fa-eye"></i>',
                  command: 'view-page',
                  attributes: {title: 'View Page'}
                },

                {
                  id: 'save-db',
                  className: 'btn-toggle-borders',
                  label: '<i class="far fa-save"></i>',
                  command: 'save-db',
                  attributes: {title: 'Save'}
                }
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

      var pn = editor.Panels;
      var modal = editor.Modal;
      var cmdm = editor.Commands;
      var assets = editor.AssetManager.getAll();
      // Add extra panel to editor
      pn.addPanel({
        id: 'panel-top',
        el: '.panel__top',
      });
      pn.addPanel({
        id: 'basic-actions',
        el: '.panel__basic-actions',
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

      cmdm.add('save-db', {
        run: function(editor, sender){
          editor.store();
        }
      });

      cmdm.add('view-page', {
        run: function(editor, sender){
          var url = editor.StorageManager.get('remote').get('urlLoad');
          var id_page = url.split("/")[3];
          window.open('/page/'+id_page, '_blank');
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


      /**
     * This function loads a page to be edited
     * @param Integer id_page
     * @return void
     */
      function builderEditor(id_page){
        // Change urls to load and store
        editor.StorageManager.get('remote').set({
          urlStore: '/admin/editor/store/' + id_page, 
          urlLoad: '/admin/editor/' + id_page + '/load'
        });
        // Load page to editor
        editor.load();  
      }

      // This function run when select a pages button in the page panel
      $(document).on('click', '.pages-btn', function(event) {
        event.preventDefault();
        /* Act on the event */
        // Get id of page that want to edit
        var id_page = $(this).val();
        // Set id page to builderEditor function 
        builderEditor(parseInt(id_page));
      }); 

    </script>
  </body>
</html>
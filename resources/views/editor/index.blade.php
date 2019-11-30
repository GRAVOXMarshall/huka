<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Huka Editor</title> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
      body {
        height: 100%;
        overflow: hidden;
        margin: 0;
        background: white;
      }

      .child {
        display: inline-block; 
        vertical-align: middle;
        height: 100%;
      }
      .pattern {
        position: fixed;
        top: 0;
        width: 100%;  
        height: 30px; 
        white-space: nowrap; 
        line-height: 0px; 
        overflow: hidden;
        -webkit-box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
        box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
        background: white;
      }

      button.btn-action{
        color: #A9A2A0;
        justify-content: center;
        background-color: #fff;
        border: 0;
      }

      button.btn-action.active{
        color: #FF8045;
      }

      button.btn-action:hover{
        color: #FF8045;
      }

      button.btn-action:focus{
        outline-color: transparent; 
        outline-style: none;
      }
      .logo{
        width: 10%; 
        text-align: center; 
        border-right: #DBDBDB 1px solid;
      }
      select{
        width: 100%; 
        height: 100%; 
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius: 6px 6px 6px 6px;
        border: 1px solid #ccc4cc;
      }

      /* Reset some default styling */
      /* Primary color for the background */
      .gjs-one-bg {
        background-color: #FFFFFF;
      }

      /* Secondary color for the text color */
      .gjs-two-color {
        color: rgba(75, 75, 75, 1);
      }

      /* Tertiary color for the background */
      .gjs-three-bg {
        background-color: #FF8045;
        color: white;
      }

      /* Quaternary color for the text color */
      .gjs-four-color,
      .gjs-four-color-h:hover {
        color: #FF8045;
      }

      .gjs-cv-canvas {
        top: 0;
        width: 100%;
        height: 100%;
      }



      .bubbler-wrapper {
          font-family: "Roboto","Helvetica","Arial",sans-serif;
          position: fixed;
          top: 60px;
          right: 0;
          margin: 0 1em 3.5em 0;
          cursor: pointer;
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -khtml-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          z-index: 2;
           
      }

          .bubbler-wrapper .options {
              width: 1.7em;
              height: 1.7em;
              font-size: 2em;
              line-height: 1.7em;
              text-align: center;
              background: white;
              border-radius: 50%;
              -webkit-box-shadow: 0 1px 1px 1px rgba(0,0,0,.1);
              -moz-box-shadow: 0 1px 1px 1px rgba(0,0,0,.1);
              box-shadow: 0 1px 1px 1px rgba(0,0,0,.1);
           
          }

          .bubbler-wrapper .bubbler-menu-loader {
              width: 70px;
              height: 70px;
              background:  lightgray ;
              border-radius: 50%;
              box-shadow: -1px 7px 17px -7px rgba(0,0,0,0.75);
              transition: all 0.2s ease-in-out;
              font-size: 25px;
              color: white;
              text-align: center;
              line-height: 70px;
           

              /*position: fixed;
              right: 50px;
              bottom: 50px;
              z-index: 1000;*/
          }

          .bubbler-wrapper div:not(:last-child) {
              margin-bottom: .3em
          }

          .bubbler-wrapper .bubbler-menu-item {
               
              opacity: 0;
              max-height: 0;
              transition: opacity 0.2s,max-height 0s 0.2s;
              width: 70px;
              height: 70px;
              background:  #FF8045;
              border-radius: 50%;
              box-shadow: -1px 7px 17px -7px rgba(0,0,0,0.75);
              transition: all 0.1s ease-in-out;
              font-size: 25px;
              color: white;
              text-align: center;
              line-height: 70px;
           
              /*position: fixed;
              right: 50px;
              bottom: 50px;*/
          }

          .bubbler-wrapper:hover .bubbler-menu-item {
              opacity: 1;
              max-height: 100%;
              transition: opacity 0.2s,max-height 0s;
          }


      .bubbler-menu-item {  
          opacity: 0;
          max-height: 0;
          transition: opacity 0.2s,max-height 0s 0.2s;
      }

      .bubbler-wrapper:hover .bubbler-menu-item {
          opacity: 1;
          max-height: 100%;
          transition: opacity 0.2s,max-height 0s;
          

      }
      .boxMod {
        position: relative;
        display: block;
        border-bottom: 1px dotted black;
      }

      .boxMod .tooltiptext {
        visibility: hidden;
        width: 800px;
        background-color: #fff;
        border: solid 2px black;
        height: 550px;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 2;
        top: -5px;
        right: 110%;
        opacity: 1;
        transition: opacity 0.2s;
      }

      .boxMod .tooltiptext::after {
        content: "";
        position: absolute;
        border-width: 5px;
        border-style: solid;
        margin-top: -5px;
        top: 50%;
        left: 100%;
        opacity: 1;
        border-color: transparent transparent transparent #555;
      }

      .boxMod:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
      }
      .option{
        background: transparent;
        border: transparent;
      }
      .option:focus{
        outline-color: transparent; 
        outline-style: none;
         
      }
      .contenido > .opt{
        float: left;
        margin: 10px;
      }
      .opt{
        width: 45%; 
        height: 50%; 
        border: lightgray 1px solid;
      }
      .cont{
        margin: 0;
        overflow: hidden;
      }
      .cont .op {
        float: left;
        clear: none; 
      }

      .gjs-item-trait{
          position:absolute;
          border: 2px solid #3b97e3;
          background: white;
          color:white;
          z-index:10;
          top:0;
          left:0;
          height: 200px; 
          width: 220px;
          display: none; 
      }

      .gjs-item-design{
          position:absolute;
          border: 2px solid #3b97e3;
          background: white;
          color:white;
          z-index:10;
          top:0;
          left:0;
          min-height: 200px;
          height: auto; 
          width: 220px;
          display: none;
      }

      .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #FF8045;
        border:lightgray 1px solid ;
        
      }

    </style>
  </head>
  <body>
    <div class="pattern"> 
      <div class="child logo" >
        <h4 style="margin-top: 5px;"><i class="icon-fa-huka" style="margin-right: 10px; color: #FF8045; "></i><strong>Huka</strong></h4>
      </div>
      <div class="child" style="width: 10%; margin-left: 5px; text-align: center;">
        <select id="select-page" style="border: none; outline:none;">
          @foreach($pages as $page)
            @if($page->type != 'B')
              <option class="page-option" value="{{ $page->id }}">{{ $page->name }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="child" style="width: 10%; margin-left: 5px; border-right: #DBDBDB 1px solid; border-left: #DBDBDB 1px solid; text-align: center;">
        <button class="btn-action btn-page-type option active" type="front"><i class="fas fa-laptop fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-page-type" type="back"><i class="fas fa-server fa-lg" style="margin-top: 10px; margin-right: 10px;"></i></button>
        <button class="btn-action btn-page-type" type="layout"><i class="fas fa-window-restore fa-lg" style="margin-top: 10px;"></i></button>
      </div>
      <div id="" class="child" style="width: 50%; text-align: center; border-right: #DBDBDB 1px solid;">
        <button class="btn-action btn-devices option active" device="desktop"><i class="fas fa-desktop fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-devices" device="mobile"><i class="fas fa-mobile-alt fa-lg" style="margin-top: 10px;"></i></button>
      </div>
      <div class="child" style="width: 22%; text-align: center;">
        <button class="btn-action btn-main-action" action="view"><i class="far fa-eye fa-lg" style="margin-top: 10px;  margin-right: 15px;"></i></button>
        <button class="btn-action btn-main-action" action="login"><i class="far fa-user fa-lg" style="margin-top: 10px;  margin-right: 15px;"></i></button>
        <button class="btn-action btn-main-action" action="undo"><i class="fas fa-undo fa-lg" style="margin-top: 10px;  margin-right: 15px;"></i></button>
        <button class="btn-action btn-main-action" action="redo"><i class="fas fa-redo fa-lg" style="margin-top: 10px;  margin-right: 15px;"></i></button>
        <button class="btn-action btn-main-action" action="save"><i class="far fa-save fa-lg" style="margin-top: 10px;  margin-right: 15px;"></i></button> 
        <button class="btn-action btn-main-action" action="exit"><i class="fas fa-sign-out-alt fa-lg" style="margin-top: 10px; margin-right: 60px;"></i></button>
      </div>   
    </div> 
    <div id="list-action" class="bubbler-wrapper" >
      <div class="bubbler-menu-loader" >
        <i class="fas fa-cog fa-lg"></i>
      </div>
      <div class="options bubbler-menu-item boxMod">
        <div>
          <i class="fas fa-arrows-alt fa-lg" style="color: white; "></i>
        </div>
        <span class="tooltiptext">
            <h5 style="background: #FF8045; margin-top: -5px; padding-bottom: 10px; padding-top: 10px;">
              <i class="icon-fa-huka" style="margin-left: 10px; margin-right: 5px; color: white;"></i>
              <strong>Elements</strong>
            </h5>
            <div class="container">   
              <div class="row">
                <div class="col-md-12 btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-secondary active" style="padding: 20px;">
                    <input type="radio" name="options" id="option1" value="simple" checked> Simple
                  </label>
                  <label class="btn btn-outline-secondary" style="padding: 20px;">
                    <input   type="radio" name="options" id="option2" value="module"> Module
                  </label>
                </div>
              </div>
              <div class="row simpleEl">
                <div class="col-md-12" id="elements-content" style="height: 422px; overflow-y: auto; overflow-x: hidden;">
                    
                </div>
              </div>

              <div class="row moduleEl">
                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="row">
                    <div class="col-md-3" style="padding-top: 8px;">
                      <h5 style="color: black;">Filter by module:</h5>
                    </div>
                    <div class="col-md-9">
                      <select class="form-control">
                        <option value="">[Select a module...]</option>
                         @foreach($modules as $module)
                            <option>{{ $module['name'] }}</option>
                         @endforeach
                      </select>
                    </div>
                  </div>
                  <hr style="color: gray;">
                  <div class="col-md-12" id="module-content" style="height: 330px; overflow-y: auto; overflow-x: hidden;">
                    
                </div>
                </div>
              </div>
            </div>
        </span>
      </div>
      <div class="options bubbler-menu-item boxMod">
        <div  style="color: white;">
          <i class="icon fas fa-puzzle-piece fa-lg"></i>
        </div> 
        <span class="tooltiptext" style="height: 500px;">
          <h5 style="background: #FF8045; margin-top: -5px; padding-bottom: 10px; padding-top: 10px;">
            <i class="icon-fa-huka" style="margin-left: 10px; margin-right: 5px; color: white; "></i>
            <strong>Modules</strong>
          </h5>
          <div style="height: 91.5%; overflow: auto; overflow-x: hidden;">
            @foreach($modules as $module)
            <div style="border: lightgray 1px solid; overflow: hidden; width: 100%;">
              <div style="width: 10%; float: left; color: #FF8045;">
                <i class="fas fa-puzzle-piece fa-lg"></i>
              </div>
              <div align="left" style="width: 70%; float: left;">
                <label style="color: black;">{{ $module['name'] }}</label>
              </div>
              <div align="right" style="width: 20%; float: left;">
                @if($module['status'] == 1)
                <div class="btn-group" style="margin-right: 20px;">
                  <button class="btn btn-outline-primary btn-config" ref="{{ route(strtolower($module['name']).'.display.config') }}">Configurate</button>
                  <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" align="center"  aria-labelledby="dropdownMenuReference">  
                    <button class="dropdown-item btn btn-danger text-danger">Deactivate</button>
                    <button class="dropdown-item btn btn-primary text-primary">Uninstall</button>
                  </div>
                </div>
                @else
                  <button class="btn btn-primary btn-install-module" product="{{ Crypt::encrypt($module['id']) }}" style="margin-right: 20px;">Install</button>
                @endif
              </div>
            </div>
          @endforeach
          </div>
        </span>
      </div>
      <div class="options bubbler-menu-item boxMod">
        <div style="color: white;">
            <i class="fas fa-archive fa-lg"></i>
        </div> 
          <span class="tooltiptext" style="height: 450px;">
            <h5 style="background: #FF8045; margin-top: -5px; padding-bottom: 10px; padding-top: 10px;">
              <i class="icon-fa-huka" style="margin-left: 10px; margin-right: 5px; color: white; "></i>
              <strong>Blocks</strong>
            </h5>
            <div class="container"> 
             <div class="row">
                <div class="col-md-12" id="block-content" style="height: 395px; overflow-y: auto; overflow-x: hidden;">
                    
                </div>
              </div>
            </div>
        </span>
      </div>
      <div class="options bubbler-menu-item boxMod">
        <div style="color: white;">
          <i class="fas fa-question fa-lg"></i>
        </div> 
        <span class="tooltiptext" style="height: 380px;">
          <h5 style="background: #FF8045; margin-top: -5px; padding-bottom: 10px; padding-top: 10px;">
            <i class="icon-fa-huka" style="margin-left: 10px; margin-right: 5px; color: white; "></i>
            <strong>Help</strong>
          </h5> 
        </span>
      </div>
    </div>
    <!-- Start message of saved  -->
    <div id="huka-message" style="z-index: 2; background: white; position: relative; margin-right: 10px; border: #FF8045 1px solid; width: 300px; height: 85px; float: right; margin-top: -15px; display: none;">
       <h5 style="background: #FF8045; height: 37px; width: 100%; padding-bottom: 10px; padding-top: 10px;">
        <i class="icon-fa-huka" style="margin-left: 10px; margin-right: 5px; color: white; "></i>
        <strong>Huka message</strong>
      </h5>
      <h3 class="message" style="color: black;"><i class="fas fa-check" style="margin-left: 5px; margin-right: 5px; color: #FF8045;"></i><span>Saved successfully!</span></h3>
    </div>
    <div id="editor" style="margin-top: 45px;">
    </div>

    <script type="text/javascript">
      // MODO REGISTRADO y VISITANTE
      // CODIGO QUE DESPUES HAY QUE CAMBIAR DE POSISCION
      $(".moduleEl").hide();
      $("input[name=options]").change(function(){
        if ($(this).is(":checked")) {
          console.log($(this).val());
          if ($(this).val() == "simple") {
            $(".simpleEl").show();
            $(".moduleEl").hide();
          }else{
            $(".moduleEl").show();
            $(".simpleEl").hide();
          }
        }
      });


      const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
      // instanciate new modal
      const modal = new tingle.modal({
          footer: false,
          stickyFooter: false,
          closeMethods: ['overlay', 'button', 'escape'],
          beforeClose: function() {
              // here's goes some logic
              // e.g. save content before closing the modal
              return true; // close the modal
              return false; // nothing happens
          }
      });
      const pages = [
      @foreach($pages as $page)
        {
          id: {{ $page->id }},
          name: '{{ $page->name }}',
          title: '{{ $page->title }}',
          type: '{{ $page->type }}',
          main: ({{ $page->main }} == 1) ? true : false,
          builder: {!! !empty($page->builder) ? $page->builder : '[]' !!},
        },
      @endforeach
      ];

      const layouts = [
      @foreach($layouts as $layout)
        {
          id: {{ $layout->id }},
          name: '{{ $layout->name }}',
          title: '{{ $layout->title }}',
          type: 'L',
          builder: {!! !empty($layout->builder) ? $layout->builder : '[]' !!},
        },
      @endforeach
      ];

      let type_page = 'P';

      // Pages 0 will be the default page when loading the editor
      var page = pages[0];
      const editor = grapesjs.init({
        // Set assigned template
        canvas: {
          styles: [
            '{{ asset("css/bootstrap-new.css") }}',
          ]
        },
        userLogin: false,
        fromElement: 1,
        clearOnRender: true,
        // Select container of editor
        container  : '#editor',
        // Config the storege and load page
        storageManager: {
          autosave: false,
          setStepsBeforeSave: 1,
          type: 'remote',
          urlStore: '/admin/editor/store/P/' + page.id, // Url where we storage page in db
          urlLoad: '/admin/editor/load/P/' + page.id, // Url where we load page
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
        // Avoid any default panel
        panels: { defaults: [] },

         blockManager: {
          appendTo: '#elements-content',
          blocks: [
            // These elements getting through the controller and only get active
            @if(count($elements) > 0)
              @foreach($elements as $element)
                 @if(in_array('S', array_column(array($element), 'type')))
                 {
                  id: '{{ $element->name }}', 
                  label: '{{ $element->label }}',
                  attributes: {!! $element->attributes !!},
                  // Content can be String or JSON
                  content: {!! $element->content !!},
                },
                @endif
              @endforeach
            @endif
          ]
        }, 

         

        // Set default styles manager 
        styleManager: {
          appendTo: '.gjs-item-design',
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

        traitManager: {
          appendTo: '.gjs-item-trait',
        },

      });

      
     

      /*var blockManager = editor.BlockManager;
      blockManager.add('block-content', {
        label: 'Simple block',
        content: '<div class="my-block" style="color:black;">This is a simple block</div>',
      });*/

      @if(count($traits) > 0)
        @foreach($traits as $trait)
          var options = [];
          $.each(@json($trait->values), function(index, val) {
            options.push((val.substr(0,1) == '{') ? JSON.parse(val) : val);
          });
          
          // Define traits to elements
          editor.DomComponents.addType('{{ $trait->name }}', {
            model: {
              defaults: {
                traits: options
              }
            }
          });
        @endforeach
      @endif
      // Add delimiter to the elements
      editor.Canvas.getBody().className = 'gjs-dashed';

      const um = editor.UndoManager;
      const blockManager = editor.BlockManager;

      /*
      Block type elements
      */ 
      // You can also render your blocks outside of the main block container
      const BlockElements = blockManager.render([
        @if(count($elements) > 0)
          @foreach($elements as $element)
             @if(in_array('B', array_column(array($element), 'type')))
             {
              id: '{{ $element->name }}', 
              label: '{{ $element->label }}',
              attributes: {!! $element->attributes !!},
              // Content can be String or JSON
              content: {!! $element->content !!},
            },
            @endif
          @endforeach
        @endif
            ], { external: true });

      document.getElementById('block-content').appendChild(BlockElements);

      const ModuleElements = blockManager.render([
        @if(count($elements) > 0)
          @foreach($elements as $element)    
            @if(in_array('M', array_column(array($element), 'type')))
             {
              id: '{{ $element->name }}', 
              label: '{{ $element->label }}',
              attributes: {!! $element->attributes !!},
              // Content can be String or JSON
              content: {!! $element->content !!},
            },
            @endif
          @endforeach
        @endif
            ], { external: true });

      document.getElementById('module-content').appendChild(ModuleElements);

      const blocks = blockManager.getAll();
      //console.log(JSON.stringify(blocks));

      editor.Commands.add('tlb-traits', {
        run(editor, sender) {
          var trait_element = $('.gjs-item-trait');
          if ($(trait_element).is(":visible")) {
            $(trait_element).hide();
          }else{
            $(trait_element).show();
          }
        }
      });

      editor.Commands.add('tlb-design', {
        run(editor, sender) {
          var design_element = $('.gjs-item-design');
          if ($(design_element).is(":visible")) {
            $(design_element).hide();
          }else{
            $(design_element).show();
          }
        }
      });

      // Add attribute to items that will only be visible when the user logs in
      editor.on('component:add', (component) => {
        if (editor.Config.userLogin) {
          component.attributes.requiredUserLogin = true;
        }
      });

      /**
     * This function loads a page to be edited
     * @param Integer id_page
     * @return void
     */
      function builderEditor(id_page, type){
        // Change urls to load and store
        editor.StorageManager.get('remote').set({
          urlStore: '/admin/editor/store/' + type + '/' + id_page, 
          urlLoad: '/admin/editor/load/' + type + '/'+ id_page
        });

        editor.DomComponents.clear(); // Clear components
        editor.CssComposer.clear();  // Clear styles
        editor.UndoManager.clear(); // Clear undo history
        
        // Load page to editor
        editor.load();  
      }

      function showMessage(){
        $('#huka-message').show('slow/200/fast');
        $('#huka-message').delay(2000).hide(600);
      }

      $('.btn-page-type').click(function(e) {
        $('.btn-page-type.active').removeClass('active');
        $(this).addClass('active');
        $('#select-page').empty();

        switch($(this).attr('type')){
          case 'front':
          case 'back':
            type_page = 'P';
            var type = ($(this).attr('type') == 'front') ? 'F' : 'B';
            $.each(pages, function(index, page) {
              if (page.type == type) {
                $('#select-page').append(`<option class="page-option" value="${page.id}">${page.name}</option>`);
                if (page.main) {
                  builderEditor(page.id, 'P');
                }
              }
            });
          break;

          case 'layout':
            type_page = 'L';
            $.each(layouts, function(index, layout) {
              $('#select-page').append(`<option class="page-option" value="${layout.id}">${layout.name}</option>`);
            });

            builderEditor(layouts[0].id, 'L');

          break;

        }
        
        reloadElements();

      });

      $('#select-page').change(function(e) {
        var id_page = parseInt($("#select-page option:selected").val());
        builderEditor(id_page, type_page);
      });

      $('.btn-devices').click(function(e) {
        $('.btn-devices.active').removeClass('active');
        $(this).addClass('active');
        switch($(this).attr('device')){
           case 'desktop':
            editor.setDevice('Desktop');
           break;

           case 'mobile':
            editor.setDevice('Mobile');
           break;
        }
      });

      $('.btn-main-action').click(function(e) {

        switch($(this).attr('action')){
           case 'view':
            if ($(this).hasClass('active')) {
              $(this).removeClass('active');
              editor.Canvas.getBody().className = 'gjs-dashed';
               $('#list-action').show();
            }else{
              $(this).addClass('active');
              editor.Canvas.getBody().className = '';
              $('#list-action').hide();
            }
           break;

           case 'login':
            if ($(this).hasClass('active')) {
              $(this).removeClass('active');
              editor.Config.userLogin = false;
              displayUserLoginElements(editor.DomComponents.componentsById, false);
            }else{
              $(this).addClass('active');
              editor.Config.userLogin = true;
              displayUserLoginElements(editor.DomComponents.componentsById, true);
            }
           break;

           case 'undo':
            um.undo();
           break;

           case 'redo':
            um.redo();
           break;

           case 'save':
            editor.store();
            showMessage();
           break;

           case 'exit':
            window.location.replace("{{ route('dash.init') }}");
           break;
        }

      });

      $('.btn-install-module').click(function(e) {
        var content = $(this).parent();
        $.ajax({
          url: '{{ route("install.products") }}',
          type: 'POST',
          data: {
            _token: token,
            product_id: $(this).attr('product'),
            type: 'functionality'
          },
          success: function(response){
            var data =JSON.parse(response);
            if (!data.error) {
              showMessage();
              $(content).empty();
              $(content).append(
                `<div class="btn-group" style="margin-right: 20px;">
                  <button class="btn btn-outline-primary btn-config" ref="${data.configuration}">Configurate</button>
                  <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" align="center"  aria-labelledby="dropdownMenuReference">  
                    <button class="dropdown-item btn btn-danger text-danger">Deactivate</button>
                    <button class="dropdown-item btn btn-primary text-primary">Uninstall</button>
                  </div>
                </div>`
              );
            }
            
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            alert("Status: " + textStatus);
          }  
        });
        
      });


      $(document).on('click', '.btn-config', function(event) {
        var url = $(this).attr('ref');
        $.ajax({
          url: url,
          type: 'POST',
          data: {_token: token},
          success: function(response){
            console.log(response);
            // set content
            modal.setContent(response.html);

            // open modal
            modal.open();    
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            alert("Status: " + textStatus);
          }  
        });
      });

      $(document).on('click', '.btn-close-modal', function(event) {
        modal.close();
      });

      $(document).on('submit', '.module-modal', function(event) {
        event.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.ajax({
          url: url,
          type: 'POST',
          data: data+'&_token='+token,
          success: function(response){
            // We reload elements to add new elements of the module 
            reloadElements();
            showMessage();
            modal.close();
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            alert("Status: " + textStatus);
          }  
        });
        
      });
      

      function displayUserLoginElements(elements, display) {
        $.each(elements, function(index, element) {
          if (typeof element.attributes.requiredUserLogin !== 'undefined' && element.attributes.requiredUserLogin) {
            if (display) {
              $(element.getEl()).show();
            }else{
              $(element.getEl()).hide();
            }
          }
        });
      }

      function reloadElements() {
        // Get elements from block manager
        var elements = blockManager.getAll();
        var ids_elements = [];
        // Get id of elements and save en ids_elements array 
        $.each(elements.models, function(index, val) {
          if (typeof val.id !== 'undefined') {
            ids_elements.push(val.id);
          }
        });
        // Remove elements to block manager
        $.each(ids_elements, function(index, id) {
          blockManager.remove(id);
        });

        if (type_page == 'L') {
          // Add child element to block manager
          blockManager.add('childContainer', {
            label: 'Child Container',
            content: '<div data-gjs-type="childContainer">${Child Content}</div>',
            attributes: {
                'class': 'gjs-fonts gjs-f-b1'
            },
          });
        }

        // Get and add elements to block manager
        $.ajax({
          url: '{{ route("get.elements") }}',
          type: 'POST',
          data: {
            _token: token,
          },
          success: function(result){
            $.each(result, function(index, element) {
              var content;
              // If content is an array we parse to json 
              try {
                  content = JSON.parse(element.content);
              } catch (e) {
                  content = element.content;
              }
              // Add element to block manager
              blockManager.add(element.name, {
                label: element.label,
                content: content,
                attributes: JSON.parse(element.attributes)
              });
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            alert("Status: " + textStatus);
          }  
        });
      }

      function addNewRowToTable(table, tr) {
        $(table).children('tbody').append(tr);
      }

      function removeElement(element) {
        $(element).remove();
      }

    </script>
  </body>
</html>
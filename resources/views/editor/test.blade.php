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
        color: rgba(169, 162, 160, 0.7);
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
              box-shadow: 0 1px 1px 1px rgba(0,0,0,.1)
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
              transition: opacity 0.2s,max-height 0s
          }


      .bubbler-menu-item {
         
          opacity: 0;
          max-height: 0;
          transition: opacity 0.2s,max-height 0s 0.2s
      }

      .bubbler-wrapper:hover .bubbler-menu-item {
          opacity: 1;
          max-height: 100%;
          transition: opacity 0.2s,max-height 0s
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
        opacity: 0;
        transition: opacity 0.3s;
      }

      .boxMod .tooltiptext::after {
        content: "";
        position: absolute;
        border-width: 5px;
        border-style: solid;
        margin-top: -5px;
        top: 50%;
        left: 100%;
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
          border: 2px solid #FF8045;
          background: white;
          color:white;
          z-index:10;
          top:0;
          left:0;
          height: 200px; 
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
      <div class="child" style="width: 6%; margin-left: 5px; border-right: #DBDBDB 1px solid; border-left: #DBDBDB 1px solid; text-align: center;">
        <button class="btn-action btn-page-type option active" type="front"><i class="fas fa-laptop fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-page-type" type="back"><i class="fas fa-server fa-lg" style="margin-top: 10px;"></i></button>
      </div>
      <div id="" class="child" style="width: 50%; text-align: center; border-right: #DBDBDB 1px solid;">
        <button class="btn-action btn-devices option active" device="desktop"><i class="fas fa-desktop fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-devices" device="mobile"><i class="fas fa-mobile-alt fa-lg" style="margin-top: 10px;"></i></button>
      </div>
      <div class="child" style="width: 22%; text-align: center;">
        <button class="btn-action btn-main-action" action="view"><i class="far fa-eye fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-main-action" action="undo"><i class="fas fa-undo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-main-action" action="redo"><i class="fas fa-redo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-main-action" action="save"><i class="far fa-save fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button> 
        <button class="btn-action btn-main-action" action="exit"><i class="fas fa-sign-out-alt fa-lg" style="margin-top: 10px;"></i></button>
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
            <div class="cont" style="margin-left: 5px; height: 92.5%;">
              <div class="op list-group" id="list-tab" role="tablist" style="width: 30%; height: auto;">
                 <button class="sections list-group-item list-group-item-action active" style="outline-color: #FF8045;"   id="elements-content-list" data-toggle="list" href="#elements-content" role="tab" aria-controls="content">Common</button> 
                 <button class="sections list-group-item list-group-item-action" style="outline-color: #FF8045;" id="elements-module-list" data-toggle="list" href="#elements-module" role="tab" aria-controls="module">Module</button> 
                 <!--<button class="sections" style="width: 100%; height: 90px; font-size: 20px;">Common</button> 
                 <button class="sections" style="width: 100%; height: 90px; font-size: 20px;">Common</button> 
                 <button class="sections" style="width: 100%; height: 90px; font-size: 20px;">Common</button>--> 
              </div>
              <div class="op tab-content" id="nav-tabContent" style="width: 70%; height: 100%; overflow: auto; overflow-x: hidden;">
                <!-- Aqui es la parte de los elementos  -->
                <div class="tab-pane fade show active" id="elements-content" role="tabpanel" aria-labelledby="elements-content-list" style="border: 1px lightgray solid;"></div>
                <div class="tab-pane fade" id="elements-module" role="tabpanel" aria-labelledby="elements-module-list" style="color: black;">
                  <h6 align="left" style="margin-left: 5px; border-bottom: 1px #FF8045 solid;">Module One</h6>
                  <div class="contenido">
                    <div class="opt" style="color: black;">elemento 1</div>
                    <div class="opt" style="color: black;">elemento 2</div>
                    <div class="opt" style="color: black;">elemento 3</div>
                    <div class="opt" style="color: black;">elemento 4</div>
                  </div>
                  <h6 align="left" style="margin-left: 5px; border-bottom: 1px #FF8045 solid;">Module Two</h6>
                  <div class="contenido">
                    <div class="opt" style="color: black;">elemento 1</div>
                    <div class="opt" style="color: black;">elemento 2</div>
                    <div class="opt" style="color: black;">elemento 3</div>
                    <div class="opt" style="color: black;">elemento 4</div>
                  </div>
                  <h6 align="left" style="margin-left: 5px; border-bottom: 1px #FF8045 solid;">Module Three</h6>
                  <div class="contenido">
                    <div class="opt" style="color: black;">elemento 1</div>
                    <div class="opt" style="color: black;">elemento 2</div>
                    <div class="opt" style="color: black;">elemento 3</div>
                    <div class="opt" style="color: black;">elemento 4</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!--<div align="left" style="margin-left: 10px; border-bottom: orange 1px solid;">
              <h6 style="color: black;">Module Elements</h6>
            </div>
            <div class="contenido">
              <div class="opt" style="color: black;">elemento 1</div>
              <div class="opt" style="color: black;">elemento 2</div>
              <div class="opt" style="color: black;">elemento 3</div>
              <div class="opt" style="color: black;">elemento 4</div>
            </div>
            <div align="left" style="margin-left: 10px; border-bottom: orange 1px solid;">
              <h6 style="color: black;">Common Elements</h6>
            </div>
            <div class="contenido">
              <div class="opt" style="color: black;">elemento 1</div>
              <div class="opt" style="color: black;">elemento 2</div>
              <div class="opt" style="color: black;">elemento 3</div>
              <div class="opt" style="color: black;">elemento 4</div>
            </div>-->
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
            <div style="border: lightgray 1px solid; overflow: hidden; width: 100%; ">
              <div align="left" style="width: 50%; float: left;">
                <i class="far fa-address-card fa-lg" style="color: black; margin-left: 10px;"></i>
                <label style="color: black;">{{ $module['name'] }}</label>
              </div>
              <div align="right" style="width: 50%; float: left;">  
                <button style="margin-right: 20px; border: lightgray 1px solid; font-size: 18px;" class="btn">Download!</button>
              </div>
            </div>
          @endforeach
          </div>
           <!--<div class="contenido">
            <div class="opt">
              <i class="far fa-address-card fa-2x" style="color: black; margin-top: 10px;"></i>
              <h4 style="color: black;">Authentication</h4>
              <button style="font-size: 18px;">Download!</button>
            </div>
            <div class="opt" style="color: black;">elemento 2</div>
            <div class="opt" style="color: black;">elemento 2</div>
            <div class="opt" style="color: black;">elemento 2</div>
            <div class="opt" style="color: black;">elemento 2</div>
            <div class="opt" style="color: black;">elemento 2</div>
            <div class="opt" style="color: black;">elemento 2</div>
          </div>-->
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
       
      <h3 style="color: black;" align="center"><!--<i class="fas fa-check" style="margin-left: 5px; margin-right: 5px; color: #FF8045;"></i>-->Saved successfully!</h3>
    </div>
    <!--<div class="boxMod" style="margin-top: 150px; margin-left: 500px;  ">Hover over me
    <span class="tooltiptext">Tooltip text</span>
  </div>-->
    <div id="editor" style="margin-top: 45px;">
    </div>

    <script type="text/javascript">
      const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
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
      // Pages 0 will be the default page when loading the editor
      var page = pages[0];
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
                {
                  id: '{{ $element->name }}', 
                  label: '{{ $element->label }}',
                  attributes: {!! $element->attributes !!},
                  content: {!! $element->content !!} // Content can be String or JSON
                },
              @endforeach
            @endif
          ]
        },

        traitManager: {
          appendTo: '.gjs-item-trait',
        },

      });

      // Add delimiter to the elements
      editor.Canvas.getBody().className = 'gjs-dashed';
      const um = editor.UndoManager;

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

        editor.DomComponents.clear(); // Clear components
        editor.CssComposer.clear();  // Clear styles
        editor.UndoManager.clear(); // Clear undo history
        
        // Load page to editor
        editor.load();  
      }

      $('.btn-page-type').click(function(e) {
        $('.btn-page-type.active').removeClass('active');
        $(this).addClass('active');
        var type = ($(this).attr('type') == 'front') ? 'F' : 'B';
        $('#select-page').empty();
        $.each(pages, function(index, page) {
          if (page.type == type) {
            $('#select-page').append(`<option class="page-option" value="${page.id}">${page.name}</option>`);
            if (page.main) {
              builderEditor(page.id);
            }
          }
        });
      });

      $('#select-page').change(function(e) {
        var id_page = parseInt($("#select-page option:selected").val());
        builderEditor(id_page);
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

           case 'undo':
            um.undo();
           break;

           case 'redo':
            um.redo();
           break;

           case 'save':
            editor.store();
            $('#huka-message').show('slow/200/fast');
            $('#huka-message').delay(2000).hide(600);
           break;

           case 'exit':
            window.location.replace("{{ route('dash.init') }}");
           break;
        }

      });



       

    </script>
  </body>
</html>
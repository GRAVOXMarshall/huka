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
      .gjs-cv-canvas {
        top: 0;
        width: 100%;
        height: 100%;
      }

    </style>
  </head>
  <body>
    <div class="pattern"> 
      <div class="child logo" >
        <h4 style="margin-top: 5px;"><i class="icon-fa-huka" style="margin-right: 10px; color: #FF8045; "></i><strong>Huka</strong></h4>
      </div>
      <div class="child" style="width: 10%; margin-left: 5px; text-align: center;">
        <select style="border: none; outline:none;">
          @foreach($pages as $page)
            <option value="{{ $page->id }}">{{ $page->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="child" style="width: 6%; margin-left: 5px; border-right: #DBDBDB 1px solid; border-left: #DBDBDB 1px solid; text-align: center;">
        <a href="#"><i class="fas fa-laptop fa-lg" style="margin-top: 10px;  margin-right: 10px; color: #FF8045;"></i></a> 
        <a href="#"><i class="fas fa-user-cog fa-lg"></i></a>
      </div>
      <div id="" class="child" style="width: 50%; text-align: center; border-right: #DBDBDB 1px solid;">
        <button class="btn-action btn-devices active" device="desktop"><i class="fas fa-desktop fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></button>
        <button class="btn-action btn-devices" device="mobile"><i class="fas fa-mobile-alt fa-lg" style="margin-top: 10px;"></i></button>
      </div>
      <div class="child" style="width: 22%; text-align: center;">
        <a href="#"><i class="far fa-eye fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="fas fa-undo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="fas fa-redo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="far fa-save fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a> 
        <a href="#"><i class="fas fa-sign-out-alt fa-lg" style="margin-top: 10px;"></i></a>
      </div>   
    </div> 
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

    </script>
  </body>
</html>
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
      }

      .child {
        display: inline-block; 
        vertical-align: middle;
        height: 100%;
      }
      .container {
         
        height: 45px; 
        white-space: nowrap; 
        line-height: 0px; 
        overflow: hidden;
        -webkit-box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
        box-shadow: 0px 5px 13px -7px rgba(0,0,0,0.75);
      }
      a{
        color: black;
      }
      .logo{
        width: 10%; 
        text-align: center; 
        border-right: #DBDBDB   1px solid;
      }
      select{
        width: 100%; height: 100%; border-radius: 6px 6px 6px 6px;
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
    <div class="container"> 
      <div class="child logo" >
        <h4><strong>Huka</strong></h4>
      </div>
      <div class="child" style="width: 10%;  text-align: center;">
        <select>
        <option>[Pages..]</option>
        <option>1</option>
        <option>2</option>
        </select>
      </div>
      <div class="child" style="width: 6%; margin-left: 5px; border-right: #DBDBDB   1px solid; text-align: center;">
        <a href="#"><i class="fas fa-laptop fa-lg" style="margin-top: 15px; margin-right: 10px; color: #F58A10;"></i></a> 
        <a href="#"><i class="fas fa-user-cog fa-lg" style="margin-top: 15px; color: #F58A10;"></i></a>
      </div>
      <div class="child" style="width: 50%; text-align: center; border-right: #DBDBDB   1px solid;">
        <a href="#"><i class="fas fa-desktop fa-2x" style="margin-top: 5px;  margin-right: 10px; color: #F58A10;"></i></a> 
        <a href="#"><i class="fas fa-mobile-alt fa-2x" style="margin-top: 5px; color: #F58A10;"></i></a>  
      </div>
      <div class="child" style="width: 22%; text-align: center;">
        <a href="#"><i class="far fa-save fa-2x" style="margin-top: 5px;  margin-right: 10px; color: #F58A10;"></i></a> 
        <a href="#"><i class="fas fa-sign-out-alt fa-2x" style="margin-top: 5px; color: #F58A10;"></i></a>
      </div>   
    </div>
    <div id="editor">
      <h1>Hello World Component!</h1>
    </div>
    <script type="text/javascript">
      const editor = grapesjs.init({
        // Indicate where to init the editor. You can also pass an HTMLElement
        container: '#editor',
        // Get the content for the canvas directly from the element
        // As an alternative we could use: `components: '<h1>Hello World Component!</h1>'`,
        fromElement: true,
        // Disable the storage manager for the moment
        storageManager: { type: null },
        // Avoid any default panel
        panels: { defaults: [] },
      });
    </script>
  </body>
</html>
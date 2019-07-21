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

      a{
        color: #A9A2A0;
      }
      a:hover{
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

      .bubbler-wrapper {
          font-family: "Roboto","Helvetica","Arial",sans-serif;
          position: fixed;
          top: 60px;
          right: 0;
          margin: 0 7em 3.5em 0;
          cursor: pointer;
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -khtml-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          z-index: 2;
      }

          .bubbler-wrapper div {
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
              background: rgba(0,0,0,0.2);
              border-radius: 50%;
              box-shadow: 0 6px 10px 0 #666;
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
              background: rgba(0,0,0,0.2);
              border-radius: 50%;
              box-shadow: 0 6px 10px 0 #666;
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
        width: 500px;
        background-color: #fff;
        border: solid 1px black;
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
        background: transparent;
        border: transparent;
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
        <option>[Pages..]</option>
        <option>1</option>
        <option>2</option>
        </select>
      </div>
      <div class="child" style="width: 6%; margin-left: 5px; border-right: #DBDBDB 1px solid; border-left: #DBDBDB 1px solid; text-align: center;">
        <a href="#"><i class="fas fa-laptop fa-lg" style="margin-top: 10px;  margin-right: 10px; color: #FF8045;"></i></a> 
        <a href="#"><i class="fas fa-user-cog fa-lg"></i></a>
      </div>
      <div class="child" style="width: 50%; text-align: center; border-right: #DBDBDB 1px solid;">
        <a href="#"><i class="fas fa-desktop fa-lg" style="margin-top: 10px;  margin-right: 10px; color: #FF8045;"></i></a> 
        <a href="#"><i class="fas fa-mobile-alt fa-lg" style="margin-top: 10px;"></i></a>  
      </div>
      <div class="child" style="width: 22%; text-align: center;">
        <a href="#"><i class="far fa-eye fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="fas fa-undo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="fas fa-redo fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a>
        <a href="#"><i class="far fa-save fa-lg" style="margin-top: 10px;  margin-right: 10px;"></i></a> 
        <a href="#"><i class="fas fa-sign-out-alt fa-lg" style="margin-top: 10px;"></i></a>
      </div>   
    </div> 
   
    <div class="bubbler-wrapper" >
      <div class="bubbler-menu-loader" ><i class="fas fa-cog fa-lg"></i></div>
      <div class="bubbler-menu-item boxMod"><button class="option" title="Elementos" style="text-decoration: none; color: white; "><i class="fas fa-arrows-alt fa-lg"></i></button><span class="tooltiptext"><i class="icon-fa-huka fa-lg" style="margin-right: 10px; color: #FF8045; "></i><br><h3 style="color: black;">Hello Elements!</h3></span></div>
      <div class="bubbler-menu-item boxMod"><button class="option" href="#" title="Modulos" style="text-decoration: none; color: white;"><i class="icon fas fa-puzzle-piece fa-lg"></i></button> <span class="tooltiptext"><i class="icon-fa-huka fa-lg" style="margin-right: 10px; color: #FF8045; "></i><br><h3 style="color: black;">Hello Modules!</h3></span></div>
      <div class="bubbler-menu-item boxMod"><button class="option" href="#" title="Bloques" style="text-decoration: none; color: white;"><i class="fas fa-archive fa-lg"></i></button> <span class="tooltiptext"><i class="icon-fa-huka fa-lg" style="margin-right: 10px; color: #FF8045; "></i><br><h3 style="color: black;">Hell Blocks!</h3></span></div>
      <div class="bubbler-menu-item boxMod"><button class="option" href="#" title="Ayuda" style="text-decoration: none; color: white;"><i class="fas fa-question fa-lg"></i></button> <span class="tooltiptext"><i class="icon-fa-huka fa-lg" style="margin-right: 10px; color: #FF8045; "></i><br><h3 style="color: black;">Hello Help!</h3></span></div>
    </div>

     
    <!--<div class="boxMod" style="margin-top: 150px; margin-left: 500px;  ">Hover over me
    <span class="tooltiptext">Tooltip text</span>
  </div>-->
    <div id="editor" style="margin-top: 45px;">
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
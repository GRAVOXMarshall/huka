<?php

use Illuminate\Database\Seeder;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Text element 

        DB::table('elements')->insert([
            'name' => "text",
            'label' => "Text",
            'attributes' => json_encode(array(
            	"class" => "gjs-fonts gjs-f-text"
            )), 
            'content' => json_encode(array(
            	"type" => "text",
				"content" => "Insert your text here",
				"style" => json_encode(array(
					"padding" => "10px"
				)), 
				"activeOnRender" => 1
            )),
            'type' => 'S',
            'active' => true,
        ]);

        // Columnas elements 
        DB::table('elements')->insert([
            'name' => "container",
            'label' => "Container",
            'attributes' => json_encode(array(
                "class" => "gjs-fonts gjs-f-b1"
            )),
            'content' => json_encode(array(
                "type" => "box",
                "classes" => [
                    "container-fluid"
                ],
                "style" => [
                    "display" => "table",
                    "padding" => "40px",
                    "width" => "100%"
                ],
                "activeOnRender" => 1
            )),
            'type' => 'S',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "column1",
            'label' => "Columna 1",
            'attributes' => json_encode(array(
            	"class" => "gjs-fonts gjs-f-b1"
            )), 
            'content' => "\"	<div  class='row'><div  class='hk-md-12'></div></div><style> .row {padding: 20px; width: 100%;} .hk-md-12 { padding: 20px 0px;}</style>\"	",
            'type' => 'S',
            'active' => true,
        ]);
        //<div class='row'><div class='hk-md-12' style='border:orange 1px solid; height:50px;'></div></div>
        DB::table('elements')->insert([
            'name' => "column2",
            'label' => "Columna 2",
            'attributes' => json_encode(array(
            	"class" => "gjs-fonts gjs-f-b2"
            )), 
            'content' => "\"	<div  class='row'><div class='hk-md-6'></div><div  class='hk-md-6'></div></div><style> .row { padding: 20px; width: 100%; } .hk-md-6 { padding: 20px;}</style>\"	",
            'type' => 'S',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "column3",
            'label' => "Columna 3",
            'attributes' => json_encode(array(
            	"class" => "gjs-fonts gjs-f-b3"
            )), 
            'content' => "\"	<div  class='row'><div  class='hk-md-4'></div><div  class='hk-md-4'></div><div  class='hk-md-4'></div></div><style> .row { padding: 20px; width: 100%; }  .hk-md-4 { padding: 20px;} </style>\"	",
            'type' => 'S',
            'active' => true,
        ]);

         DB::table('elements')->insert([
            'name' => "column4",
            'label' => "Columna 4",
            'attributes' => json_encode(array(
                "class" => "gjs-fonts gjs-f-b3"
            )), 
            'content' => "\"    <div  class='row'><div  class='hk-md-3'></div><div  class='hk-md-3'></div><div  class='hk-md-3'></div><div  class='hk-md-3'></div></div><style> .row { padding: 20px; width: 100%; }  .hk-md-3 { padding: 20px;} </style>\" ",
            'type' => 'S',
            'active' => true,
        ]);

        // Image Element

        DB::table('elements')->insert([
            'name' => "image",
            'label' => "Image",
            'attributes' => json_encode(array(
            	"class" => "gjs-fonts gjs-f-image"
            )), 
            'content' => json_encode(array(
            	"type" => "image",
				"style" => json_encode(array(
					"color" => "black"
				)), 
				"activeOnRender" => 1
            )),
            'type' => 'S',
            'active' => true,
        ]);

        // Link element 

        DB::table('elements')->insert([
            'name' => "link",
            'label' => "Link",
            'attributes' => json_encode(array(
            	"class" => "fa fa-link"
            )), 
            'content' => json_encode(array(
            	"type" => "link",
				"content" => "Link",
				"style" => json_encode(array(
					"color" => "#d983a6"
				))
            )),
            'type' => 'S',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "button",
            'label' => "Button Normal",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\"  <button class='btn-outline-warning'>Button</button> \" ",
            'type' => 'S',
            'active' => true,
        ]);
         
        DB::table('elements')->insert([
            'name' => "buttonlarge",
            'label' => "Button Large",
            'attributes' => json_encode(array(
                "class" => "fa fa-link",
 
            )),  
            "content" => "\" <button data-gjs-type='buttonLarge'>Button</button>\" ",
            'type' => 'S',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "navigation",
            'label' => "Navigation",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <nav class='navbar navbar-expand-sm navbar-light bg-faded border-bottom shadow-sm'><button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#nav-content' aria-controls='nav-content' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button><a class='navbar-brand' href='#'>Logo</a><div class='collapse navbar-collapse justify-content-end' id='nav-content'>   <ul class='navbar-nav'><li class='nav-item'><a class='nav-link' href='#'>Link 1</a></li><li class='nav-item'><a class='nav-link' href='#'>Link 2</a></li><li class='nav-item'><a class='nav-link' href='#'>Link 3</a></li></ul></nav> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "footer",
            'label' => "Footer",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <footer class='page-footer font-small blue pt-4 border-top shadow-sm'><div class='container-fluid text-center text-md-left'><div class='row'><div class='hk-md-6 mt-md-0 mt-3'><h5 class='text-uppercase'>Footer Content</h5><p>Here you can use rows and columns to organize your footer content.</p></div><hr class='clearfix w-100 d-md-none pb-3'><div class='hk-md-3 mb-md-0 mb-3'><h5 class='text-uppercase'>Links</h5><ul class='list-unstyled'><li><a href='#!'>Link 1</a></li><li><a href='#!'>Link 2</a></li><li><a href='#!'>Link 3</a></li><li><a href='#!'>Link 4</a></li></ul></div><div class='hk-md-3 mb-md-0 mb-3'><h5 class='text-uppercase'>Links</h5><ul class='list-unstyled'><li><a href='#!'>Link 1</a></li><li><a href='#!'>Link 2</a></li><li><a href='#!'>Link 3</a></li><li><a href='#!'>Link 4</a></li></ul></div></div></div><div class='footer-copyright text-center py-3'>© 2019 Copyright:<a href='https://mdbootstrap.com/education/bootstrap/'> gethuka.com</a></div></footer> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "footer2",
            'label' => "Footer two",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <footer class='page-footer font-small blue pt-4 border-top shadow-sm' ><div class='container-fluid'><div class='row'><div class='hk-md-4'><h3>Company Name</h3></div><div class='hk-md-4'><h4>Contact</h4><h6>Email: Email@example.com</h6><h6>Phone: +56912345678</h6><h6>Address: The street #123</h6></div><div class='hk-md-4'><h4>Menu</h4><ul><li><a href='#'>Section one</a></li><li><a href='#'>Section two</a></li><li><a href='#'>Section three</a></li><li><a href='#'>Section four</a></li><li><a href='#'>Section five</a></li></ul></div></div><div class='row'><div class='hk-md-12'><div class='footer-copyright text-center py-3'>© 2019 Copyright:<a href='https://mdbootstrap.com/education/bootstrap/'> gethuka.com</a></div></div></div></div></footer> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "lista",
            'label' => "Lista",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <dl><dd>lista 1</dd><dd>lista 1</dd><dd>lista 3</dd><dd>lista 4</dd><dd>lista 5</dd></dl> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "navigation2",
            'label' => "Navigation 2",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <nav class='navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm'><a class='navbar-brand' href='#'>Company</a><button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarText' aria-controls='navbarText' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button><div class='collapse navbar-collapse' id='navbarText'><ul class='navbar-nav mr-auto'><li class='nav-item active'><a class='nav-link' href='#'>Home <span class='sr-only'>(current)</span></a></li><li class='nav-item'><a class='nav-link' href='#'>Features</a></li><li class='nav-item'><a class='nav-link' href='#'>Pricing</a></li></ul></div></nav> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "navigation3",
            'label' => "Navigation 3",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <nav class='navbar navbar-expand-lg navbar-dark bg-secondary border-bottom shadow-sm'><div class='collapse navbar-collapse' id='navbarText'><ul class='navbar-nav mr-auto'><li class='nav-item active'><a class='nav-link' href='#'>Home <span class='sr-only'>(current)</span></a></li><li class='nav-item'><a class='nav-link' href='#'>Features</a></li><li class='nav-item'><a class='nav-link' href='#'>Pricing</a></li></ul></div><a class='navbar-brand' href='#'>Logo/Company</a><button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarText' aria-controls='navbarText' aria-expanded='false' aria-label='Toggle navigation'><span class='navbar-toggler-icon'></span></button></nav> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "features",
            'label' => "Features",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <div class='container-fluid'><div class='row'><div class='hk-md-6' align='center'><h2><strong>Topic</strong></h2><h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h6></div><div class='hk-md-6' align='center'><h2><strong>Topic</strong></h2><h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h6></div></div><div class='row'><div class='hk-md-6' align='center'><h2><strong>Topic</strong></h2><h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h6></div><div class='hk-md-6' align='center'><h2><strong>Topic</strong></h2><h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h6></div></div></div> \" ",
            'type' => 'B',
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "team",
            'label' => "Team",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <div class='container-fluid'><div class='row'><div class='hk-md-12' align='center'><h1><strong>Our Team</strong></h1></div></div><div class='row'><div class='hk-md-4'  align='center'><img src='' width='300' height='300'><br><h3><strong>Nicolas Marshall</strong></h3><h5 style='color: gray;'>Developer</h5></div><div class='hk-md-4'  align='center'><img src='' width='300' height='300'><br><h3><strong>Nicolas Marshall</strong></h3><h5 style='color: gray;'>Developer</h5></div><div class='hk-md-4'  align='center'><img src='' width='300' height='300'><br><h3><strong>Nicolas Marshall</strong></h3><h5 style='color: gray;'>Developer</h5></div></div></div> \" ",
            'type' => 'B',
            'active' => true,
        ]);

       /* DB::table('elements')->insert([
            'name' => "Inputext",
            'label' => "Input Text",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <input class='form-control' type='text'> \" ",
            'active' => true,
        ]);

        DB::table('elements')->insert([
            'name' => "InputPass",
            'label' => "Input Pass",
            'attributes' => json_encode(array(
                "class" => "fa fa-link"
            )), 
            "content" => "\" <input class='form-control' type='password'> \" ",
            'active' => true,
        ]);*/


        // Next elements 

		/*
	      blockManager.add("map", {
	          label: "Map",
	          category: "Element",
	          attributes: {
	              class: "fa fa-map-o"
	          },
	          content: {
	              type: "map",
	              style: {
	                  height: "350px"
	              }
	          }
	      })

	      blockManager.add("video", {
	          label: "Video",
	          category: "Element",
	          attributes: {
	              class: "fa fa-youtube-play"
	          },
	          content: {
	              type: "video",
	              src: "img/video2.webm",
	              style: {
	                  height: "350px",
	                  width: "615px"
	              }
	          }
	      });
	      */        

    }
}

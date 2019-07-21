<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Title</title>
	<style type="text/css">
		body {
			margin: 0;
		}
		.child {
			display: inline-block; 
			vertical-align: middle;
			height: 100%;
		}
		.container {
			 position: fixed;
			 top: 0;
			 width: 100%;
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
		.testing{
			position: relative;
			margin-top: 50px;
			margin-left: 60px;
		}
		.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
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

  <div class="tooltip" style="margin-top: 150px; margin-left: 500px;">Hover over me
  <span class="tooltiptext">Tooltip text</span>
</div>
    
</div>
</body>
</html>
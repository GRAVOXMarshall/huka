$(document).ready(function(){
 

$(document).on('click', '.btnPermit', function(){
	var url = $(this).attr('route');
	var val = $(this).attr('data');
	var explode = val.split("-");
	var permit = explode[0];
	var group = explode[1]; 
	$(".texto").hide();
	$(".texto").empty();
	if ($(this).prop('checked')) {
		$.ajax({
	          
	          url: url,
	          data: {btn: 'permit', type: 'insert', permit: permit, group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
	          type: "POST",
	          dataType: 'json',
	          success: function (success) {
	              console.log("bien: ", success.txt);
	             
	            	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000); 
	          },
	          error: function (success) {
	              console.log('Error:', success);
	              
	          }
	      });
	}else{
		$.ajax({
	          
	          url: url,
	          data: {btn: 'permit', type: 'delete', permit: permit, group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
	          type: "POST",
	          dataType: 'json',
	          success: function (success) {
	              console.log("bien: ", success);
	              	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000);           
	          },
	          error: function (success) {
	              console.log('Error:', success);
	              
	          }
	      });
	}
	 
 
	 
	});

$(document).on('click', '.btnGroup', function(){
	var url = $(this).attr('route');
	var val = $(this).attr('data');
	var explode = val.split("-");
	var permit = explode[0];
	var group = explode[1]; 
	$(".texto").hide();
	$(".texto").empty();
	if ($(this).prop('checked')) {
		 
		$.ajax({
	          
	          url: url,
	          data: {btn: 'group', type: 'insert', admin: permit, group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
	          type: "POST",
	          dataType: 'json',
	          success: function (success) {
	              console.log("bien: ", success );
	             
	            	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000); 
	          },
	          error: function (success) {
	              console.log('Error:', success);
	              
	          }
	      });
	}else{
		 

		$.ajax({
	          
	          url: url,
	          data: {btn: 'group', type: 'delete', admin: permit, group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
	          type: "POST",
	          dataType: 'json',
	          success: function (success) {
	              console.log("bien: ", success);
	              	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000);           
	          },
	          error: function (success) {
	              console.log('Error:', success);
	              
	          }
	      });
	}
	 
 
	 
	});
});
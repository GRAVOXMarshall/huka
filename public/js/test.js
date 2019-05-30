$(document).ready(function(){
 
 
$(document).on('click','.groups',function(){
 $(".iden").empty();
var url = $(this).attr('route');
var explode = $(this).attr('data').split('-');
var group = explode[0];
$(".iden").text("("+explode[1]+")");
 
$(".permits").empty();
	$.ajax({

		url: url,
		data: {group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
		type: "POST",
		dataType: 'json',
		success: function (success) {
 
			$.each(success.group, function(index, val) {
				if (val.type === 0) {
					$(".permits").append('<div class="custom-control custom-checkbox col-md-12 border shadow-sm p-1 mb-2 bg-white rounded-lg" align="center"><input type="checkbox" route="'+success.url+'" data="'+val.id+'-'+group+'"  class="custom-control-input btnPermit" id="defaultChecked'+val.id+'" checked><label class="h5 custom-control-label" for="defaultChecked'+val.id+'">'+val.name+'</label></div>');

				}else if(val.type === 1){
					$(".permits").append('<div class="custom-control custom-checkbox col-md-12 border shadow-sm p-1 mb-2 bg-white rounded-lg" align="center"><input type="checkbox" route="'+success.url+'" data="'+val.id+'-'+group+'"  class="custom-control-input btnPermit" id="defaultChecked'+val.id+'"  ><label class="h5 custom-control-label" for="defaultChecked'+val.id+'">'+val.name+'</label></div>');

				}
 
			});
			//console.log("bien: ", success );

			
		},
		error: function (success) {
			 //window.open('http://stackoverflow.com/search?q=[js] +'+success.responseJSON.exception, '_blank');

			//console.log('Error:', success.responseJSON );
			//console.log('Error:', success.responseJSON.exception);

		}
	});

});

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
 
	             
	            	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000);
	          },
	          error: function (success) {
	          	 //window.open('http://stackoverflow.com/search?q=[js] +'+success.responseJSON.exception, '_blank');
	          	 
	              //console.log('Error:', success.responseJSON.exception);
	              
	          }
	      });
	}else{
		$.ajax({
	          
	          url: url,
	          data: {btn: 'permit', type: 'delete', permit: permit, group: group,  "_token": $("meta[name='csrf-token']").attr("content")},
	          type: "POST",
	          dataType: 'json',
	          success: function (success) {
 
	              	$(".texto").show( ); 
	            	$(".texto").append('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible fade show" role="alert">'+success.txt+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div></div></div><br>');          
	          		$(".texto").hide(3000);           
	          },
	          error: function (success) {
	              //console.log('Error:', success);
	              
	          }
	      });
	}
	 
 
	 
	});
});
@extends('extra.configurations')

@section('content')
  @if(!is_null($configurations) && count($configurations) > 0)
    <div class="tab-pane fade" id="home-view" role="tabpanel">
    	<h1>Forum Settings!</h1>
    	<form action="{{ route('forum.configuration.testing') }}" method="post">
    		@csrf
    	<div class="custom-control custom-switch">
    		<input type="hidden" name="configuration" value="0">
		  <input type="checkbox" class="custom-control-input checkBtn" id="customSwitch1">
		  <label class="custom-control-label" for="customSwitch1">¿Desea permitir los comentarios anonimos?</label>
		</div>
    	</form>
    </div>
 
  @endif
@endsection

@push('scripts')
    <script type="text/javascript">
      var page;
      $(document).ready(function() {
      	
      	$(".checkBtn").change(function(event) {
      		if($(this).prop('checked')){
      			alert("activo");
      		}else{
      			alert("desactivado");
      		}
      	});
        // Set firts step configuration 
        nextStep(1);
        var first_step = (configurations[0].value) ? JSON.parse(configurations[0].value) : null;
        if (first_step) {
         /* first_step.columns.forEach(function(column) {
            $(`#column-${column}`).prop('checked', true);
            $('.column-select').append(`<option value="${column}">${column}</option>`);
          });
          $(`#primary-column option[value=${first_step.username}]`).attr('selected', 'selected');
          $(`#password-column option[value=${first_step.password}]`).attr('selected', 'selected');*/
        }
      

        /*$('.column-check').change(function(event) {
          if( $(this).prop('checked') ) {
              $('.column-select').append(`<option value="${$(this).val()}">${$(this).val()}</option>`);
          }else{
            $(`option[value="${$(this).val()}"]`).remove();
          }
        });*/

        $("#btn-next").click(function(event) {
          /* Act on the event */
          //alert("datos: "+str);
          var current_step = $(".status-steps.current").children('.list-steps');
          var panel = $($(current_step).attr('href'));
          var form = $(panel).children('form');
          var step =  parseInt($(current_step).attr('data-step'));
          var url = $(form).attr("action");
          var data = $(form).serialize();
          /*if (step == 1 && $('#primary-column').val() == $('#password-column').val()) {
            alert('The primary columns can not be the same');
            return false;
          }  */        

          ajaxProcess(url, data, function(output){
            if (output.is_error) {
            	alert("error: "+output.result);
            }else{

              steps[step] = output.result.value;
              // Add configuration if it already exists

              if (steps[step+1]) {
                var step_config = JSON.parse(steps[step+1]);
                switch (step+1){
                  case 1:
                    //
                  break;

                  case 2:
                  case 4:
                    // Select page selected
                    $(`#select-page-input option[value=${step_config.page}]`).attr('selected', 'selected');
                  break;

                }
              }
              

	                          
              // Add elements to view 
              if (step == 2 || step == 4 ) {
              	page = (output.result.value) ? JSON.parse(output.result.value).page : null;
              	//var step_config = JSON.parse(steps[5]);
              	//console.log("page: "+Object.values(steps));
              	//alert("Paso: "+step);
              	if (page != null && page > 0) {
                  loadEditor(page);
                 // alert("beforeStep: "+step);
                  editor.on('storage:load', function(e){
                 // alert("afetrStep: "+step);
                  	switch (step) {
                  		case 2:
                  			 if (!steps[3]) {
                  			 	//alert("Paso 2");
		                         var domComponents = editor.DomComponents;
		                         var account = domComponents.addComponent({
			                        type: 'module',
			                        module: 'Forum',
			                        tagName: 'div',
			                        removable: false, // Can't remove it
			                        draggable: true, // Can't move it
			                        copyable: false, // Disable copy/past
			                        style: {
			                          'padding': '1rem'
			                        }
			                      });

			                      var row = account.get('components').add({
			                        tagName: 'div',
			                        style: {
			                          'padding': '1rem'
			                        }
			                      });

			                      row.addClass('row');

			                      var leftColumn = row.get('components').add({
			                        tagName: 'div',
			                        style: {
			                          'padding': '1rem',
			                          'border-radius': '0.25rem',
			                          'border': '1px solid #dee2e6'
			                        }
			                      });

			                      leftColumn.addClass('hk-md-3 hk-lg-3');


			                      leftColumn.get('components').add({
			                        tagName: 'br'
			                      });

			                      var userImage = leftColumn.get('components').add({
			                        tagName: 'div',
			                        style: {
			                          'padding': '1rem',
			                          'text-align': 'center',
			                          'margin-bottom': '1.5rem'
			                        }
			                      });

			                      userImage.get('components').add({
			                        type: 'image',
			                        tagName: 'img',
			                        attributes: {
			                          'src': 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png'
			                        },
			                        style: {
			                          'width': '80px',
			                          'height': '80px',
			                          'border-radius': '50%',
			                          'border': '1px solid #6c757d',
			                        }
			                      });

			                       

		                      }
                  		break;

                  		case 4:
	                      	if (!steps[5]) {
                  			//alert("paso 4");
                  			var domComponents = editor.DomComponents;
	                           var table = domComponents.addComponent({
	                            tagName: 'table',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'width': '600px',
	                              'padding': '10px',
	                              'margin': '0 auto',
	                              'border-collapse': 'collapse'
	                            }
	                          });
	                           var tr = table.get('components').add({
	                            tagName: 'tr',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                          });

	                           var td = tr.get('components').add({
	                            tagName: 'td',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'background-color': '#ecf0f1',
	                              'text-align': 'left',
	                              'padding': '0'
	                            }
	                          });

	                          td.get('components').add({
	                          	type: "image",
	                          	tagName: 'img',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            attributes: {
	                              src: '',
	                              width: '10%',
	                            },
	                            style: {
	                              'margin': ' 1.5% 3%',
	                              'display' : 'block'
	                            }
	                          });

	                          var tr2 = table.get('components').add({
	                            tagName: 'tr',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                          });

	                          var td2 = tr2.get('components').add({
	                            tagName: 'td',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            attributes: {
	                              align: 'center',
	                            },
	                            style: {
	                              'padding': '0'
	                            }
	                          });

	                          td2.get('components').add({
	                            type: "image",
	                          	tagName: 'img',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            attributes: {
	                              src: '',
	                              width: '80%',
	                            },
	                            style: {
	                              'padding': ' 0',
	                              'display' : 'block'
	                            }
	                          });

	                          var tr3 = table.get('components').add({
	                            tagName: 'tr',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                          });

	                          var td3 = tr3.get('components').add({
	                            tagName: 'td',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'background-color': '#ecf0f1'
	                            }
	                          });
	                          var div = td3.get('components').add({
	                            tagName: 'div',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'color': '#34495e',
	                              'margin': '4% 10% 2%',
	                              'text-align': 'justify',
	                              'font-family': 'sans-serif'
	                            }
	                          });

	                          var dataStep = JSON.parse(steps[1]);
	                          /*var label;
	                           $.each(dataStep.dataTwo, function(index, val){
					              	$.each(val, function(index, val) {
					              		label = val.toLowerCase();
					              		div.get('components').add({
				                          tagName: 'label',
				                          content: label+' :',
				                        });
				                        div.get('components').add({
				                          type: 'variable',
				                          content: '${'+label+'}',
				                          removable: false,
				                          copyable: false,
				                        });
					              	console.log("label: "+label);
					              		  iterate through array or object  
					              	});

					              });*/
				               div.get('components').add({
				              		type: "text",
		                            tagName: 'h2',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: 'User: ${Usuario}!',
		                            style: {
		                              'color': '#e67e22',
		                              'margin': '0 0 7px' 
		                            }
	                          }); 

				             div.get('components').add({
				              		type: "text",
		                            tagName: 'p',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: "Message:  @if(isset($message)) $message @else ${message} @endif",
		                            style: {
		                              'margin': '2px',
		                              'font-size': '15px' 
		                            }
		                          }); 

	                          var ul = div.get('components').add({
	                            tagName: 'ul',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'font-size': '15px',
	                              'margin': '10px 0' 
	                            }
	                          });

	                          ul.get('components').add({
	                          	type: "text",
	                            tagName: 'li',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            content: 'Options Texts.' 
	                          });

	                          ul.get('components').add({
	                          	type: "text",
	                            tagName: 'li',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            content: 'Options Texts.' 
	                          });

	                          ul.get('components').add({
	                          	type: "text",
	                            tagName: 'li',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            content: 'Options Texts.' 
	                          });

	                          ul.get('components').add({
	                          	type: "text",
	                            tagName: 'li',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            content: 'Options Texts.' 
	                          });

	                          ul.get('components').add({
	                          	type: "text",
	                            tagName: 'li',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            content: 'Options Texts.' 
	                          });

	                          var div2 = div.get('components').add({
	                            tagName: 'div',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'width': '100%',
	                              'margin': '20px 0',
	                              'display': 'inline-block',
	                              'text-align': 'center'
	                            }
	                          });

	                          var div3 = div.get('components').add({
	                            tagName: 'div',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            style: {
	                              'width': '100%',
	                              'text-align': 'center'
	                            }
	                          });

	                           if (dataStep.remitente != null) {
	                           	div.get('components').add({
		                          	type: "text",
		                            tagName: 'p',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: dataStep.remitente+' Copyrigth!',
		                            style: {
		                              'color': '#b3b3b3',
		                              'font-size': '12px',
		                              'text-align': 'center',
		                              'margin': '30px 0 0'  
		                            }
		                          });
	                           }else{
	                           	div.get('components').add({
		                          	type: "text",
		                            tagName: 'p',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: 'Sitio Web Copyrigth!',
		                            style: {
		                              'color': '#b3b3b3',
		                              'font-size': '12px',
		                              'text-align': 'center',
		                              'margin': '30px 0 0'  
		                            }
		                          });
	                           }
	                          
	                      	}
                  		break;

                  		 
                    }
                  });
              	}
              }
        	     // Save view in database
              if (step == 3 || step == 5) {
                editor.store();
                //alert("Se guardo el paso: "+step);
              }

              nextStep(step+1);

            }
          });


        });

      });

    </script>
@endpush
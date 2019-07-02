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
		                         var container = domComponents.addComponent({
		                         	type: 'module',
		                            module: 'Forum',
		                            sentence : {
		                              'type': 'if',
		                              'option': 'testingMode',
		                              'value': 'Auth::guard("admins")->user()',
		                            },
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                          });

		                         container.addClass('container-fluid');

		                         var row = container.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                         });

		                         row.addClass('row');

		                         var rowhk2l = row.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                         });

		                         rowhk2l.addClass('hk-md-2');

		                         var rowhk8 = row.get('components').add({
		                         	
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'

		                         });

		                         rowhk8.addClass('hk-md-8');

		                         var card = rowhk8.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                         });

		                         card.addClass('card');

		                         var cardBody = card.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                         });

		                         cardBody.addClass('card-body');

		                         var h5 = cardBody.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            type: 'text',
		                            tagName: 'h5',
		                            content: "Titulo"  
		                         });

		                         h5.addClass('card-title');

		                         var p = cardBody.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'p',
		                            type: "text",
		                            content: "Some quick example text to build on the card title and make up the bulk of the card's content."  
		                         });

		                         p.addClass('card-text');

		                         var a = cardBody.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'a',
		                            type: "link",
		                            content: "Responder",
		                            attributes: {
		                            	href: "#",
		                            }
		                         });

		                         a.addClass('card-link');

		                         var rowhk2r = row.get('components').add({
		                         	removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            tagName: 'div'  
		                         });

		                         rowhk2r.addClass('hk-md-2');



		                         /*var logout = domComponents.addComponent({
		                            type: 'module',
		                            module: 'Forum',
		                            sentence : {
		                              'type': 'if',
		                              'option': 'testingMode',
		                              'value': 'Auth::guard("admins")->user()',
		                            },
		                            tagName: 'div',
		                            removable: false, // Can't remove it
		                            draggable: true, // Can't move it
		                            copyable: false, // Disable copy/past
		                            style: {
		                              'padding': '1rem'
		                            }
		                          });

		                         var formLogout = logout.get('components').add({
		                            type: 'form',
		                            tagName: 'form',
		                            attributes: {
		                              action: '{{ route('authentication.logout') }}',
		                              method: 'post',
		                            },
		                            removable: false, // Can't remove it
		                            draggable: true, // Can't move it
		                            copyable: false, // Disable copy/past
		                          });

		                          formLogout.get('components').add({
		                            tagName: 'button',
		                            type: 'submit',
		                            attributes: {
		                            	name: 'testing',
		                              	type: 'submit',
		                            },
		                            content: 'Logout',
		                          });*/

			                       

		                      }
                  		break;

                  		case 4:
	                      	if (!steps[5]) {
                  			//alert("paso 4");
                  			var domComponents = editor.DomComponents;
                  			
                  			var form = domComponents.addComponent({
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false, // Disable copy/past
	                            type: 'form',
		                            tagName: 'form',
		                            attributes: {
		                              action: '{{route("create.comments")}}',
		                              method: 'post',
		                            }    
	                          });

	                        var container = form.get('components').add({
	                            tagName: 'div',
	                            removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false // Disable copy/past    
	                          });

	                         container.addClass('container-fluid');

	                         var divtitle = container.get('components').add({
		                        tagName: 'div',
		                        removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false
		                      });

	                         divtitle.addClass('row');

	                         var divtitlehk = divtitle.get('components').add({
		                        tagName: 'div',
		                        removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        attributes: {'align': 'center'}
		                      });

	                          divtitlehk.addClass('hk-md-12');

	                          var divtitleh3 = divtitlehk.get('components').add({
		                        tagName: 'h3',
		                        type: 'text',
		                        removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        content: 'Crear Comentario'
		                      });
	                          
	                          divtitle.get('components').add({
	                          	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      divtitle.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      divtitle.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      var divform = container.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'div'
		                      });

	                         divform.addClass('row');

	                         var divformh4 = divform.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'div'
		                      });

	                         divformh4.addClass('hk-md-4');

	                         var divformh4M  = divform.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'div'
		                      });

	                         divformh4M.addClass('hk-md-4');

	                         divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'h5',
		                        type: 'text',
		                        content: 'Titulo'
		                      });

	                        var inputtitle = divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'input',
		                        attributes: {
		                        	'type':'text',
		                        	'name': 'title'},
		                        type: 'text'
		                      });

	                          inputtitle.addClass('form-control');

	                          divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

	                          divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'h5',
		                        type: 'text',
		                        content: 'Comentario'
		                      });

		                      var inputcoment = divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'textarea',
		                        attributes: {'name': 'comments'},
		                        style: {
		                        	'height':'250px'
		                        },
		                        type: 'text'
		                      });

	                          inputcoment.addClass('form-control');

	                          divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'br'
		                      });

		                      var btnpublish = divformh4M.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'button',
		                        content: 'Publicar!'
		                      });

		                      btnpublish.addClass('form-control btn-primary');


	                         var divformh4R = divform.get('components').add({
		                      	removable: false, // Can't remove it
	                            draggable: false, // Can't move it
	                            copyable: false,
		                        tagName: 'div'
		                      });

	                         divformh4R.addClass('hk-md-4');

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
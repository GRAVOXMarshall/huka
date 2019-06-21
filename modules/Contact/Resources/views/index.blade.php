@extends('extra.configurations')

@section('content')
  @if(!is_null($configurations) && count($configurations) > 0)
    <div class="tab-pane fade row" id="config-options" role="tabpanel">
    	 
    	 <form action="{{route('contact.configuration.test')}}" method="post">
    	 	@csrf
    	 	<input type="hidden" name="configuration" value="0">
    	 	<div class="container-fluid">
    	 		<div class="row">
    	 			<div class="col-md-6">
    	 				<h1>Mail Configuration</h1><br>
    	 				 
							<div class="accordion" id="accordionExample">

							  <div class="card">
							    <div class="card-header" id="headingOne">
							      <h2 class="mb-0">
							        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							          Configuración correo usuario
							        </button>
							      </h2>
							    </div>

							    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
							      <div class="card-body">
										<div class="row">
											<div class="col-md-12"><br>
												<label>Indique Emisor: </label><br>
												<input class="form-control" name="remiMsj">
											</div>
										</div><br>
										<h6>¿Desea mensaje automatico?</h6>
				    	 				<div class="btn-group btn-group-toggle" data-toggle="buttons">
											  <label class="btn btn-secondary">
											    <input type="radio" class="typeMsj" name="options" id="option2" value="Y"> Yes
											  </label>
											  <label class="btn btn-secondary">
											    <input type="radio" class="typeMsj" name="options" id="option3" value="N"> No
											  </label>
											</div>
										<div class="row msjText"  >
											<div class="col-md-12"><br>
												<label>Mensaje Automatico: </label><br>
												<textarea class="form-control" name="autoamticMsj"></textarea>
											</div>
										</div>
										
							      </div>
							    </div>
							  </div>
							  <div class="card">
							    <div class="card-header" id="headingTwo">
							      <h2 class="mb-0">
							        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							          Configuración correo propio
							        </button>
							      </h2>
							    </div>
							    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							      <div class="card-body">
							        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
							      </div>
							    </div>
							  </div>
							</div>


    	 			</div>
    	 			<div class="col-md-6">
    	 				<h1>Contact Form Configuration</h1><br>

    	 				<h6>Seleccione campos de contacto</h6>
				              <div class="custom-control custom-checkbox">
				                <input type="checkbox" class="column-check custom-control-input" name="checks[]" id="column-1 " value="Firstname" checked>
				                <label class="custom-control-label" for="column-1 ">Firstname</label>
				              </div>
				              <div class="custom-control custom-checkbox">
				                <input type="checkbox" class="column-check custom-control-input" name="checks[]" id="column-2 " value="Lastname" checked>
				                <label class="custom-control-label" for="column-2 ">Lastname</label>
				              </div>
				              <div class="custom-control custom-checkbox">
				                <input type="checkbox" class="column-check custom-control-input" name="checks[]" id="column-3 " value="Email" checked>
				                <label class="custom-control-label" for="column-3 ">Email</label>
				              </div>
				              <div class="custom-control custom-checkbox">
				                <input type="checkbox" class="column-check custom-control-input" name="checks[]" id="column-4 " value="Message" checked>
				                <label class="custom-control-label" for="column-4 ">Message</label>
				              </div><br>
		  						<div >Campos seleccionados: <span id="str"></span></div> 
    	 			</div>
    	 		</div>
    	 	</div>
    	 </form>
    	 
    			 
    				 
    		 
    	 
    	 
    </div>
    <div class="tab-pane fade" id="choose-desing" role="tabpanel">
    	<h1>hola choose-desing!</h1>
    	
    </div>
 
  @endif
@endsection

@push('scripts')
    <script type="text/javascript">
      var page;
      var str;
      $(document).ready(function() {
      	$(".msjText").hide();
		$(".typeMsj").change(function(event) {
			if($(this).prop('checked')){
				if ($(this).val() === "Y") {
					$(".msjText").show();
				}else{
					$(".msjText").hide();
				}
			}
		});
		 $('[name="checks[]"]').click(function() {
      
		    var arr = $('[name="checks[]"]:checked').map(function(){
		      return this.value;
		    }).get();
		    
		   	str = arr.join(',');
		    
		    //$('#arr').text(JSON.stringify(arr));
		    
		    $('#str').text(str);
		  
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
                  case 6:
                    // Select page selected
                    $(`#select-page-input option[value=${step_config.page}]`).attr('selected', 'selected');
                  break;

                }
              }
              

	                          
              // Add elements to view 
              if (step == 2 || step == 4 || step == 6) {
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
		                          var login = domComponents.addComponent({
		                            tagName: 'div',
		                            removable: false, // Can't remove it
		                            draggable: true, // Can't move it
		                            copyable: false, // Disable copy/past
		                            style: {
		                              'width': '50%',
		                               
		                              'padding': '1rem'
		                            }
		                          });

		                          var formLogin = login.get('components').add({
		                            type: 'form',
		                            tagName: 'form',
		                            attributes: {
		                              action: '{{ route('contact.send.mail') }}',
		                              method: 'post',
		                            },
		                            removable: false, // Can't remove it
		                            draggable: true, // Can't move it
		                            copyable: false, // Disable copy/past
		                          });

		                          formLogin.get('components').add({
		                            type: 'text',
		                            content: 'Contact!', // Text inside component
		                            attributes: { title: 'Sign In With!'},
		                            style: {
		                              'font-size': '30px',
		                              'border-bottom': '10px'
		                            }
		                          });

		                          var inputs;
		                          var dataStep = JSON.parse(steps[1]); 

		                          if ( $.isEmptyObject(dataStep.data) ) {
								  	inputs = formLogin.get('components').add({
				                            tagName: 'div',
				                            style: { 
				                              'margin-bottom': '1rem',
				                            }
				                          });

									 	inputs.get('components').add([
			                            {
			                              type: 'text',
			                              content: "<br><h6>Ningun campo seleccionado!</h6>",
			                              style: {
				                              'color': 'gray'
				                            }
			                               
			                            },
			                             
			                          ]);
								  }else{
								  	$.each(dataStep.data, function(index, val){

								  		if (val == "Message") {
									 		inputs = formLogin.get('components').add({
					                            tagName: 'div',
					                            style: { 
					                              'margin-bottom': '1rem',
					                            }
					                          });

										 	inputs.get('components').add([
				                            {
				                              type: 'text',
				                              content: val,
				                              attributes: { 
				                                for: 'input-'+val
				                              },
				                            },
				                            {
				                              tagName: 'textarea',
				                              type: 'text',
				                              attributes: { 
				                                id: 'input-'+val,
				                                name: val,
				                                type: 'text'
				                              },
				                              style: { 
				                                'width': '100%',
				                                'height': 'calc(1.5em + 0.75rem + 2px)',
				                                'padding': '0.375rem 0.75rem',
				                                'font-size': '1rem',
				                                'font-weight': '400',
				                                'line-height': '1.5',
				                                'color': '#495057',
				                                'background-color': '#fff',
				                                'background-clip': 'padding-box',
				                                'border': '1px solid #ced4da',
				                                'border-radius': '0.25rem',
				                                'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
				                              }
				                            },
				                          ]);
									 	}

									 	if(val != "Message"){
									 		inputs = formLogin.get('components').add({
					                            tagName: 'div',
					                            style: { 
					                              'margin-bottom': '1rem',
					                            }
					                          });

										 	inputs.get('components').add([
				                            {
				                              type: 'text',
				                              content: val,
				                              attributes: { 
				                                for: 'input-'+val
				                              },
				                            },
				                            {
				                              tagName: 'input',
				                              type: 'text',
				                              attributes: { 
				                                id: 'input-'+val,
				                                name: val,
				                                type: 'text'
				                              },
				                              style: { 
				                                'width': '100%',
				                                'height': 'calc(1.5em + 0.75rem + 2px)',
				                                'padding': '0.375rem 0.75rem',
				                                'font-size': '1rem',
				                                'font-weight': '400',
				                                'line-height': '1.5',
				                                'color': '#495057',
				                                'background-color': '#fff',
				                                'background-clip': 'padding-box',
				                                'border': '1px solid #ced4da',
				                                'border-radius': '0.25rem',
				                                'transition': 'border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
				                              }
				                            },
				                          ]);
									 	}
								  	});
									
									formLogin.get('components').add({
		                            tagName: 'button',
		                            type: 'submit',
		                            attributes: {
		                              type: 'submit',
		                            },
		                            content: 'Sign in',
		                            style: { 
		                              'color': '#fff',
		                              'background-color': '#007bff',
		                              'border-color': '#007bff',
		                              'display': 'inline-block',
		                              'font-weight': '400',
		                              'text-align': 'center',
		                              'vertical-align': 'middle',
		                              '-webkit-user-select': 'none',
		                              '-moz-user-select': 'none',
		                              '-ms-user-select': 'none',
		                              'user-select': 'none',
		                              'border': '1px solid transparent',
		                              'padding': '0.375rem 0.75rem',
		                              'font-size': '1rem',
		                              'line-height': '1.5',
		                              'border-radius': '0.25rem',
		                              'transition': 'color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out'
		                            }
		                          });
								  } 
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

                  		case 6:
	                      	if (!steps[7]) {
                  			//alert("paso 6");
                  			 
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
	                           
				              	div.get('components').add({
				              		type: "text",
		                            tagName: 'h2',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: 'Hola $Usuario!',
		                            style: {
		                              'color': '#e67e22',
		                              'margin': '0 0 7px' 
		                            }
	                          });
				             

				              if (dataStep.automatic != null && dataStep.remitente != null) {
				              	div.get('components').add({
		                            tagName: 'p',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: "hi we're <strong>"+dataStep.remitente+"</strong>, "+dataStep.automatic,
		                            style: {
		                              'margin': '2px',
		                              'font-size': '15px' 
		                            }
		                          });
				              }else{
				              	div.get('components').add({
				              		type: "text",
		                            tagName: 'p',
		                            removable: false, // Can't remove it
		                            draggable: false, // Can't move it
		                            copyable: false, // Disable copy/past
		                            content: "hi we 're $remitente, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.<br> Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur.<br> Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
		                            style: {
		                              'margin': '2px',
		                              'font-size': '15px' 
		                            }
		                          });
				              }

	                          

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
              if (step == 3 || step == 5 || step == 7) {
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
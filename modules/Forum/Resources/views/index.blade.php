@extends('extra.configurations')

@section('content')
  @if(!is_null($configurations) && count($configurations) > 0)
    <div class="tab-pane fade" id="config-database" role="tabpanel">
      <form action="{{ route('forum.configuration.database') }}" method="post">
        @csrf
        <input type="hidden" name="configuration" value="0">
        <h4>1.- Select the values of the tables you want to use</h4>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="input-columns">Users</label>
            @foreach($columns_users as $column)
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="columns_users[]" id="user-column-{{ $column }}" value="{{ $column }}">
                <label class="custom-control-label" for="user-column-{{ $column }}">{{ $column }}</label>
              </div>
            @endforeach
          </div>
          <div class="form-group col-md-4">
            <label for="input-columns">Topics <a href="#" data-toggle="tooltip" data-placement="right" title="Add Column"><i class="fas fa-plus text-primary" data-toggle="modal" data-target="#exampleModal"></i></a></label>
            @foreach($columns_topics as $column)
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="topic-column-check custom-control-input" name="columns_topics[]" id="topic-column-{{ $column }}" value="{{ $column }}">
                <label class="custom-control-label" for="topic-column-{{ $column }}">{{ $column }}</label>
              </div>
            @endforeach
          </div>
          <div class="form-group col-md-4">
            <label for="input-columns">Coments</label>
            @foreach($columns_comments as $column)
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="columns_comments[]" id="comment-column-{{ $column }}" value="{{ $column }}">
                <label class="custom-control-label" for="comment-column-{{ $column }}">{{ $column }}</label>
              </div>
            @endforeach
          </div>
        </div>
        <h4>2.- Select the extra options</h4>
        <div class="form-row">
          <div class="form-group col-md-6">
			<label>Select the value of topic that you want to show in the list of these</label>
				<select id="topic-column" class="form-control column-select" name="topic_column">
			</select>
          </div>
          <div class="form-group col-md-5 offset-md-1">
          	<label>Activate functions to</label>
			<div class="custom-control custom-checkbox">
				<input id="reply_comments" class="custom-control-input" type="checkbox" name="reply_comments">
				<label class="custom-control-label" for="reply_comments">Allow reply comments</label>
			</div>
			<div class="custom-control custom-checkbox">
				<input id="anonymous_user" class="custom-control-input" type="checkbox" name="anonymous_user">
				<label class="custom-control-label" for="anonymous_user">Allow use of anonymous users</label>
			</div>
          </div>
        </div>
      </form>
    </div>

 	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add new column</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-md-12" align="center">
	      			<h5>Select the type: </h5>
	      			<div class="btn-group btn-group-toggle" data-toggle="buttons">
					  <label class="btn btn-outline-primary active">
					    <input type="radio" name="options" id="String" value="String" checked> String
					  </label>
					  <label class="btn btn-outline-primary">
					    <input type="radio" name="options" id="Integer" value="Integer"> Integer
					  </label>
					  <label class="btn btn-outline-primary">
					    <input type="radio" name="options" id="LongText" value="LongText"> LongText
					  </label>
					  <label class="btn btn-outline-primary">
					    <input type="radio" name="options" id="Float" value="Float"> Float
					  </label>
					  <label class="btn btn-outline-primary">
					    <input type="radio" name="options" id="Text" value="Text"> Text
					  </label>
					</div><br><br>
	      			<h5>Name: </h5> 
					<input type="text" class="column form-control">
	      		</div>
	      	</div>
	      </div>
	      <div class="modal-footer">
	         
	        <button type="button" class="btn btn-primary addTopic" >Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>
  @endif
@endsection

@push('scripts')
	<script type="text/javascript">
		var page;
		$(document).ready(function() {
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
			$(".addTopic").click(function(event) {
				var typeCol = $("input[name='options']:checked").val();
				var column = $(".column").val()
				console.log("type: "+typeCol);
				  $.ajax({
		               type:'POST',
		               url:'{{ route("add.topic") }}',
		               data:{column: column ,type: typeCol ,"_token": $("meta[name='csrf-token']").attr("content")},
		               success:function(data) {
		               	 
		               	if (data.msg == 0) {
		               		location.reload();
		               	}else{
		               		alert("This column already exists!");
		               		location.reload();
		               	}
		               	//console.log(data);
		                  
		               }
		            });  
		       
				//console.log("add topic");
			});
			// Set firts step configuration 
			nextStep(1);
			var first_step = (configurations[0].value) ? JSON.parse(configurations[0].value) : null;
			if (first_step) {
				console.log(first_step);
				first_step.users.forEach(function(column) {
					$(`#user-column-${column}`).prop('checked', true);
				});

				first_step.topics.forEach(function(column) {
					$(`#topic-column-${column}`).prop('checked', true);
					$('#topic-column').append(`<option value="${column}">${column}</option>`);
				});

				first_step.comments.forEach(function(column) {
					$(`#comment-column-${column}`).prop('checked', true);
				});

				if (first_step.replys) {
					('#reply_comments').prop('checked', true);
				}

				if (first_step.anonymous) {
					$('#anonymous_user').prop('checked', true);
				}

			}


			$('.topic-column-check').change(function(event) {
				if( $(this).prop('checked') ) {
					$('#topic-column').append(`<option value="${$(this).val()}">${$(this).val()}</option>`);
				}else{
					$(`option[value="${$(this).val()}"]`).remove();
				}
			});


			$("#btn-next").click(function(event) {
				/* Act on the event */
				var current_step = $(".status-steps.current").children('.list-steps');
				var panel = $($(current_step).attr('href'));
				var form = $(panel).children('form');
				var step =  parseInt($(current_step).attr('data-step'));
				var url = $(form).attr("action");
				var data = $(form).serialize();        

				// Validate that a page or a layout has been selected
				if (step == 2 || step == 4 || step == 6) {
					var option = $('input:radio[name=content_option]:checked').val();
					if (option == 'page' && !$('#select-page-input').val()) {
						alert('You must select a page to continue');
						return false;
					}
					if (option == 'layout' && !$('#select-layout-input').val()) {
						alert('You must select a layout to continue');
						return false;
					}
				}

				ajaxProcess(url, data, function(output){
					if (output.is_error) {
						alert("error: "+output.result);
					}else{

						steps[step] = output.result.value;
						// Add configuration if it already exists

						if (steps[step+1]) {
							var step_config = JSON.parse(steps[step+1]);
						}
						// Add elements to view 
						if (step == 2 || step == 4 || step == 6 ) {
							page = (output.result.value) ? JSON.parse(output.result.value).page : null;
							if (page != null && page > 0) {
								loadEditor(page);
								editor.on('storage:load', function(e){
									switch (step) {
										case 2:
											if (!steps[3]) {

												var dataStep = JSON.parse(steps[1]);
												var domComponents = editor.DomComponents;
												var container = domComponents.addComponent({
													type: 'module',
													module: 'Forum',
													removable: false, // Can't remove it
													draggable: false, // Can't move it
													copyable: false, // Disable copy/past
													tagName: 'div'  
												});

												container.get('components').add({
													type: 'text',
													tagName: 'h4',
													content: "Topics"
												});

												var container_topic = container.get('components').add({
													removable: false, // Can't remove it
													copyable: false, // Disable copy/past
													tagName: 'div',
													sentence : {
														'type': 'foreach',
														'option': 'topics',
													},
													classes: ['shadow', 'p-3', 'mb-5', 'bg-white rounded'],
												});


												var row = container_topic.get('components').add({
													removable: false, // Can't remove it
													copyable: false, // Disable copy/past
													tagName: 'div',
													classes: ['row', 'd-flex', 'align-items-center'],
												});

												var column_link = row.get('components').add({
													removable: false, // Can't remove it
													copyable: false, // Disable copy/past
													tagName: 'div',
													classes: ['hk-8'],
												});

												var btn_link = column_link.get('components').add({
													tagName: 'a',
													type: 'link',
													editable: false,
													attributes: {
														reference: 'topic',
														href: '#',
													},
													removable: false, // Can't remove it
												});

												btn_link.get('components').add({
													tagName: 'label',
													type: 'variable',
													content: '${'+dataStep.topic_column+'}',
													removable: false,
													copyable: false,
												});

												var column_name = row.get('components').add({
													removable: false, // Can't remove it
													copyable: false, // Disable copy/past
													tagName: 'div',
													attributes: {
														align: "right",
													},
													classes: ['hk-4'],
												});

												$.each(dataStep.users, function(index, column) {
													column_name.get('components').add({
														type: 'variable',
														tagName: 'label',
														content: '${'+column+'}',
														removable: false,
														copyable: false,
													});
												});

											}
										break;

										case 4:
											if (!steps[5]) {
												var domComponents = editor.DomComponents;
												var dataStep = JSON.parse(steps[1]);
												var domComponents = editor.DomComponents;
												var addTopic = domComponents.addComponent({
													type: 'module',
													module: 'Forum',
													tagName: 'div',
													removable: false, // Can't remove it
													draggable: true, // Can't move it
													copyable: false, // Disable copy/past
													style: {
														'width': '100%',
														'padding': '1rem'
													}
												});
												var form = addTopic.get('components').add({
													type: 'form',
													tagName: 'form',
													attributes: {
														action: '{{ route('forum.add.topic') }}',
														method: 'post',
													},
													removable: false, // Can't remove it
													draggable: true, // Can't move it
													copyable: false, // Disable copy/past
												});

												var title = form.get('components').add({
													tagName: 'h3',
													type: 'text',
													content: 'Add Topic!'
												});

												var divform = form.get('components').add({
													removable: false, // Can't remove it
													draggable: false, // Can't move it
													copyable: false,
													tagName: 'div',
													classes: ['row'],
												});


												$.each(dataStep.topics, function(index, val) {

													var divinput = divform.get('components').add({
														removable: false, // Can't remove it
														copyable: false,
														tagName: 'div',
														classes: ['form-group'],
													});

													divinput.get('components').add({
														tagName: 'label',
														content: val,
														attributes: {
															for: `input_${val}`
														}
													});

													divinput.get('components').add({
														removable: false, // Can't remove it
														copyable: false,
														tagName: 'input',
														type: 'input',
														attributes: {
															'type':'text',
															'name': val
														},
														classes: ['form-control'],
													});

												});

												divform.get('components').add({
													removable: false, // Can't remove it
													copyable: false,
													tagName: 'button',
													attributes: {
														'type':'submit',
													},
													classes: ['form-control', 'btn-primary'],
													content: 'Send!'
												});

											}
										break;

										case 6:
											if (!steps[7]) {
												//alert("paso 4");
												var options = JSON.parse(steps[1]);
												var domComponents = editor.DomComponents;
												var container = domComponents.addComponent({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false, // Disable copy/past
												tagName: 'div',
												classes: ['container-fluid']   
												});

												var rowTitle = container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["row"]
												});

												rowTitle.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												var colTitle = rowTitle.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-8"]
												});

												$.each(options.topics, function(index, val) {
												/* iterate through array or object */
												if (val === "title") {
												var title = colTitle.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'h2',
												type: "variable",
												content: '${'+val+'}'

												});
												}
												});

												rowTitle.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br'
												});

												var rowOptions = container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["row"]
												});

												rowOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												var colOptions = rowOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-8"]
												});

												$.each(options.topics, function(index, val) {
												/* iterate through array or object */
												if (val != "title") {
												colOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'strong',
												type: "text",
												content: val+": "
												});

												colOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'label',
												type: "variable",
												content: '${'+val+'}'
												});

												colOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br' 
												});
												}
												});



												rowOptions.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br' 
												});

												var rowComent = container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["row"]
												});

												rowComent.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												var textComent = rowComent.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-8"]
												});

												var con = textComent.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'strong' 

												});

												con.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'h4',
												type: "text",
												content: "Comments" 

												});

												rowComent.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]
												});

												container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br' 
												});

												var rowUser = container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["row"] 
												});

												rowUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"] 
												});

												var colUser = rowUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-8"] 
												});


												/** 
												Aqui debes colocar el foreach para mostrar los comentarios que se han hecho a un topico.
												**/
												var divUser = colUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												style: {
												'max-width' : '100%'
												},
												classes: ['card', 'bg-light', 'mb-3'] 
												});

												var nameUser = divUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['card-header'] 
												});
												$.each(options.users, function(index, data) {
												/* iterate through array or object */ 
												nameUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'label',
												type: "variable",
												content: '${'+data+'}' 
												});

												});

												var divConUser = divUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['card-body'] 
												});

												divConUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'p',
												type: "text",
												content: "Some quick example text to build on the card title and make up the bulk of the card's content.",
												classes: ['card-text'] 
												});


												rowUser.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ["hk-md-2"]  
												});

												container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br' 
												});

												var form = container.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'form',
												attributes: {
												action: "#",
												method: "post",
												} 
												});


												var divNewCom = form.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['row']
												});

												divNewCom.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['hk-md-2']
												});

												var colCom = divNewCom.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['hk-md-8']
												});

												var stroText = colCom.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'strong' 
												});

												stroText.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'h4',
												type: "text",
												content: "New Comment: "
												});

												colCom.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'textarea',
												attributes: {
												name: "comment"
												},
												classes: ['form-control']
												});


												divNewCom.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['hk-md-2']
												});

												form.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'br'
												});

												var rowbtn = form.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['row']
												});

												rowbtn.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['hk-md-2']
												});

												var colBtn = rowbtn.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												attributes: {
												align: "right",
												},
												classes: ['hk-md-8']
												});

												colBtn.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'button',
												type: "submit",
												content: "Submit!",
												classes: ['btn-primary']
												});

												rowbtn.get('components').add({
												removable: false, // Can't remove it
												draggable: false, // Can't move it
												copyable: false,
												tagName: 'div',
												classes: ['hk-md-2']
												});

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
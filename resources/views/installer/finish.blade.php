@extends('installer.index')

@section('content')
	<h3>Finalizing the installation</h3>
    <div class="mt-3">
		<div id="alert-error" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
			<label id="alert-menssage"></label>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
        <div class="progress">
            <div id="installer-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">20%</div>
        </div>
        <small id="installer-description">Installing basic configurations...</small>
    </div>
    <script type="text/javascript">
    	$(document).ready(function() {
    		setConfiguration('initial');
    	});

    	function setConfiguration(configuration)
    	{
    		$.ajax({
	          url: '{{ route('ajax.set.configuration') }}',
	          type: 'POST',
	          data: { 
	          	config: configuration, 
	          	_token: token
	          },
	          success: function(response){
	          	console.log(response);
	          	if (response.status != 'success') {
	          		
	          	}else{
	          		var currentVal = parseInt($('#installer-bar').attr('aria-valuenow'));
	          		var nextVal = currentVal + 20;
	          		$('#installer-bar').attr('aria-valuenow', nextVal);
	          		$('#installer-bar').css('width', `${nextVal}%`);
	          		$('#installer-bar').html(`${nextVal}%`);
	          		if (nextVal == 100) {
	          			$('#installer-bar').addClass('bg-success');
	          			window.location.replace('/');
	          		}

	          		switch(configuration)
			        {
			        	case 'initial':
			        		$("#installer-description").text('Assigning default values ​​for the system...');
			        		setConfiguration('setvalues');
			        		break;

			        	case 'setvalues':
			        		$("#installer-description").text('Assigning main user to the system...');
			        		setConfiguration('mainuser');
			        		break;

			        	case 'mainuser':
			        		$("#installer-description").text('Finishing installation...');
			        		setConfiguration('finish');
			        		break;

			        	default:

			        		break;
			        }

	          	}

	          },
	          error: function(XMLHttpRequest, textStatus, errorThrown) {
	          	$('#alert-error').show('slow/400/fast');
          		$('#alert-menssage').html(XMLHttpRequest.responseJSON.message);
          		console.log(textStatus);
	            console.log(XMLHttpRequest);
	          }  
	        });

    	}
    </script>
@endsection
@extends('installer.index')

@section('content')
	<h3>Finalizing the installation</h3>
    <div class="mt-3">
        <div class="progress">
            <div id="installer-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">20%</div>
        </div>
        <small id="installer-description"></small>
    </div>
    <script type="text/javascript">
    	$(document).ready(function() {
    		setConfiguration('initial', 'Installing basic configurations...');
    	});

    	function setConfiguration(configuration, description)
    	{
    		$('#installer-description').html(description);

    		$.ajax({
	          url: '{{ route('ajax.set.configuration') }}',
	          type: 'POST',
	          data: { 
	          	config: configuration, 
	          	_token: token
	          },
	          success: function(response){
	          	if (response.status != 'success') {
	          		console.log(response);
	          	}else{
	          		var currentVal = parseInt($('#installer-bar').attr('aria-valuenow'));
	          		var nextVal = currentVal + 20;
	          		$('#installer-bar').attr('aria-valuenow', nextVal);
	          		$('#installer-bar').css('width', `${nextVal}%`);
	          		$('#installer-bar').html(`${nextVal}%`);
	          	}

	          },
	          error: function(XMLHttpRequest, textStatus, errorThrown) { 
	            console.log(XMLHttpRequest);
	          }  
	        });

	        switch(configuration)
	        {
	        	case 'initial':
	        		setConfiguration('setvalues', 'Assigning default values ​​for the system...');
	        	break;

	        	case 'setvalues':
	        		setConfiguration('mainuser', 'Assigning main user to the system...');
	        	break;
	        }
    	}
    </script>
@endsection
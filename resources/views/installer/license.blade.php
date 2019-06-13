@extends('installer.index')

@section('content')
	<h3>License agreements</h3>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum convallis iaculis convallis. Integer quis mauris nec lorem porta ornare sed sed tellus. Curabitur molestie vitae neque sed luctus. In consequat leo magna, eget egestas dolor posuere quis. Suspendisse elementum eros eu elementum scelerisque. Nam tincidunt risus at quam luctus semper. In at libero imperdiet magna interdum vestibulum quis non est. Morbi vel condimentum urna.
    </p>
    <div class="mb-3" style="height:200px; border:1px solid #ccc; margin-bottom:8px; padding:5px; background:#fff; overflow: auto; overflow-x:hidden; overflow-y:scroll;">
        <p>
            Vivamus ut pharetra sem. Suspendisse condimentum massa lobortis metus tristique lacinia. Vivamus facilisis malesuada consequat. Maecenas vulputate, sem vulputate pulvinar bibendum, sem turpis vehicula ante, sed scelerisque erat mauris nec tellus. Vestibulum sed commodo elit. Aenean felis mauris, faucibus sed neque gravida, lobortis pharetra ex. Etiam blandit nulla lectus, ut elementum mauris facilisis id. Duis bibendum ante eget quam vestibulum, id tempor leo fermentum. Cras consectetur velit vitae ex lobortis, sed fringilla neque vehicula. In vestibulum orci vitae est dictum egestas. Nunc lectus nisi, cursus eget nisi in, porttitor pharetra est. Cras hendrerit finibus tortor, sed iaculis leo suscipit gravida. Donec iaculis lectus pulvinar, bibendum eros a, maximus nibh.
        </p>
        <p>
            Maecenas vel magna risus. Curabitur lorem augue, interdum in ultrices vitae, cursus a nibh. Nullam hendrerit, lacus eget convallis fringilla, nulla tortor bibendum mi, vel tincidunt odio est vel ex. Morbi elementum eget ex pharetra laoreet. Duis tempor at justo et mattis. Etiam quis sapien sodales, porta leo vitae, lobortis leo. Cras ornare tortor enim, ut lacinia ipsum fermentum a. Quisque maximus, metus eu convallis egestas, mi mi tempus nibh, non eleifend eros justo at orci.
        </p>
    </div>
    <form method="post" action="{{ route('agree.terms') }}">
    	@csrf
        <div class="form-group form-check mb-4">
            <input type="checkbox" id="terms" class="form-check-input" name="terms" required>
            <label class="form-check-label" for="terms">I agree to the above terms and conditions.</label>
        </div>
        <div class="row justify-content-between">
            <div class="col-6 text-left">
            </div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-primary" style="padding: 0 30px;">Next</button>
            </div>
        </div>
    </form>
@endsection
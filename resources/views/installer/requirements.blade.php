@extends('installer.index')

@section('content')
	<h3>System compatibility</h3>
    <div class="mb-3">
        @foreach($requirements['requirements'] as $type => $requirement)
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>
                        {{ ucfirst($type) }}
                        @if($type == 'php')
                            <small>
                                (version {{ $phpSupportInfo['minimum'] }} required)
                            </small>
                        @endif
                    </strong>
                    <span class="text-{{ $phpSupportInfo['supported'] ? 'success' : 'danger' }}">
                        @if($type == 'php')
                            {{ $phpSupportInfo['current'] }} 
                        @endif
                        <i class="far fa-fw fa-{{ $phpSupportInfo['supported'] ? 'check-circle' : 'times-circle' }}"></i>
                    </span>
                </li>
                @foreach($requirements['requirements'][$type] as $extention => $enabled)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $extention }}
                        <span class="text-{{ $enabled ? 'success' : 'danger' }}">
                            <i class="far fa-fw fa-{{ $enabled ? 'check-circle' : 'times-circle' }}"></i>
                        </span>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
    @if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] )
        <div class="row justify-content-between">
            <div class="col-6 text-left">
                <a href="#" class="btn btn-outline-secondary" style="padding: 0 30px;">Back</a>
            </div>
            <div class="col-6 text-right">
                <a href="{{ url('/install/information') }}" class="btn btn-primary" style="padding: 0 30px;">Next</a>
            </div>
        </div>
    @endif
@endsection
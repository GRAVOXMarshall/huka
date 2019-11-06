<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('js/app.js') }}"></script>
        <style type="text/css">
            .step-list{
                padding: 5px;
            }
            .icon-step{
                margin-right: 5px;
            }
        </style>
    </head>
    <body>
        <br>

        <div class="container">
          <div class="row bg-white p-4">
            <div class="col-12 mb-4">
                <h1>Installation Assistant</h1>
            </div>
            <div class="col-3">
            <ul class="list-group" style="list-style-type:none; font-size: 1rem;">
                <li class="text-muted mb-3">
                    <i class="fa fa-check text-success fa-fw "></i><a href="#">License agreements</a>
                </li>
                <li class="text-primary mb-3">
                    <i class="fas fa-caret-right fa-fw "></i><a href="#">System compatibility</a>
                </li>
                <li class="text-muted mb-3">
                    <i class="fas fa-caret-right fa-fw "></i><a href="#">Web Information</a>
                </li>
                <li class="text-muted mb-3">
                    <i class="fas fa-caret-right fa-fw "></i><a href="#">System configuration</a>
                </li>
                <li class="text-muted mb-3">
                    <i class="fas fa-caret-right fa-fw "></i><a href="#">Web installation</a>
                </li>
            </ul>
            </div>
            <div class="col-9">
                <div class="content" style="min-height: 400px;">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
            const token = axios.defaults.headers.common['X-CSRF-TOKEN'];
            
            $('.display-sign').click(function(event) {
                /* Act on the event */
                var content = $(this).attr('href');
                $('#sign-input').val(content);
                $('.sign-content').hide('slow/400/fast');
                $(content).show('slow/400/fast');
            });
        </script>
    </body>
</html>

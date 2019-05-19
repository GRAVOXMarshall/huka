@extends('back.index')

@section('dash-content')
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Template</h1>
        @if(Auth::guard('admins')->user())
          {{ Auth::guard('admins')->user()->email }}
        @endif
      </div>
      <div class="row">
        @if($data === "N")
          <h3>No se encontraron datos</h3>
        @else
        <div class="col-md-12">
           @if(session()->has('txt'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('txt') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          </div>
          <div class="col-md-12">
        @endif 
        @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
        @endif
      </div>

            
                              
              @foreach($data as $template)
                @foreach($dataWeb as $infoWeb)
                  @if($template['id'] === $infoWeb->id && $infoWeb->domain === $web->domain)
                    <div class="col-md-6" align="center">
                       <div class="card mb-3">

                            <div class="card-body p-4">
                              <!-- Details -->
                              <div class="media d-block d-sm-flex">
                                <div class="u-avatar mb-3 mb-sm-0 mr-3">
                                  <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                                </div>

                                <div class="media-body">
                                  <!-- Header -->
                                  <div class="mb-4">
                                    <h3 class="h5 mb-0">
                                      <a href="#">{{$template['name']}}</a>
                                    </h3>

                                    <!-- Review -->
                                    <a class="d-inline-block small" href="#">
                                      <span class="text-warning">
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="far fa-star"></span>
                                        <span class="far fa-star"></span>
                                      </span>
                                      <span class="text-dark font-weight-semi-bold ml-2">@if($template['place'] === "F") Front-End @else Back-End @endif</span>
                                    </a>
                                    <!-- End Review -->
                                  </div>
                                  <!-- End Header -->
                              @if($softwareTemplate && in_array($template['name'], array_column($softwareTemplate->toArray(), 'name')))
                                @foreach($softwareTemplate as $soft)
                                  @if($soft->name === $template['name'])
                                    @if($soft->active === 0)
                                    <div class="d-flex align-items-center">

                                    <div class="u-ver-divider pr-3 mr-3">
                                    <form action="{{ route('update.template') }}" method="post">
                                      @csrf
                                      <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="tem_id">
                                      <button class="btn btn-danger" style="width: 112px;">Deactivate</button>
                                    </form>
                                    </div>
                                    <div class="u-ver-divider pr-3 mr-3">
                                    <form action="{{ route('delete.template') }}" method="post">
                                      @csrf
                                      <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="delete_tem_id">
                                      <button class="btn btn-primary" style="width: 112px;">Uninstall</button>
                                    </form>
                                    </div>

                                    </div>

                                    @endif
                                    @if($soft->active === 1)
                                    <div class="d-flex align-items-center">

                                    <div class="u-ver-divider pr-3 mr-3">
                                      <form action="{{ route('update.template') }}" method="post">
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="tem_id">
                                        <button class="btn btn-success" style="width: 112px;">Activate</button>
                                      </form>
                                      </div>
                                    <div class="u-ver-divider pr-3 mr-3">
                                      <form action="{{ route('delete.template') }}" method="post">
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="delete_tem_id">
                                        <button class="btn btn-primary" style="width: 112px;">Uninstall</button>
                                      </form>
                                      </div>

                                    </div>
                                    @endif
                                  @endif
                                @endforeach
                              @else
                                <form action="{{ route('install.template') }}" method="post" >
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($template['id']) }}" name="tem_id">
                                        <button class="btn btn-primary" style="width: 112px;">Install</button>
                                </form>
                              @endif
                              </div>
                            </div>
                            <!-- End Details -->
                          </div>
                        </div>
                      </div>
                  @endif
                @endforeach
                @if(!in_array($template['id'], array_column($dataWeb, 'id')) && $template['price'] == 0)
                <div class="col-md-6" align="center">
                       <div class="card mb-3">

                            <div class="card-body p-4">
                              <!-- Details -->
                              <div class="media d-block d-sm-flex">
                                <div class="u-avatar mb-3 mb-sm-0 mr-3">
                                  <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                                </div>

                                <div class="media-body">
                                  <!-- Header -->
                                  <div class="mb-4">
                                    <h3 class="h5 mb-0">
                                      <a href="#">{{$template['name']}}</a>
                                    </h3>

                                    <!-- Review -->
                                    <a class="d-inline-block small" href="#">
                                      <span class="text-warning">
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="far fa-star"></span>
                                        <span class="far fa-star"></span>
                                      </span>
                                      <span class="text-dark font-weight-semi-bold ml-2">@if($template['place'] === "F") Front-End @else Back-End @endif</span>
                                    </a>
                                    <!-- End Review -->
                                  </div>
                                  <!-- End Header -->
                                <form action="{{ route('install.template') }}" method="post" >
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($template['id']) }}" name="tem_id">
                                        <button class="btn btn-primary" style="width: 112px;">Download</button>
                                </form>
                              </div>
                            </div>
                            <!-- End Details -->
                          </div>
                        </div>
                      </div>
                @endif
                @if(!in_array($template['id'], array_column($dataWeb, 'id')) && $template['price'] != 0)
                  <div class="col-md-6" align="center">
                       <div class="card mb-3">

                            <div class="card-body p-4">
                              <!-- Details -->
                              <div class="media d-block d-sm-flex">
                                <div class="u-avatar mb-3 mb-sm-0 mr-3">
                                  <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                                </div>

                                <div class="media-body">
                                  <!-- Header -->
                                  <div class="mb-4">
                                    <h3 class="h5 mb-0">
                                      <a href="#">{{$template['name']}}</a>
                                    </h3>

                                    <!-- Review -->
                                    <a class="d-inline-block small" href="#">
                                      <span class="text-warning">
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="fas fa-star"></span>
                                        <span class="far fa-star"></span>
                                        <span class="far fa-star"></span>
                                      </span>
                                      <span class="text-dark font-weight-semi-bold ml-2">@if($template['place'] === "F") Front-End @else Back-End @endif</span>
                                    </a>
                                    <!-- End Review -->
                                  </div>
                                  <!-- End Header -->
                              <form action="http://localhost/webx/public/templates/{{ $template['id'] }}">
                                @csrf
                                <button class="btn btn-secondary" style="width: 112px;">Buy</button>
                              </form>
                              </div>
                            </div>
                            <!-- End Details -->
                          </div>
                        </div>
                      </div>
                @endif
               @endforeach











                              
                              
                            

        @endif
        
      </div>
    </main>
@endsection
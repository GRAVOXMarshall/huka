@extends('back.index')

@section('dash-content')
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products</h1>
        @if(Auth::guard('admins')->user())
          {{ Auth::guard('admins')->user()->email }}
        @endif
      </div>
      <a href="{{ route('dash.products') }}">Modules</a>
      <a href="{{ route('dash.products.templates') }}">Templates</a>
      <br><br>
      <!-- Star Modules -->

      @if(request()->is('admin/dashboard/products/modules'))

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
        @endif @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
        @endif
      </div>

     
          <!--<div class="card mb-3">
            <div class="card-body p-4">
             
              <div class="media d-block d-sm-flex">
                <div class="u-avatar mb-3 mb-sm-0 mr-3">
                  <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                </div>

                <div class="media-body">
          
                  <div class="mb-4">
                    <h3 class="h5 mb-0">
                      <a href="#">Google Inc.</a>
                    </h3>

  
                    <a class="d-inline-block small" href="#">
                      <span class="text-warning">
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star"></span>
                        <span class="far fa-star"></span>
                        <span class="far fa-star"></span>
                      </span>
                      <span class="text-dark font-weight-semi-bold ml-2">4.8</span>
                      <span class="text-muted">(780k+ reviews)</span>
                    </a>
     
                  </div>
 

                  <div class="mb-4">
                    <p>Regular exposure to business stakeholders and executive management, as well as the authority.</p>
                  </div>
 
                  <div class="d-flex align-items-center">
                    <div class="u-ver-divider pr-3 mr-3">
                      <a class="font-size-1 text-secondary font-weight-medium" href="#">Salaries</a>
                    </div>

                    <div class="u-ver-divider pr-3 mr-3">
                      <a class="font-size-1 text-secondary font-weight-medium" href="#">Q&A</a>
                    </div>

                    <a class="font-size-1 font-weight-medium" href="#">Open jobs - 451</a>
                  </div>
                 </div>
              </div>
   
            </div>
          </div>-->
 
              @foreach($data as $functionality)
                @foreach($dataWeb as $infoWeb)
                  @if($functionality['id'] === $infoWeb->id && $infoWeb->domain === $web->domain)
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
                                      <a href="#">{{$functionality['name']}}</a>
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
                                      <span class="text-dark font-weight-semi-bold ml-2">4.8</span>
                                      <span class="text-muted">(780k+ reviews)</span>
                                    </a>
                                    <!-- End Review -->
                                  </div>
                                  <!-- End Header -->

                                  <div class="mb-4">
                                    <p class="text-secondary">{{$functionality['description']}}</p>
                                  </div>
                              @if($softwareFunctionality && in_array($functionality['name'], array_column($softwareFunctionality->toArray(), 'name')))
                                @foreach($softwareFunctionality as $soft)
                                  @if($soft['name'] === $functionality['name'])
                                    @if($soft['active'] === 0)
                                    <div class="d-flex align-items-center">

                                    <div class="u-ver-divider pr-3 mr-3">
                                      <form action="{{ route('update.products') }}" method="post">
                                      @csrf
                                      <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="func_id">
                                      <button class="btn btn-danger" style="width: 112px;">Deactivate</button>
                                    </form>
                                    </div>

                                    <div class="u-ver-divider pr-3 mr-3">
                                     <form action="{{ route('delete.products') }}" method="post">
                                      @csrf
                                      <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="delete_func_id">
                                      <button class="btn btn-primary" style="width: 112px;">Uninstall</button>
                                    </form>
                                    </div>

                                    <div class="u-ver-divider pr-3 mr-3">
                                      <a href="{{ route(strtolower($functionality['name']).'.configuration') }}" class="btn btn-secondary" role="button" aria-pressed="true">Configurate</a>
                                    </div>

                                    </div>
                                    
                                    @endif
                                    @if($soft['active'] === 1)
                                    <div class="d-flex align-items-center">

                                    <div class="u-ver-divider pr-3 mr-3">
                                      <form action="{{ route('update.products') }}" method="post">
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="func_id">
                                        <button class="btn btn-success" style="width: 112px;">Activate</button>
                                      </form>
                                    </div>

                                    <div class="u-ver-divider pr-3 mr-3">
                                     <form action="{{ route('delete.products') }}" method="post">
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="delete_func_id">
                                        <button class="btn btn-primary" style="width: 112px;">Uninstall</button>
                                      </form>
                                    </div>

                                    </div>
                                      
                                      
                                    @endif
                                  @endif
                                @endforeach
                              @else
                                <form action="{{ route('install.products') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="functionality">
                                    <input type="hidden" name="product_id" value="{{ Crypt::encrypt($functionality['id']) }}" >
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
                @if(!in_array($functionality['id'], array_column($dataWeb, 'id')) && $functionality['price'] == 0)
                  <div class="col-md-6" align="center">
                  <div class="card mb-3">
                  <div class="card-body p-4">
                   
                    <div class="media d-block d-sm-flex">
                      <div class="u-avatar mb-3 mb-sm-0 mr-3">
                        <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                      </div>

                      <div class="media-body">
                
                        <div class="mb-4">
                          <h3 class="h5 mb-0">
                            <a href="#">{{$functionality['name']}}</a>
                          </h3>

        
                          <a class="d-inline-block small" href="#">
                            <span class="text-warning">
                              <span class="fas fa-star"></span>
                              <span class="fas fa-star"></span>
                              <span class="fas fa-star"></span>
                              <span class="far fa-star"></span>
                              <span class="far fa-star"></span>
                            </span>
                            <span class="text-dark font-weight-semi-bold ml-2">4.8</span>
                            <span class="text-muted">(780k+ reviews)</span>
                          </a>
           
                        </div>
       

                        <div class="mb-4">
                          <p class="text-secondary">{{$functionality['description']}}</p>
                        </div>
       
                        <form action="{{ route('install.products') }}" method="post">
                          @csrf
                          <input type="hidden" name="type" value="functionality">
                          <input type="hidden" name="product_id" value="{{ Crypt::encrypt($functionality['id']) }}" >
                          <button class="btn btn-primary" style="width: 112px;">Download</button>
                        </form>
                       </div>
                    </div>
         
                  </div>
                </div>
                </div>
                @endif
                @if(!in_array($functionality['id'], array_column($dataWeb, 'id')) && $functionality['price'] != 0)
                <div class="col-md-6" align="center">
                  <div class="card mb-3">
                  <div class="card-body p-4">
                   
                    <div class="media d-block d-sm-flex">
                      <div class="u-avatar mb-3 mb-sm-0 mr-3">
                        <img class="img-fluid" src="/img/160x160/img17.png" alt="Image Description">
                      </div>

                      <div class="media-body">
                
                        <div class="mb-4">
                          <h3 class="h5 mb-0">
                            <a href="#">{{$functionality['name']}}</a>
                          </h3>

        
                          <a class="d-inline-block small" href="#">
                            <span class="text-warning">
                              <span class="fas fa-star"></span>
                              <span class="fas fa-star"></span>
                              <span class="fas fa-star"></span>
                              <span class="far fa-star"></span>
                              <span class="far fa-star"></span>
                            </span>
                            <span class="text-dark font-weight-semi-bold ml-2">4.8</span>
                            <span class="text-muted">(780k+ reviews)</span>
                          </a>
           
                        </div>
       

                        <div class="mb-4">
                          <p class="text-secondary">{{$functionality['description']}}</p>
                        </div>
       
                        <form action="http://localhost/webx/public/functionality/{{ $functionality['id'] }}">
                          @csrf
                          <button class="btn btn-secondary" style="width: 112px;">Buy</button>
                        </form>
                       </div>
                    </div>
         
                  </div>
                </div>
                </div>
                @endif
               @endforeach
        @endif
      </div>


      @endif

      <!-- End Modules -->


      <!-- Start Templates -->

      @if(request()->is('admin/dashboard/products/templates'))

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
                                    <form action="{{ route('update.products.template') }}" method="post">
                                      @csrf
                                      <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="tem_id">
                                      <button class="btn btn-danger" style="width: 112px;">Deactivate</button>
                                    </form>
                                    </div>
                                    <div class="u-ver-divider pr-3 mr-3">
                                    <form action="{{ route('delete.products.template') }}" method="post">
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
                                      <form action="{{ route('update.products.template') }}" method="post">
                                        @csrf
                                        <input type="text" hidden value="{{ Crypt::encrypt($soft->id) }}" name="tem_id">
                                        <button class="btn btn-success" style="width: 112px;">Activate</button>
                                      </form>
                                      </div>
                                    <div class="u-ver-divider pr-3 mr-3">
                                      <form action="{{ route('delete.products.template') }}" method="post">
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
                                <form action="{{ route('install.products.template') }}" method="post" >
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
                                <form action="{{ route('install.products.template') }}" method="post" >
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


      @endif

      <!-- End Templates -->
  </main>
 @endsection
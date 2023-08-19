<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('pageTitle') - Wisehud AI</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="">
    <meta property="og:site_name" content="">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/admin/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/admin/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/admin/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" id="css-main" href="/admin/css/codebase.min.css">
  </head>

  <body>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">

      <nav id="sidebar">
        
        <div class="sidebar-content">
          
          <div class="content-header justify-content-lg-center">
            
            <div>
              <span class="smini-visible fw-bold tracking-wide fs-lg">
                c<span class="text-primary">b</span>
              </span>
              <a class="link-fx fw-bold tracking-wide mx-auto" href="#">
                <span class="smini-hidden">
                  <i class="fa fa-fire text-primary"></i>
                  <span class="fs-4 text-dual">de</span><span class="fs-4 text-primary">Mentor</span>
                </span>
              </a>
            </div> 
            <div>       
              <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout" data-action="sidebar_close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          
          <div class="js-sidebar-scroll">
            
            @include('admin.layout.sidebar')
            
          </div>
        </div>
      </nav>
      
      <header id="page-header">
        
        <div class="content-header">
          
          <div class="space-x-1">
            
            
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
              <i class="fa fa-fw fa-bars"></i>
            </button>
            
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="header_search_on">
              <i class="fa fa-fw fa-search"></i>
            </button>

            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-themes-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-wrench"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-lg p-0" aria-labelledby="page-header-themes-dropdown">
                <div class="p-3 bg-body-light rounded-top">
                  <h5 class="h6 text-center mb-0">
                    Color Themes
                  </h5>
                </div>
                <div class="p-3">
                  <div class="row g-0 text-center">
                    <div class="col-2">
                      <a class="text-default" data-toggle="theme" data-theme="default" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                    <div class="col-2">
                      <a class="text-elegance" data-toggle="theme" data-theme="/admin/css/themes/elegance.min.css" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                    <div class="col-2">
                      <a class="text-pulse" data-toggle="theme" data-theme="/admin/css/themes/pulse.min.css" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                    <div class="col-2">
                      <a class="text-flat" data-toggle="theme" data-theme="/admin/css/themes/flat.min.css" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                    <div class="col-2">
                      <a class="text-corporate" data-toggle="theme" data-theme="/admin/css/themes/corporate.min.css" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                    <div class="col-2">
                      <a class="text-earth" data-toggle="theme" data-theme="/admin/css/themes/earth.min.css" href="javascript:void(0)">
                        <i class="fa fa-2x fa-circle"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="space-x-1">
            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user d-sm-none"></i>
                <span class="d-none d-sm-inline-block fw-semibold">{{ auth()->user()->name }}</span>
                <i class="fa fa-angle-down opacity-50 ms-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
                <div class="px-2 py-3 bg-body-light rounded-top">
                  <h5 class="h6 text-center mb-0">
                    {{ auth()->user()->name }}
                  </h5>
                </div>
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="#">
                    <span>Profile</span>
                    <i class="fa fa-fw fa-user opacity-25"></i>
                  </a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1" href="{{ route('logout') }}">
                    <span>Sign Out</span>
                    <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                  </a>
                </div>
              </div>
            </div>
            
            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-flag"></i>
                <span class="text-primary">&bull;</span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications">
                <div class="px-2 py-3 bg-body-light rounded-top">
                  <h5 class="h6 text-center mb-0">
                    Notifications
                  </h5>
                </div>
                <ul class="nav-items my-2 fs-sm">
                  <li>
                    <a class="text-dark d-flex py-2" href="javascript:void(0)">
                      <div class="flex-shrink-0 me-2 ms-3">
                        {{-- <i class="fa fa-fw fa-check text-success"></i> --}}
                      </div>
                      <div class="flex-grow-1 pe-2">
                        <p class="fw-medium mb-1">You have no new notification</p>
                        {{-- <div class="text-muted">15 min ago</div> --}}
                      </div>
                    </a>
                  </li>

                </ul>
                <div class="p-2 bg-body-light rounded-bottom">
                  <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                    <i class="fa fa-fw fa-flag opacity-50 me-1"></i> View All
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="page-header-search" class="overlay-header bg-body-extra-light">
          <div class="content-header">
            <form class="w-100" action="be_pages_generic_search.html" method="POST">
              <div class="input-group">
                <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                  <i class="fa fa-fw fa-times"></i>
                </button>
                
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                <button type="submit" class="btn btn-secondary">
                  <i class="fa fa-fw fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
        
        <div id="page-header-loader" class="overlay-header bg-primary">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="far fa-sun fa-spin text-white"></i>
            </div>
          </div>
        </div>
      </header>
      
      @yield('content')

      <footer id="page-footer">
        <div class="content py-3">
          <div class="row fs-sm">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
              Developed by <a class="fw-semibold" href="#" target="_blank">GigaPlus Company</a>
            </div>
            <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
              <a class="fw-semibold" href="https://1.envato.market/95j" target="_blank"> Wisehud AI 1.0.0</a> &copy; <span data-toggle="year-copy"></span>
            </div>
          </div>
        </div>
      </footer>
    </div>
    
    <script src="/admin/js/codebase.app.min.js"></script>
    {{-- <script src="/admin/js/plugins/chart.js/chart.umd.js"></script> --}}
    {{-- <script src="/admin/js/pages/be_pages_dashboard.min.js"></script> --}}
    @yield('js')
  </body>
</html>
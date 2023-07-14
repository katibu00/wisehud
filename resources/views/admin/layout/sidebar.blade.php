@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
$user = auth()->user();
@endphp

<div class="content-side content-side-user px-0 py-0">
              
  <div class="smini-visible-block animated fadeIn px-3">
    <img class="img-avatar img-avatar32" src="/default.png" alt="">
  </div>

  <div class="smini-hidden text-center mx-auto">
    <a class="img-link" href="#">
      <img class="img-avatar" src="/default.png" alt="">
    </a>
    <ul class="list-inline mt-3 mb-0">
      <li class="list-inline-item">
        <a class="link-fx text-dual fs-sm fw-semibold text-uppercase" href="#">{{ $user->name }}</a>
      </li>
      <li class="list-inline-item">
        
        <a class="link-fx text-dual" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
          <i class="fa fa-burn"></i>
        </a>
      </li>
      <li class="list-inline-item">
        <a class="link-fx text-dual" href="op_auth_signin.html">
          <i class="fa fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </div>
  
</div>


  <div class="content-side content-side-full">
    <ul class="nav-main">

      <li class="nav-main-item">
        <a class="nav-main-link  {{ $route == 'admin.home' ? 'active' : '' }}" href="{{ route('admin.home') }}">
          <i class="nav-main-link-icon fa fa-house-user"></i>
          <span class="nav-main-link-name">Home</span>
        </a>
      </li>

      <li class="nav-main-item  {{ $prefix == '/users' ? 'open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
          <i class="nav-main-link-icon fa fa-users"></i>
          <span class="nav-main-link-name">Users</span>
        </a>
        <ul class="nav-main-submenu">
         
          <li class="nav-main-item">
            <a class="nav-main-link  {{ $route == 'regular.index' ? 'active' : '' }}" href="{{ route('regular.index') }}">
              <span class="nav-main-link-name">Regular</span>
            </a>
          </li>
         

        
        </ul>
      </li>

      <li class="nav-main-item  {{ $prefix == '/settings' ? 'open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
          <i class="nav-main-link-icon fa fa-cog"></i>
          <span class="nav-main-link-name">Settings</span>
        </a>
        <ul class="nav-main-submenu">
         
          <li class="nav-main-item">
            <a class="nav-main-link  {{ $route == 'openai_key' ? 'active' : '' }}" href="{{ route('openai_key') }}">
              <span class="nav-main-link-name">OpenAI API Key</span>
            </a>
          </li>
          <li class="nav-main-item">
            <a class="nav-main-link  {{ $route == 'monnify_api_key' ? 'active' : '' }}" href="{{ route('monnify_api_key') }}">
              <span class="nav-main-link-name">Monnify API Key</span>
            </a>
          </li>

          <li class="nav-main-item">
            <a class="nav-main-link  {{ $route == 'charges' ? 'active' : '' }}" href="{{ route('charges') }}">
              <span class="nav-main-link-name">Billing and Bonuses</span>
            </a>
          </li>

        
        </ul>
      </li>
    
    </ul>
  </div>

 <!-- Offcanvas -->
 <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <div class="offcanvas-body p-0">
      <!-- Side Nav Wrapper -->
      <div class="sidenav-wrapper">
        <!-- Sidenav Profile -->
        <div class="sidenav-profile bg-gradient">
          <div class="sidenav-style1"></div>
          <!-- User Thumbnail -->
          <div class="user-profile"><img src="img/bg-img/2.jpg" alt=""></div>
          <!-- User Info -->
          <div class="user-info">
            <h6 class="user-name mb-0">{{ auth()->user()->name }}</h6><span>Regular</span>
          </div>
        </div>
        <!-- Sidenav Nav -->
        <ul class="sidenav-nav ps-0">
          <li><a href="{{ route('regular.home') }}"><i class="bi bi-house-door"></i>Home</a></li>

          
          <li><a href="{{ route('chat.index') }}"><i class="bi bi-chat"></i>Ask AI</a></li>
          <li><a href="{{ route('wallet.index') }}"><i class="bi bi-wallet"></i>Wallet</a></li>
          @php
          $link = App\Models\Charges::select('whatsapp_number')->first();
        @endphp
          <li><a href="{{ $link->whatsapp_group_link }}"><i class="bi bi-whatsapp"></i>Join our Whatsapp Group</a></li>
          <li>
            <div class="night-mode-nav"><i class="bi bi-moon"></i>Night Mode
              <div class="form-check form-switch">
                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
              </div>
            </div>
          </li>
         
          <li><a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i>Logout</a></li>
        </ul>
        <!-- Social Info -->
        <div class="social-info-wrap"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-twitter"></i></a><a href="#"><i class="bi bi-linkedin"></i></a></div>
        <!-- Copyright Info -->
        <div class="copyright-info">
          <p>2023 &copy; Developed by<a href="#">Wisehud</a></p>
        </div>
      </div>
    </div>
  </div>
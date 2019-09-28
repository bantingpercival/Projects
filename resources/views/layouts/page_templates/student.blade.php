<div class="wrapper ">
  @include('layouts.navbars.sidebar1')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
  </div>
</div>
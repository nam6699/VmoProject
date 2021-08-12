<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/flexboxgrid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mycss.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
      <!-- HEADER -->
      <header id="main-header">
        <div class="container">
          <div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
              <h1><span class="primary-text">Vmo</span>Tools</h1>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
              <nav id="navbar">
                <ul>
                @guest
                      @if (Route::has('login'))
                                <li>
                                    <a  href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                      @endif

                      @if (Route::has('register'))
                                <li >
                                    <a  href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                       @endif
                  @else
                  <li ><a href="{{url('home')}}">Home</a></li>
                  <li><a href="{{ route('request') }}">Your Request</a></li>
                  <li><a href="{{ route('show.request', Auth::user()->id )}}">Request Detail</a></li>
                  <li><a class="" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                        </a> <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                        </form></a></li>
                    @endguest
                  
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </header>
      <!-- SHOWCASE -->
      <section id="showcase">
        <div class="container">
          <div class="row center-xs center-sm center-md center-lg middle-xs middle-sm middle-md middle-lg">
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-7 showcase-content">
              <h1>Welcome to <span class="primary-text">VmoTools</span></h1>
              <p>A Website for Vmo's Emplyee</p>
            </div>
          </div>
        </div>
      </section>
      <!-- FEATURE -->
     
    
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<!-- END FEATURES -->

<section id="company">
   <div class="container">
     <div class="row">
       <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <h4>Contact Us</h4>
        <ul class="contact" >
          <li><i class="fa fa-phone"> 024 3312 0103</i></li>
          <li><i class="fa fa-envelope"> info@vmogroup.com</i></li>
          <li><i class="fa fa-map"> 15th Floor, TTC Tower,<br>
                  19 Duy Tan st., Dich Vong Hau ward.,<br>
                   Cau Giay dist.,
                  Hanoi</i></li>
          <li><i class="fa fa-globe"> https://www.vmogroup.jp</i></li>
        </ul>
       </div>
       <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <h4>About Us</h4>
        <ul class="contact">
          <li><a href="https://www.vmogroup.com/about-us/human-resource" target="_blank" class="text-white">Company</a></li>
          <li><a href="https://www.vmogroup.com/about-us/technical-capability" target="_blank" class="text-white">Technical Capability</a></li>
          <li><a href="https://www.vmogroup.com/about-us/ceo-statement" target="_blank" class="text-white">CEO Statement</a></li>
          <li><a href="https://www.vmogroup.com/about-us/our-process" target="_blank" class="text-white">Our Process</a></li>
        </ul>
       </div>
       <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <h4>Service</h4>
        <ul class="contact">
          <li><a href="https://www.vmogroup.com/services/odc" target="_blank" class="text-white">Offshore Development Center</a></li>
          <li><a href="https://www.vmogroup.com/services/web-and-web-app-development" target="_blank" class="text-white">Web Application Development</a></li>
          <li><a href="https://www.vmogroup.com/services/iot" target="_blank" class="text-white">Internet of Things</a></li>
          <li><a href="https://www.vmogroup.com/services/ai" target="_blank" class="text-white">Artificial Intelligence</a></li>
        </ul>
       </div>
     </div>
   </div>
</section>

<!-- Footer -->
<footer id="main-footer">
  <div class="container">
    <dv class="row center-xs center-sm center-md center-lg">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <p>Copyright &copy; 2021 | VmoTools</p>
      </div>
    </dv>
  </div>

</footer>
<!-- Footer -->


<script>
// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("main-header");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
@yield('my_javascript')
</html>

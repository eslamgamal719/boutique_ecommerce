<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Boutique | Ecommerce bootstrap template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <link src="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Lightbox-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/lightbox2/css/lightbox.min.css') }}">
    <!-- Range slider-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/nouislider/nouislider.min.css') }}">
    <!-- Bootstrap select-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.theme.default.css') }}">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

      @stack('css')
      <livewire:styles />
  </head>
  <body>
    <div class="page-holder {{ request()->routeIs('frontend.product') ? 'bg-light' : null }}">
      <!-- navbar-->
      <header class="header bg-white">
        <div class="container px-0 px-lg-3">
          <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="{{ route('frontend.index') }}"><span class="font-weight-bold text-uppercase text-dark">{{ config('app.name') }}</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('frontend.index') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('frontend.shop') }}">Shop</a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="{{ route('frontend.product') }}">Product detail</a>
                </li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                  <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
                      <a class="dropdown-item border-0 transition-link" href="{{ route('frontend.index') }}">Homepage</a>
                      <a class="dropdown-item border-0 transition-link" href="{{ route('frontend.shop') }}">Category</a>
                      <a class="dropdown-item border-0 transition-link" href="{{ route('frontend.product') }}">Product detail</a>
                      <a class="dropdown-item border-0 transition-link" href="{{ route('frontend.cart') }}">Shopping cart</a>
                      <a class="dropdown-item border-0 transition-link" href="{{ route('frontend.checkout') }}">Checkout</a>
                    </div>
                </li> -->
              </ul>
              <ul class="navbar-nav ml-auto">


                <livewire:frontend.cart-component />
                

                @guest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"> 
                      <i class="fas fa-user-alt mr-1 text-gray"></i>
                      Login
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"> 
                      <i class="fas fa-user-alt mr-1 text-gray"></i>
                      Register
                    </a>
                  </li>
                @else
                  <li class="nav-item dropdown">
                  <livewire:frontend.header.notification-component />  
                    
                  </li>

                  <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="authDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->full_name }}
                    </a>

                    <div class="dropdown-menu mt-3" aria-labelledby="authDropdown">
                        <a href="{{ route('frontend.customer.dashboard') }}" class="dorpdown-item ml-2 mt-2">Dashboard</a><br>
                        <a href="javascript:void(0);" class="dorpdown-item ml-2 mt-2"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >Logout</a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                            @csrf
                        </form>
                    </div>
                  </li>
                @endguest
              </ul>
            </div>
          </nav>
        </div>
      </header>
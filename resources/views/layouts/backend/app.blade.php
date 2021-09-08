
@include('backend.includes.header')

@include('backend.includes.sidebar')

@include('backend.includes.navbar')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        @yield('content')
    </div>

@include('backend.includes.modal')

@include('backend.includes.footer')

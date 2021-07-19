<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/backend/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/toastr/toastr.css')}}">

  {{-- Push header --}}
  @stack('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
    @include('layouts.backend.partials.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('layouts.backend.partials.main-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.backend.partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/backend/dist/js/adminlte.js')}}"></script>

{{--  Toastr --}}
<script src="{{asset('assets/backend/plugins/toastr/toastr.min.js')}}"></script>
 {!! Toastr::message() !!}

{{-- Push footer --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.2.3/ionicons.min.js"></script> --}}
@stack('footer')

<script src="{{asset('assets/backend/dist/js/demo.js')}}"></script>
{{-- Load all Buttons After Window Load --}}
<script>
    console.log('footer');
    window.onload = function(){
        console.log('footer-windo');
        //////////////////////////////////
        // Enable Button After loading
        btns=document.querySelectorAll(".btn");
        btns.forEach(element => {
            element.disabled = false;
        });
    // document.getElementById("#example1 > tbody > button.btn").disabled = true;
    }
</script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('assets/backend/dist/js/pages/dashboard2.js')}}"></script> --}}
</body>
</html>

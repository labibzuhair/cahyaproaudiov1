<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Beranda')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo_cahya_pro_audio.png') }}" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free-6.7.2/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">

    <!-- FullCalendar CSS for custom calender-->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />


<link rel="stylesheet" href="{{ asset('css/calender/style.css') }}">

<style>


    .details-container {
      float: right;
      width: 30%; /* Sesuaikan lebar sesuai kebutuhan */
      color: white;
      padding: 20px;
      margin-right: 100px;
    }

    .active-date {
      background-color: #9370DB; /* Warna ungu */
      color: white;
    }

    .rental-date {
      background-color: #32CD32; /* Warna hijau */
      color: white;
    }

    .event-date {
      border-left: 10px solid #FF1744; /* Warna merah untuk event */
    }
  </style>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.components.admin.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.components.admin.topbar')

                <main class="container-fluid p-0">
                    @yield('content')
                </main>


                @include('layouts.components.admin.footer')



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->


        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        @include('layouts.components.admin.logoutModal')


        {{-- <script src="{{ asset('js/calender/jquery.min.js') }}"></script> --}}
        <script src="{{ asset('js/calender/popper.js') }}"></script>
        <script src="{{ asset('js/calender/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/calender/main.js') }}"></script>

<!-- FullCalendar JS for custom calender -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="{{ asset('js/admin-script.js') }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

</body>

</html>

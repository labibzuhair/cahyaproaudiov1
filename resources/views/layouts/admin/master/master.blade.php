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
        .ftco-section {
    padding: 1em 0;
}
        .content-small{
            width: 50%;
            margin: 20px;
            background: #7e0cf50f;
        }
        .ftco-section-small {
    padding: 0;
}
        .content {
          display: flex;
          flex-wrap: wrap;
        }

        .calendar-container {
          flex: 1;
          min-width: 300px;
          background: #f8f9fd;
        }

        .events-container {
          flex: 1;
          min-width: 300px;
          padding: 20px;
        }

        .active-date {
          color: white;
        }

        .rental-date-a {
          background-color: #FF6347; /* Warna A */
          color: white;
        }

        .rental-date-b {
          background-color: #FFD700; /* Warna B */
          color: white;
        }

        .rental-date-c {
          background-color: #32CD32; /* Warna C */
          color: white;
        }

        .event-date {
          border-left: 10px solid #FF1744; /* Warna merah untuk event */
        }

        .rental-details {
          width: 100%;
          border-collapse: collapse;
        }

        .rental-details th, .rental-details td {
          border: 1px solid white;
          padding: 8px;
          text-align: left;
        }

        .rental-details th {
          background-color: #4CAF50;
          color: white;
        }

        @media (max-width: 768px) {
          .content {
            flex-direction: column;
          }

          .calendar-container, .events-container {
            width: 100%;
          }

          .events-container {
            margin-top: 20px;
          }
        }

        @media (max-width: 480px) {
          .calendar-container, .events-container {
            padding: 10px;
          }

          .rental-details th, .rental-details td {
            padding: 5px;
          }
        }

        /* CSS untuk Kalender Kecil */
        .small-calendar-container {
          flex: 1;
          min-width: 150px; /* Lebar minimum lebih kecil */
          padding: 5px; /* Padding lebih kecil */
        }

        .small-calendar-container .calendar {
          font-size: 0.7em; /* Ukuran font lebih kecil */
        }

        /* Hapus elemen detail untuk kalender kecil */
        .small-events-container {
          display: none; /* Sembunyikan container detail rental */
        }
    .disabled-date {
        pointer-events: none;
    }
        /* table transaction style */
        html,
body,
.intro {
  height: 100%;
}

table td,
table th {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}

thead th {
  color: #fff;
}

.card {
  border-radius: .5rem;
}

.table-scroll {
  border-radius: .5rem;
}

.table-scroll table thead th {
  font-size: 1.25rem;
}
thead {
  top: 0;
  position: sticky;
}

/* event calender scroll */
table td, table th {
    text-overflow: ellipsis;
    white-space: nowrap;
    /* overflow: hidden; */
    word-wrap: break-word;
    white-space: pre-wrap;
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

        <!-- FullCalendar JS for custom calender -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>


      <!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Kalender JavaScript -->
<script src="{{ asset('js/calender/popper.js') }}"></script>
<script src="{{ asset('js/calender/main.js') }}"></script>


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

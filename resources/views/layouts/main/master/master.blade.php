<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Beranda')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo_cahya_pro_audio.png') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

        <!-- FullCalendar CSS for custom calender-->
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />


        <link rel="stylesheet" href="{{ asset('css/calender/style.css') }}">

        <style>
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
          </style>

</head>

<body id="page-top">

    @include('layouts.components.main.navbar')


    <main class="container-fluid p-0">
        @yield('content')
    </main>
    @include('layouts.components.main.footer')

     <!-- FullCalendar JS for custom calender -->
     <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>


     <!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Kalender JavaScript -->
<script src="{{ asset('js/calender/popper.js') }}"></script>
<script src="{{ asset('js/calender/mainCustomer.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap core JS-->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>

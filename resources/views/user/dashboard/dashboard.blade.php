<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="Sajjadhamidi">
    <meta name="keywords" content="Sajjad Hamidi">

    <title>User Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{asset('../user/assets/vendors/core/core.css')}}">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('../user/assets/vendors/flatpickr/flatpickr.min.css')}}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('../user/assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('../user/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('../user/assets/css/demo2/style.css')}}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{asset('../user/assets/images/favicon.png')}}"/>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Plugin css for this page -->
    <link rel="stylesheet"
          href="{{asset('../../../user/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
    <!-- End plugin css for this page -->

</head>
<body>
<div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    @include('user.dashboard.partials.sidebar')


    <!-- partial -->

    <div class="page-wrapper">

        <!-- partial:partials/_navbar.html -->
        @include('user.dashboard.partials.navbar')
        <!-- partial -->

        @yield('content')



        <!-- partial:partials/_footer.html -->
        @include('user.dashboard.partials.footer')
        <!-- partial -->
    </div>

</div>


<!-- core:js -->
<script src="{{asset('../user/assets/vendors/core/core.js')}}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="{{asset('../user/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('../user/assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{asset('../user/assets/vendors/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('../user/assets/js/template.js')}}"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src="{{asset('../user/assets/js/dashboard-dark.js')}}"></script>
<!-- End custom js for this page -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>
<!-- Plugin js for this page -->
<script src="{{asset('../../../user/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('../../../user/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<!-- End plugin js for this page -->


<!-- Custom js for this page -->
<script src="{{asset('../../../user/assets/js/data-table.js')}}"></script>
<!-- End custom js for this page -->

<script src="{{asset('../../../user/assets/vendors/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('../../../user/assets/js/tinymce.js')}}"></script>


</body>
</html>

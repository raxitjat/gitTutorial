<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Dashboard</title>

  @include('admin.layouts.include.css')
  @stack('css')


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('admin.layouts.include.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('admin.layouts.include.topbar')
        <!-- End of Topbar -->

        @yield('raxit')
        {{-- @include('admin.layouts.include.demoContent') --}}

        {{-- <div class="container-fluid">

          @yield('contents')

        </div> --}}
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      @include('admin.layouts.include.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  @include('admin.layouts.include.logout')
  @include('admin.layouts.include.js')
  @stack('js')


</body>

</html>
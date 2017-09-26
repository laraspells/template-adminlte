<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title or '{? schema.name ?}' }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @section('styles')
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    @styles
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendor/admin-lte/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/style.css') }}">
  @show

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{ strtoupper(substr('{? schema.name ?}', 0, 3)) }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{? schema.name ?}</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      @include('{? view_namespace ?}layout.navbar')
    </header>

    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('{? view_namespace ?}layout.sidebar-user-panel')
        <!-- search form -->
        @include('{? view_namespace ?}layout.sidebar-form')
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @include('{? view_namespace ?}layout.sidebar-menu')
      </section>
      <!-- /.sidebar -->
    </aside>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.8
      </div>
      <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    @include('{? view_namespace ?}layout.control-sidebar')
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  @section('scripts')
    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('vendor/admin-lte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{ asset('vendor/admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('vendor/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendor/admin-lte/plugins/fastclick/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/admin-lte/dist/js/app.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('vendor/admin-lte/dist/js/demo.js') }}"></script>
    @scripts
  @show
</body>
</html>

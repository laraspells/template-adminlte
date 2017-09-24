@extends('{? view_namespace ?}layout.master')

@section('content')
<section class="content-header">
  <h1>Dashboard</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  </ol>
</section>
<section class="content">
<div class="box box-default">
  <div class="box-header">
    <h4 class="box-title">
      This is default dashboard page.
    </h4>
  </div>
  <div class="box-body">
    <table class="table table-striped table-bordered">
      <tr>
        <td width="120">Route Name</td>
        <td width="10" class="text-center">:</td>
        <td><code>{? schema.route.name ?}dashboard</code></td>
      </tr>
      <tr>
        <td width="120">Controller</td>
        <td width="10" class="text-center">:</td>
        <td><code>{? schema.controller.path ?}/DashboardController.php</code></td>
      </tr>
      <tr>
        <td width="120">View</td>
        <td width="10" class="text-center">:</td>
        <td><code>{? schema.view.path ?}/dashboard/dashboard.blade.php</code></td>
      </tr>
    </table>
  </div>
</div>
</section>
@endsection
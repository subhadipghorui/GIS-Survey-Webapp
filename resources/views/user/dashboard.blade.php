@extends('layouts.backend.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{route('user.dataset.create')}}">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Data</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{route('user.dataset.index')}}">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">All Data</span>
                        <span class="info-box-number">2,000</span>
                        </div>
                        <!-- /.info-box-content -->
                </div>
                </a>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <a href="{{route('user.profile')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">Settings</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
@endsection

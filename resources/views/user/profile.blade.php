@extends('layouts.backend.app')
@section('title')
    Profile Page
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    {{-- Errors --}}
    <div class="col-md-12">
      @if ($errors->any())

      @foreach ($errors->all() as $error)
      <div class="alert  alert-danger alert-dismissible fade show" role="alert">
          <span class="badge badge-pill badge-danger">Erorr</span> {{$error}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>
      @endforeach

      @endif

  </div>
    {{-- ./Errors --}}
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  {{-- Removed class= profile-user-img --}}
                  <img class="img-fluid img-circle"
                       src="{{Storage::disk('public')->url('profile/'.Auth::user()->image)}}"
                       alt="userpicture">
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-muted text-center">{{$user->role->name}}</p>
                <strong><i class="fas fa-book mr-1"></i> Info</strong>

                <p class="text-muted">
                 {{$user->about}}
                </p>

                <hr>


                <a href="#" class="btn btn-primary btn-block"><b>Contact</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="active nav-link" href="#profile" data-toggle="tab">Update Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="profile">
                    <form class="form-horizontal" action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <div class="form-group row">
                        <label for="exampleInputFile" class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="input-group col-sm-5">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                        </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" value="{{Auth::user()->name}}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{Auth::user()->email}}" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" name="userid" placeholder="User ID" value="{{Auth::user()->userid}}" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">About</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="about" placeholder="Education" required>{{Auth::user()->about}}</textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" action="{{route('user.changepassword')}}" method="POST">
                        @csrf
                        @method('PUT')
                      <div class="form-group row">
                        <label for="old_password" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="old_password" placeholder="New Pass" name="old_password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password" placeholder="New Pass" name="password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password_confirmation" placeholder="Re-Type Pass" name="password_confirmation" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Change Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->

          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('footer')
<script src="{{ asset('assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
    </script>
@endpush

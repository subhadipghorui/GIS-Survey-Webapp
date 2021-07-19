@extends('layouts.backend.app')
@section('title')
    Users
@endsection
@push('header')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  {{-- FIx Search style --}}
  <style>

     #users_table_filter{
      padding: 0 20px;
      }
      #users_table_wrapper > div:nth-child(1) > div:nth-child(1){
      padding: 0 20px;
      }
  </style>
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">All Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
       <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          {{-- Error --}}
              <div class="col-md-12">
                @if ($errors->any())

                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{$error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endforeach

                @endif

            </div>
            {{-- ./Error --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header mb-3">
                        <h3 class="card-title">
                            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#createModal" data-whatever="@mdo" disabled><i class="fas fa-plus"></i></button>
                            Add a User</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-hover" id="users_table">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Userid</th>
                                <th>Role</th>
                                <th>Email Verified</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $key => $user)
                              <tr>
                                  <td>{{$key+1}}</td>
                                <td>
                                    <div class="img img-thumbal">
                                        <img src="{{Storage::disk('public')->url('profile/'.$user->image)}}" alt="{{$user->name}}" width="100px" height="auto" style="border-radius: 50px">
                                    </div>
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->userid}}</td>
                                <td>{{$user->role->name}}</td>
                                <td>{{$user->email_verified_at}}</td>
                                <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mb-1" data-toggle="modal"
                                data-target="#viewModal"
                                data-name="{{$user->name}}"
                                data-userid="{{$user->userid}}"
                                data-email="{{$user->email}}"
                                data-role="{{$user->role->name}}"
                                data-image="{{Storage::disk('public')->url('profile/'.$user->image)}}"
                                data-about="{{$user->about}}"
                                data-created_at="{{$user->created_at}}"
                                data-updated_at="{{$user->updated_at}}"
                                data-email_verified_at="{{$user->email_verified_at}}"
                                disabled
                                >
                                  <i class="fa fa-eye"></i>
                                  </button>

                                    <button type="button" class="btn btn-secondary mb-1" data-toggle="modal"
                                    data-target="#editModal"
                                    data-name="{{$user->name}}"
                                    data-userid="{{$user->userid}}"
                                    data-email="{{$user->email}}"
                                    data-role="{{$user->role->id}}"
                                    data-image="{{$user->image}}"
                                    data-about="{{$user->about}}"
                                    data-created_at="{{$user->created_at}}"
                                    data-updated_at="{{$user->updated_at}}"
                                    data-email_verified_at="{{$user->email_verified_at}}"
                                    data-route="{{route('superadmin.user.update', $user->id)}}"
                                    disabled
                                    >
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger mb-1" data-toggle="modal"
                                    data-target="#deleteModal" data-name="{{$user->name}}" data-route="{{route('superadmin.user.destroy', $user->id)}}" disabled>
                                    <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                              @endforeach
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            {{-- Modals --}}
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body px-5">
                    <form action="{{route('superadmin.user.store')}}" enctype="multipart/form-data" method="POST" id="createForm">
                        @csrf
                        <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" >
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="userid" class="col-sm-2 col-form-label">Userid</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="userid" name="userid" >
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" name="email" >
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="verified" name="verified">
                                <label class="form-check-label" for="verified">Verified</label>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="jobType" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <select class="form-control" name="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" >
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="about" class="col-sm-2 col-form-label">About</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" id="about" name="about" placeholder="about" rows="3"></textarea>
                        </div>
                        </div>
                        <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">File input</label>
                        <div class="input-group col-sm-4">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                    document.getElementById('createForm').submit();">Submit</button>
                    </div>
                </div>
                </div>
                </div>
            </div>
              <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">User Name</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="userName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                  <input type="text" readonly class="form-control-plaintext" id="userName">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="userUserid" class="col-sm-2 col-form-label">User Id</label>
                                <div class="col-sm-10">
                                  <input type="text" readonly class="form-control-plaintext" id="userUserid">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="userEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                  <input type="text" readonly class="form-control-plaintext" id="userEmail">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                                <label for="userRole">Profile Image</label>
                              <div class="image">
                                <img src="{{Storage::disk('public')->url('profile/'.$user->image)}}" alt="{{$user->name}}" height="auto" id="userImage">
                            </div>
                           </div>
                          <div class="col-12">
                            <div class="form-group row">
                                <label for="userRole" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                  <input type="text" readonly class="form-control-plaintext" id="userRole">
                                </div>
                              </div>
                            <div class="form-group row">
                                <label for="userEmailVierified" class="col-sm-2 col-form-label">Email Verified</label>
                                <div class="col-sm-10">
                                  <input type="text" readonly class="form-control-plaintext" id="userEmailVierified">
                                </div>
                              </div>
                            <div class="form-group row">
                              <label for="userCreated" class="col-sm-2 col-form-label">Created At</label>
                              <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="userCreated">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="userUpdated" class="col-sm-2 col-form-label">Updated At</label>
                              <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="userUpdated">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="userAbout" class="col-sm-2 col-form-label">About</label>
                              <div class="col-sm-10">
                                <p class="form-control-plaintext" id="userAbout"></p>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body px-5">
                        <form action="#" enctype="multipart/form-data" method="POST" id="updateForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_name" name="name" >
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="userid" class="col-sm-2 col-form-label">Userid</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_userid" name="userid" >
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="edit_email" name="email" >
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="edit_verified" name="verified">
                                    <label class="form-check-label" for="verified">Verified</label>
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="jobType" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-6">
                                <div class="form-group">
                                <select class="form-control" name="role_id" id="edit_role_id">
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                                </select>
                                </div>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="edit_password" name="password" >
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" >
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="about" class="col-sm-2 col-form-label">About</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="edit_about" name="about" placeholder="about" rows="3"></textarea>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="edit_image" class="col-sm-2 col-form-label">File input</label>
                            <div class="input-group col-sm-4">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_image" name="image">
                                <label class="custom-file-label" for="edit_image">Choose file</label>
                                </div>
                            </div>
                            </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('updateForm').submit();">Submit</button>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Device</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <p id="message">
                            The User will be deleted !!
                        </p>
                        <p class="text-danger">To delete this user type <b>CONFIRM</b>.</p>
                        <form action="#" id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="confirm_delete" name="confirm_delete" placeholder="Type CONFIRM here">
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                        document.getElementById('deleteForm').submit();" id="user_delete_button" style="display: none">Delete</button>
                        </div>
                    </div>
                    </div>
                </div>
            {{-- Modals./ --}}
      </div>
    </section>
@endsection
@push('footer')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.j')}}s"></script>
    <script src="{{asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

    <!-- Page specific script -->
    <script>
        $(function () {
          $("#users_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "colvis"]
          }).buttons().container().appendTo('#users_table_wrapper .col-md-6:eq(0)');
        });
    </script>

    {{-- Bootstrap file input fix --}}
    <script>
        $(document).on('change', '.custom-file-input', function (event) {
            $(this).next('.custom-file-label').html(event.target.files[0].name);
        })
    </script>
    <script>
      $(document).ready(function() {
              // Dynamic Modal View
                $('#viewModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var name = button.data('name') // Extract info from data-* attributes
                    var userid = button.data('userid') // Extract info from data-* attributes
                    var email = button.data('email') // Extract info from data-* attributes
                    var role = button.data('role') // Extract info from data-* attributes
                    var image = button.data('image') // Extract info from data-* attributes
                    var about = button.data('about') // Extract info from data-* attributes
                    var created_at = button.data('created_at') // Extract info from data-* attributes
                    var updated_at = button.data('updated_at') // Extract info from data-* attributes
                    var email_verified_at = button.data('email_verified_at') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text(name)
                    modal.find('.modal-body input#userName').val(name)
                    modal.find('.modal-body input#userUserid').val(userid)
                    modal.find('.modal-body input#userEmail').val(email)
                    document.getElementById('userImage').src = image;
                    modal.find('.modal-body input#userRole').val(role)
                    modal.find('.modal-body p#userAbout').text(about)
                    modal.find('.modal-body input#userCreated').val(created_at)
                    modal.find('.modal-body input#userUpdated').val(updated_at)
                    modal.find('.modal-body input#userEmailVierified').val(email_verified_at)
              })
              // Dynamic Modal edit
                $('#editModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var name = button.data('name') // Extract info from data-* attributes
                    var userid = button.data('userid') // Extract info from data-* attributes
                    var email = button.data('email') // Extract info from data-* attributes
                    var role = button.data('role') // Extract info from data-* attributes
                    var about = button.data('about') // Extract info from data-* attributes
                    var created_at = button.data('created_at') // Extract info from data-* attributes
                    var updated_at = button.data('updated_at') // Extract info from data-* attributes
                    var email_verified_at = button.data('email_verified_at') // Extract info from data-* attributes
                    var route = button.data('route');
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text(name)
                    modal.find('.modal-body input#edit_name').val(name)
                    modal.find('.modal-body input#edit_userid').val(userid)
                    modal.find('.modal-body input#edit_email').val(email)
                    $('#edit_role_id').val(role)
                    modal.find('.modal-body p#edit_about').text(about)


                    // Target form action attribute
                    document.getElementById("updateForm").action =route;
              })
              // Dynamic Modal View
                $('#deleteModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var name = button.data('name') // Extract info from data-* attributes
                    var route = button.data('route') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-title').text('Delete USER: ' + name)
                    modal.find('.modal-body p#message').text('The user name '+name+' will be deleted forever !!')

                    // Target form action attribute
                    document.getElementById("deleteForm").action =route;
              })

        });
        $("#confirm_delete").on("change keyup paste", function(e){
            var confirm = e.target.value;
            if(confirm == "CONFIRM"){
                document.getElementById('user_delete_button').style.display = 'block';
            }else{
                document.getElementById('user_delete_button').style.display = 'none';
            }
            })
    </script>
    {{-- Generate random api keys --}}
    {{-- <script>
      // Generate random api-keys
        /**
            * Function to produce UUID.
            * See: http://stackoverflow.com/a/8809472
            */
            function generateUUID()
            {
                var d = new Date().getTime();

                if( window.performance && typeof window.performance.now === "function" )
                {
                    d += performance.now();
                }

                var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c)
                {
                    var r = (d + Math.random()*16)%16 | 0;
                    d = Math.floor(d/16);
                    return (c=='x' ? r : (r&0x3|0x8)).toString(16);
                });

            return uuid;
            }
    </script> --}}

@endpush

@extends('layouts.backend.app')
@section('title')
    Download Datasets
@endsection
@push('header')
    <!-- DataTables -->
  {{-- <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> --}}
  {{-- LOCAL --}}
  <link rel="stylesheet" href="{{asset('assets/backend/bootstrap 4 data table all-in-one-plugins/datatables.min.css')}}">
  {{-- CDN --}}
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/af-2.3.7/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css"/> --}}

@endpush
@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>DataSet Table</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataSet Table</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">

                </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection
@push('footer')
    <!-- DataTables  & Plugins -->
{{-- <script src="{{asset('assets/backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script> --}}
{{-- LOCAL --}}
<script src="{{asset('assets/backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/backend/bootstrap 4 data table all-in-one-plugins/datatables.min.js')}}"></script>
{{-- CDN --}}
{{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/af-2.3.7/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.js"></script> --}}
<!-- Page specific script -->
<script>
/*
https://stackoverflow.com/questions/56180040/datatables-buttons-not-showing-for-bootstrap-example/56180320
    Datatbale-dom

    B - Buttons
    l - length changing input control
    f - filtering input
    r - processing display element
    t - The table
    i - Table information summary
    p - pagination control
*/
$(function () {
    let table = $("#example1").DataTable({
        'dom' : "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "processing": true,
        // "serverSide": true,
        "ajax": {
            "url":'{{route("user.dataset.ajax")}}',
            "dataSrc":  (json) => {
                    let data = json.data;
                    console.log(data);
                    var return_data = [];
                    for(var i=0;i< data.length; i++){
                        return_data.push({
                        'id': data[i].id,
                        'first_name': data[i].first_name,
                        'last_name': data[i].last_name,
                        'age': data[i].age,
                        'dob': new Date(data[i].dob),
                        // 'address': data[i].address,
                        // 'education': data[i].education,
                        'lat': data[i].geom["\u0000*\u0000lat"],
                        'lng': data[i].geom["\u0000*\u0000lng"],
                        'created_at':new Date(data[i].created_at),
                        'updated_at':new Date(data[i].updated_at)
                        })
                    }
                    // console.log(return_data);
                    return return_data;
                }
            },
        "columns":[
                    { data: 'id', title:'ID' },
                    { data: 'first_name', title:'First Name'  },
                    { data: 'last_name' ,title:'Last Name'  },
                    { data: 'age', title:'Age' },
                    { data: 'dob', title:'DOB' },
                    // { data: 'address', title:'Address' },
                    // { data: 'education', title:'Education' },
                    { data: 'lat', title:'Latitude' },
                    { data: 'lng', title:'Longitude'},
                    { data: 'created_at', title:'Created_at'},
                    { data: 'updated_at', title:'Updated_at'},
                ],
        "responsive": true,
        // "lengthChange": true,
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "autoWidth": false,
        "searchBuilder": true,
        "buttons": ["copy", "csv", "excel", 'pdf',"print"],
        "buttons": [
                        {
                            extend:    'copyHtml5',
                            text:      'Copy',
                            titleAttr: 'Copy'
                        },
                        {
                            extend:    'excelHtml5',
                            text:      'Excel',
                            titleAttr: 'Excel'
                        },
                        {
                            extend:    'csvHtml5',
                            text:      'CSV',
                            titleAttr: 'CSV'
                        },
                        {
                            extend:    'print',
                            text:      '<i class="fa fa-print" aria-hidden="true"></i>',
                            titleAttr: 'PRINT'
                        }
                    ],
      });

    table.searchBuilder.container().prependTo(table.table().container());

    // Change pagination number on footer
    $.fn.DataTable.ext.pager.numbers_length = 4;
    });
  </script>
@endpush

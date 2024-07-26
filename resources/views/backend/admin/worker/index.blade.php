@extends('backend.layouts.master')
@section('title', 'User')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
                </div>
                <div>All User</div>
            </div>
        </div>
    </div>
    
        <div class="col-md-12">
            <div class="main-card mb-5 card">
                
                <div class="d-flex justify-content-end mt-2">
                    <a href="cetakpdfall" onclick="ajax_submit_import('workers/import')" data-toggle="tooltip" data-id="" class="btn btn-xs btn-success mr-1 cetakpdfall" title="PDF" target="_blank"><i class="fa fa-print"></i> </a>
                    <a href="excelworker" class="btn btn-info text-white" style="margin-right: 10px;">Excel</a>
                    {{-- @can('User-create') --}}
                        <button class="btn btn-success" onclick="create()" style="margin-right: 20px;">
                            <i class="glyphicon glyphicon-plus"></i> New User
                        </button>
                        <button class="btn btn-success" onclick="ajax_submit_data()" style="margin-right: 20px;">
                            <i class="glyphicon glyphicon-plus"></i> import
                        </button>
                    {{-- @endcan --}}
                  
                    <a href="{{ url('/download/template') }}" class="btn btn-primary">Download Template</a>

                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="User-table" class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimasukkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    
    



    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 80%;
                border-radius: 5px;
            }
        }
    </style>
    <script>
       $(function () {
    table = $('#User-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/allworkers',
        columns: [
            {data: 'id', name: 'id'},
            {
                data: 'name',
                name: 'name',
                
            },
            {data: 'action', name: 'action'}
        ],
        columnDefs: [
            {className: "", targets: "_all"}
        ],
        autoWidth: false,
    }); 


            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });
        });
     
    </script>
    <script type="text/javascript">
   function create() {
    ajax_submit_create('worker');
    }
  


        $(document).ready(function () {
            // // View Form
            // $("#manage_all").on("click", ".view", function () {
            //     var id = $(this).attr('id');
            //     ajax_submit_view('User', id)
            // });

            // Edit Form
            $("#User-table").on("click", ".edit", function () {
                var id = $(this).data('id');
                ajax_submit_edit('worker', id)
            });


            // Delete
            $("#User-table").on("click", ".delete", function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                ajax_submit_delete('worker', id)
            });

        });
        function ajax_submit_data(route) {
    $("#modal_data").empty();
    $('.modal-title').text('Add New'); // Set Title to Bootstrap modal title

    $.ajax({
        type: 'GET',
        url: 'admin/worker/data',
        success: function (data) {
            $("#modal_data").html(data.html);
            $('#myModal').modal('show'); // show bootstrap modal
        },
        error: function (result) {
            $("#modal_data").html("Sorry Cannot Load Data");
        }
    });
}


    </script>
@stop
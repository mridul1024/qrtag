@extends('layouts.app')

@section('content')
<style>
    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Roboto', sans-serif;
    }
    .table-responsive {
        margin: 30px 0;
    }
    .table-wrapper {
        min-width: 1000px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
        min-width: 100%;
    }
    .table-title h2 {
        margin: 8px 0 0;
        font-size: 22px;
    }
    .search-box {
        position: relative;
        float: right;
    }
    .search-box input {
        height: 34px;
        border-radius: 20px;
        padding-left: 35px;
        border-color: #ddd;
        box-shadow: none;
    }
    .search-box input:focus {
        border-color: #3FBAE4;
    }
    .search-box i {
        color: #a0a5b1;
        position: absolute;
        font-size: 19px;
        top: 8px;
        left: 10px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }
    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table td:last-child {
        width: 130px;
    }
    table.table td a {
        color: #a0a5b1;
        display: inline-block;
        margin: 0 5px;
    }
    table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 95%;
        width: 30px;
        height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 30px !important;
        text-align: center;
        padding: 0;
    }
    .pagination li a:hover {
        color: #666;
    }
    .pagination li.active a {
        background: #03A9F4;
    }
    .pagination li.active a:hover {
        background: #0397d6;
    }
    .pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 6px;
        font-size: 95%;
    }
    </style>

<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-10"><h2>Unit <b>List</b></h2></div>
                    @hasanyrole('super-admin|admin')
                    <div class="col-sm-2">

                            <a type="button" href="/unitmaster/create" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</a>

                    </div>
                    @endhasanyrole
                </div>
            </div>
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">??</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name </th>
                        <th>Created By</th>

                        <th>Created At</th>
                        @hasanyrole('super-admin|admin')
                        <th>Actions</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $unitmasters as $unitlist )
                    <tr>
                        <td>{{$unitlist->id}}</td>
                        <td> {{$unitlist->name}}</td>
                        <td>{{$unitlist->created_by}}</td>
                        <td>{{$unitlist->created_at}}</td>
                        @hasanyrole('super-admin|admin')
                        <td>
                            <!--<a href="/unitmaster/{{$unitlist->id}}/edit" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a> -->
                            @hasanyrole('super-admin|admin')
                             <a type="button" class="delete" title="Delete" data-whatever="/unitmaster/delete/{{ $unitlist->id }}" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">&#xE872;</i></a>
                            @endhasanyrole
                        </td>
                        @endhasanyrole
                    </tr>

                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">

                {{ $unitmasters->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete this Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to you want to delete this unit from unit master list? <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a type="button" id="deletecategory" href="" class="btn btn-primary">Delete</a>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script type="text/javascript" >
    $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('whatever') ;// Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            $('#deletecategory').attr('href', id);
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

@endsection

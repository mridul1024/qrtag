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
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
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

        table.table tr th,
        table.table tr td {
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

    <div class="container">
        <div class="">
            <div class="card ">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-5">
                            <p class="card-text">

                            <p>
                            <h5><b>Subcategory: </b> {{ $subcategorytype->subcategory->name }} <b>Type: </b>
                                {{ $subcategorytype->name }} </h5>
                            </p>
                            <p>
                            <h5><b>Category: </b> {{ $subcategorytype->subcategory->category->name }} </h5>
                            </p>
                            <p>
                            <h5><b>Created By:</b> {{ $subcategorytype->created_by }} </h5>
                            </p>
                            <p>
                            <h5><b>Description: </b> {{ $subcategorytype->description }} </h5>
                            </p>
                            </p>
                        </div>
                        <div class="col-md-3">

                            @if ($subcategorytype->image == null)
                                <img class="card-img" src="/storage/placeholder.png" alt="item image">
                            @else
                                <img class="card-img" src="{{ Storage::get($subcategorytype->image) }}" alt="item image">
                            @endif
                        </div>


                    </div>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h2>Published Attributes <b>List</b></h2>
                                </div>
                                <div class="col-sm-2">
                                    @hasanyrole('super-admin|admin|editor|approver')
                                    <a type="button" href="/attribute/create/{{ $subcategorytype->id }}"
                                        class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</a>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Attribute Name </th>
                                    <th>Value</th>
                                    @hasanyrole('super-admin|admin|editor|approver')
                                    @if (strcmp($subcategorytype->created_by, Auth::user()->email) == 0)
                                        <th>Action</th>
                                    @endif
                                    @endhasanyrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pattributes as $attribute)


                                    <tr>
                                        <td>{{ $attribute->id }}</td>
                                        <td> {{ $attribute->name }}</td>
                                        <td> {{ $attribute->value }}</td>

                                        <!--@hasanyrole('super-admin|admin|editor|approver')
                                                    <a href="/attribute/{{ $attribute->id }}/edit" class="edit" title="Edit"
                                                        data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                                    @endhasanyrole -->
                                        @hasanyrole('super-admin|admin')
                                        @if (strcmp($subcategorytype->created_by, Auth::user()->email) == 0)
                                            <td> <a type="button" class="delete" title="Delete"
                                                    data-whatever="/attribute/delete/{{ $attribute->id }}"
                                                    data-toggle="modal" data-target="#exampleModal"><i
                                                        class="material-icons">&#xE872;</i></a>
                                        @endif
                                        </td>
                                        @endhasanyrole

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        @if ($nattributes->isNotEmpty())
            @hasanyrole('super-admin|admin')
            <div class="container">
                <div class="row">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>UnPublished Attributes <b>List</b></h2>
                                    </div>

                                </div>
                            </div>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Attribute Name </th>
                                        <th>Value</th>
                                        @hasanyrole('admin')
                                        <th>Status</th>
                                        @endhasanyrole
                                        @hasanyrole('super-admin|admin|approver')
                                        @if (strcmp($subcategorytype->created_by, Auth::user()->email) == 0)
                                            <th>Approve / Reject / Delete</th>
                                        @endif
                                        @endhasanyrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nattributes as $attribute)


                                        <tr>
                                            <td>{{ $attribute->id }}</td>
                                            <td> {{ $attribute->name }}</td>
                                            <td> {{ $attribute->value }}</td>
                                            @hasanyrole('admin')

                                            @if ($attribute->published == 'N')
                                                <td><b style="color: blue"> Waiting for Approval </b></dd>
                                                @elseif ( $attribute->status == 'Y')
                                                    <dd> <b style="color: green"> Approved</b></dd>
                                                @elseif ( $attribute->status == 'R')
                                                    <dd> <b style="color: red"> Rejected</b><span>
                                                            due to {{ $product->rejectinfo }} </span>
                                                </td>
                                            @endif
                                            @endhasanyrole
                                            @hasanyrole('super-admin|admin|approver')
                                            @if (strcmp($subcategorytype->created_by, Auth::user()->email) == 0)
                                                <td>

                                                    <a href="/attributechange/approve/{{ $attribute->id }}" class="edit"
                                                        title="Approve" data-toggle="tooltip"><i
                                                            class="material-icons">&#xe5ca;</i></a>

                                                    <a type="button" class="delete" title="Reject"
                                                        data-whatever="/attributechange/reject/{{ $attribute->id }}"
                                                        data-toggle="modal" data-target="#exampleModal2"><i
                                                            class="material-icons">&#xe9d3;</i></a>


                                                </td>
                                            @endif
                                            @endhasanyrole
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
            @endhasanyrole
        @endif
        @if ($rattributes->isNotEmpty())
        @hasanyrole('super-admin|admin')
        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2>Rejected Attributes <b>List</b></h2>
                                </div>

                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>

                                    <th>Attribute Name </th>
                                    <th>Value</th>

                                    <th>Status</th>
                                    <th> Delete </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rattributes as $attribute)
                                    <tr>
                                        <td> {{ $attribute->name }}</td>
                                        <td> {{ $attribute->value }}</td>
                                            <td><b style="color: red"> Rejected</b><span>
                                                        due to {{ $attribute->rejectinfo }} </span>
                                            </td>
                                            <td><a type="button" class="delete" title="Delete"
                                                data-whatever="/attributechange/delete/{{ $attribute->id }}"
                                                data-toggle="modal" data-target="#exampleModal"><i
                                                    class="material-icons">&#xE872;</i></a>
                                            </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
        @endhasanyrole
        @endif
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete this attribute</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure to you want to delete this attribute from {{ $subcategorytype->name }} ? <br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a type="button" id="deletecategory" href="" class="btn btn-primary">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject this item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="formreject" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="rejectinfo">Rejection reason</label>
                                <textarea name="rejectinfo" required class="form-control " id="rejectinfo" rows="2">
                                        </textarea>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitreject" class="btn btn-primary">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('whatever'); // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

                $('#deletecategory').attr('href', id);
            });
        });

        $(document).ready(function() {
            $('#exampleModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('whatever'); // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

                $('#formreject').attr('action', id);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

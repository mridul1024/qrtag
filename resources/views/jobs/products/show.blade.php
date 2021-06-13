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

        <div class="card ">
            <h4>
                <p class="text-center" style="padding: 2em"> Item Details </p>
            </h4>
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-5">

                        <p class="card-text">

                        <p>
                        <p>
                        <h5><b>Job ID: </b> {{ $product->job_id }} </h5>
                        </p>
                        <h5><b>Material id: </b> <br> {{ $product->material_id }}</h5>
                        </p>
                        <p>
                        <h5><b>Category: </b> {{ $product->subcategorytype->subcategory->category->name }} </h5>
                        </p>
                        <p>
                        <h5><b>Sub Category: </b> {{ $product->subcategorytype->subcategory->name }} </h5>
                        </p>
                        <p>
                        <h5><b>Type: </b> {{ $product->subcategorytype->name }} </h5>
                        </p>
                        <p>
                        <h5><b>Created By:</b> {{ $product->created_by }} </h5>
                        </p>
                        <p>
                        <h5><b>Type Description: </b> {{ $product->subcategorytype->description }} </h5>
                        </p>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center"  style="width: 18rem;">
                        <img class="card-img" src="/storage/{{ $product->subcategorytype->image }}" alt="item image">
                        </div>
                    </div>
                    <div class="col-md-4">

                           <div class="visible-print text-center">
                               <div id="printableArea">
                                            {!! QrCode::size(250)->generate(Request::url()) !!}
                                            <p>Scan this to return to this product</p>
                               </div>

                                            <input type="button" onclick="printDiv('printableArea')" value="Print QR" />
                                        </div>
 <!--
                            <form method="POST" action="/product/generateQr">
                                @csrf
                                @method('PUT')
                                <input type="text" hidden name="qrcode" value="{!! Request::url() !!}" class="form-control"
                                    id="qrcode">
                                    <input type="text" hidden name="id" value="{{ $product->id }}" class="form-control"
                                   >
                                <button type="submit" class="btn btn-warning">Generate QR </button> <br>
                            </form>-->


                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <h5>Attributes</h5>
                        </div>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Value</th>
                                <th scope="col">Unit</th>

                              </tr>
                            </thead>
                            <tbody>

                                @foreach ($product->productsattributes as $attr)
                                <tr>

                                <td scope="row">{{ $attr->name }} </td>
                                    <td>{{ $attr->value }}</td>
                                    <td>{{ $attr->value }}</td>
                                </tr>
                                @endforeach



                            </tbody>
                          </table>

                    </div>


                </div>
            </div>


        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}


    </script>
@endsection
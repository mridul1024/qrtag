@extends('layouts.app')

@section('content')

    <div class="container card" style="padding: 2em">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="text-center">Edit Item </h4>
            </div>

        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <form action="/product/store" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-12">

                    <input type="text" name="job_id" hidden value="{{ $id }}" class="form-control"
                        id="inputName4">

                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sub_category_name"> Category</label>
                    <select class="form-control formselect " required placeholder="Select Category" id="sub_category_name">
                        <option value="0" disabled selected>Select
                            Main Category*</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ ucfirst($category->name) }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sub_category">Sub Category</label>
                    <select class="form-control formselect " required placeholder="Select Sub Category" id="sub_category">
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sub_categorytype">Type</label>
                    <select class="form-control formselect " required name="subcategorytype_id"
                        placeholder="Select Sub Category type" id="sub_categorytype">
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputName4">BU Code</label>
                    <input type="text" required name="bu_code" class="form-control"  value="{{ old('bu_code') }}" id="inputName4" placeholder="Enter BU code">

                </div>
                <div class="form-group col-md-6">
                    <label for="inputName4">Warehouse Code</label>
                    <input type="text" required name="wh_code" class="form-control"  value="{{ old('wh_code') }}" id="inputName4" placeholder="Enter Warehouse Code">

                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputName4">Location</label>
                        <p>Click the button to get your coordinates.</p>
                        <button disabled onclick="">Get Location</button>
                        <div id="latitude">It is disabled on web app</div>
                        <div id="longitude">
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="dynamic1">Attribute</label>
                            <div id="dynamic1"></div>
                            <div id="dynamic3"></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="dynamic2">Value</label>

                            <div id="dynamic2"></div>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="unit">Unit</label>
                            <div id="unit"></div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>

        </form>
    </div>




    <script>
        $(document).ready(function() {
            $('#sub_category_name').on('change', function() {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/product/getsubcategories/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#sub_category').empty();
                        $('#sub_category').append(
                            `<option value="0" disabled selected>Select Sub Category*</option>`
                        );
                        response.forEach(element => {
                            $('#sub_category').append(
                                `<option value="${element['id']}">${element['name']}</option>`
                            );
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#sub_category').on('change', function() {
                let id = $(this).val();
                $('#sub_categorytype').empty();
                $('#sub_categorytype').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: '/product/gettypes/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#sub_categorytype').empty();
                        $('#sub_categorytype').append(
                            `<option value="0" disabled selected>Select Sub Category*</option>`
                        );
                        response.forEach(element => {
                            $('#sub_categorytype').append(
                                `<option value="${element['id']}">${element['name']}</option>`
                            );
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#sub_categorytype').on('change', function() {
                var i = 0;
                let id = $(this).val();
                $('#dynamic1').empty();
                $('#dynamic2').empty();
                $('#dynamic3').empty();
                $('#unit').empty();
                $.ajax({
                    type: 'GET',
                    url: '/product/getattributes/' + id,
                    success: function(response) {

                        var response = JSON.parse(response);
                        console.log(response);
                        $('#dynamic1').empty();
                        $('#dynamic2').empty();
                        $('#dynamic3').empty();
                        $('#unit').empty();
                        //$('#sub_categorytype').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                        response.forEach(element => {
                            $('#dynamic1').append(
                                `<input type="text" hidden required name="dynamic[` +
                                i +
                                `][name]" value="${element['name']}"
                                    class="form-control"  placeholder="Name">`
                            );
                            $('#dynamic3').append(
                                `<div class="form-control">${element['name']}</div> `
                            );
                            var value = null;
                            value = element['value'];
                            if (value == null) {
                                value = '';
                            }
                            $('#dynamic2').append(
                                `<input type="text" required  name="dynamic[` +
                                i +
                                `][value]" value="` + value +
                                `" class="form-control"  placeholder="Enter Value">`
                            );
                            $('#dynamic4').append(
                                `<input type="text" hidden required name="dynamic[` +
                                i + `][unit]" value="${element['unit']}"
                                                    class="form-control"  placeholder="Name">`
                            );

                            // console.log(value['units']);


                            i++;


                        });
                        //
                        var j = 0;
                        $('#unit').empty();


                        $.ajax({
                            type: 'GET',
                            url: '/product/getunits/',
                            success: function(response) {

                                var response = JSON.parse(response);
                                console.log(j);
                                while (j < i) {

                                    $('#unit').append(
                                        `<select  class="form-control formselect " required  name="dynamic[` +
                                        j + `][unit]" id="unit` + j + `" placeholder="Select Unit"  required="required">
                                                                    </select> `
                                    );
                                    $('#unit' + j).append(
                                        `<option value="" >Select Unit</option>`
                                    );
                                    console.log('break');
                                    //$('#sub_categorytype').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                                    response.forEach(element1 => {
                                        $('#unit' + j).append(
                                            `<option value="${element1['name']}">${element1['name']}</option>`
                                        );

                                    });
                                    j++;
                                }
                            }
                        });



                        //
                    }
                });
            });
        });
    </script>

    </body>


@endsection

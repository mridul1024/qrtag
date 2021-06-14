@extends('layouts.app')

@section('content')
    {{-- <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }

    </style>

    <div class="container card" style="padding: 1em">

        <div class="row">
            <div class="col-sm-12">
                <h2>Create Type of subcategory  <div id="pi"></div></h2>
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
        <form method="POST" action="/product/create/{{ $id }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputRole">Category</label>
                    <select id="inputRole" name="category" id="category" class="browser-default custom-select">
                        <option selected value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputRole2">SubCategory</label>
                    <select id="inputRole2" name="subcategory" id="subcategory" class="browser-default custom-select ">
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputRole3">Type</label>
                    <select id="inputRole3" name="type" id="type" class="browser-default custom-select ">
                    </select>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>

        </form>

    </div>
    </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // window.onload = function() {
        //     if (window.jQuery) {
        //         // jQuery is loaded
        //         alert("Yeah!");
        //        // $("#pi").text("Hello world!");
        //         //alert("Yeah!");
        //     } else {
        //         // jQuery is not loaded
        //         alert("Doesn't Work");
        //     }
        // }
        // $(document).ready(function() {
        //    // $("#p").text("Hello world!");
        //     $('#category').on('change', function() {
        //         $("#p").text("Hello world!");
        //         let category = $(this).val();
        //         $.ajax({
        //             url: "/product/getsubcategories/",
        //             type: "POST",
        //             data: {
        //                 category: category
        //             },
        //             success: function(data) {
        //                 var response = JSON.parse(response);
        //                 console.log(data);
        //                 $('#subcategory').empty();

        //                 $.each(data.subcategories, function(index,
        //                 subcategory) {
        //                     $('#subcategory').append('<option value="' + subcategory
        //                         .id + '">' + subcategory.name + '</option>');
        //                 });
        //             }

        //         });
        //     });
        //     // $('#type').on('change', function(e) {
        //     //     var subcategory_id = e.target.value;
        //     //     $.ajax({
        //     //         url: "/product/gettypes/",
        //     //         type: "POST",
        //     //         data: {
        //     //             subcategory_id: subcategory_id
        //     //         },
        //     //         success: function(data) {
        //     //             $('#type').empty();
        //     //             $.each(types, function(index,
        //     //             type) {
        //     //                 $('#subcategory').append('<option value="' + type
        //     //                     .id + '">' + type.name + '</option>');
        //     //             })
        //     //         }
        //     //     })
        //     // });
        // });
        $(document).ready(function () {
            console.log( "ready!" );
                $('#category').on('change', function () {
                    alert("Yeah!");
            //     let id = $(this).val();
            //     $('#subcategory').empty();
            //     $('#subcategory').append(`<option value="0" disabled selected>Processing...</option>`);
            //     $.ajax({
            //     type: 'GET',
            //     url: '/product/getsubcategories/' + id,
            //     success: function (response) {
            //     var response = JSON.parse(response);
            //     console.log(response);
            //     $('#subcategory').empty();
            //     $('#subcategory').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
            //     response.forEach(element => {
            //         $('#subcategory').append(`<option value="${element['id']}">${element['name']}</option>`);
            //         });
            //     }
            // });
        });
    });
    </script> --}}
    <div class="container card" style="padding: 2em">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="text-center">Create an Item </h4>
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputName4">Quantity</label>
                        <input type="text" name="quantity" value="{{ old('quantity')}}" class="form-control " required id="inputName4"
                            placeholder="Enter Quanitity (Must be a number)">

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="inputName4">Location</label>
                        <p>Click the button to get your coordinates.</p>
                        <button onclick="getLocation()">Get Location</button>
                        <div id="latitude"></div>
                        <div id="longitude"><div>
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
                        <div id="dynamic4"></div>
                        <div id="dynamic5"></div>

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
                $.ajax({
                    type: 'GET',
                    url: '/product/getattributes/' + id,
                    success: function(response) {

                        var response = JSON.parse(response);
                        console.log(response);
                        $('#dynamic1').empty();
                        $('#dynamic2').empty();
                        //$('#sub_categorytype').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                        response.forEach(element => {
                            $('#dynamic1').append(
                                `<input type="text" hidden required name="dynamic[` + i +
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
                                `<input type="text"  required name="dynamic[` + i +
                                `][value]" value="` + value +
                                `" class="form-control"  placeholder="Enter Value( Must be a number)">`
                            );
                            $('#dynamic4').append(
                                `<input type="text" hidden required name="dynamic[` + i +
                                `][unit]" value="${element['unit']}"
                                class="form-control"  placeholder="Name">`
                            );
                            $('#dynamic5').append(
                                `<div class="form-control">${element['unit']}</div> `
                            );
                            i++;
                        });
                    }
                });
            });
        });

    </script>
    <script>
        var x = document.getElementById("latitude");

        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
        }

        function showPosition(position) {
          x.innerHTML = "Latitude: " + position.coords.latitude +
          "<br>Longitude: " + position.coords.longitude;
        }
        </script>
    </body>


@endsection

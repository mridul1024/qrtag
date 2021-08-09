@extends('layouts.app')
@section('content')
    <style>
        .gallery-wrap .img-big-wrap img {
            height: 450px;
            width: auto;
            display: inline-block;
            cursor: zoom-in;
        }

        .gallery-wrap .img-small-wrap .item-gallery {
            width: 60px;
            height: 60px;
            border: 1px solid #ddd;
            margin: 7px 2px;
            display: inline-block;
            overflow: hidden;
        }

        .gallery-wrap .img-small-wrap {
            text-align: center;
        }

        .gallery-wrap .img-small-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 4px;
            cursor: zoom-in;
        }

           /* Media Query for Mobile Devices */
           @media (max-width: 480px) {
                 #mapid { height: 400px; width : 270px;}
                 #pic1 { width: 25em; padding: 2em;}
        }

        /* Smartphones (landscape) ----------- */
        @media only screen and (min-width : 480px) {
            #mapid { height: 400px; width : 360px;}
            #pic1 { width: 20em; padding: 2em;}

        }
        /* Media Query for Laptops and Desktops */
        @media only screen  and (min-width : 1224px) {
            #mapid { height: 500px; width : 900px;}/* CSS */
            #pic1 { width: 30em ; padding: 2em;}


        }

    </style>

    <div class="container">
        <br>
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

        <div class="card">
            <div class="row">

                <aside class="col-sm-12">
                    <div class="card-title text-center" style="padding-top: 1em"><h1>Edit Item </h1></div> <hr>
                    <article class="card-body p-5">
                        <h3 class="title mb-3">Item Name: {{ $product->subcategorytype->name }}</h3>

                        <p class="price-detail-wrap">
                            <span class="price h3 ">
                                <span class="currency">Subcategory: {{ $product->subcategorytype->subcategory->name }}</span>
                            </span>

                        </p> <!-- price-detail-wrap .// -->
                        <dl class="item-property">
                            <dt>Description</dt>
                            <dd>
                                <p>{{ $product->subcategorytype->description }} </p>
                            </dd>
                        </dl>
                        <dl class="param param-feature">
                            <dt>Material Id</dt>
                            <dd>{{ $product->material_id }}</dd>
                        </dl> <!-- item-property-hor .// -->
                        <dl class="param param-feature">
                            <dt>Parent Category</dt>
                            <dd>{{ $product->subcategorytype->subcategory->category->name }}</dd>
                        </dl>
                        <dl class="param param-feature">
                            <dt>Subcategory</dt>
                            <dd>{{ $product->subcategorytype->subcategory->name }}</dd>
                        </dl>
                        <dl class="param param-feature">
                            <dt>Created By</dt>
                            <dd>{{ $product->created_by }}</dd>
                        </dl> <!-- item-property-hor .// -->
                        <dl class="param param-feature">
                            <dt>Status</dt>
                                @if ($product->status == 'N')
                                <dd><b style="color: blue"> Waiting for Approval </b></dd>
                            @elseif ( $product->status == 'Y')
                            <dd> <b style="color: green"> Approved</b></dd>
                            @elseif ( $product->status == 'R')
                            <dd> <b style="color: red"> Rejected</b><span>
                                 due to {{ $product->rejectinfo }} </span></dd>
                             @endif

                        </dl> <!-- item-property-hor .// -->

                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <dl class="param param-inline">
                                    <dt>Attributes: </dt>

                                    <dd>
                                        <form action="/product/update" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                        <table class="table">
                                            <thead>
                                              <tr>

                                                <th scope="col"> </th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Unit</th>
                                              </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($product->productsattributes as $attr)
                                                <tr>

                                                <td> {{ $attr->name }}</td>
                                                <td><input type="hidden" name="dynamic[{{$loop->index}}][productid]" value="{{ $attr->id }}"> <input type="text" class="form-control" required name="dynamic[{{$loop->index}}][value]" value="{{ $attr->value }}"></td>
                                                <td>
                                                    <select class="form-control" required name="dynamic[{{$loop->index}}][unit]">
                                                    @foreach ($units as $unit )
                                                    @if($attr->unit == $unit->name)

                                                    <option  value="{{$unit->name}}" selected>{{$unit->name}}</option>
                                                    @else
                                                        <option value="{{$unit->name}}">{{$unit->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                    </td>
                                              </tr>
                                              @endforeach
                                            </tbody>
                                          </table>


                                    </dd>

                                </dl> <!-- item-property .// -->
                            </div> <!-- col.// -->
                          <!-- col.// -->
                        </div> <!-- row.// -->
                        <hr>
                        <button class="btn btn-primary" type="submit">Update</button>
                     </div>
                        </form>
                    </article> <!-- card-body.// -->
                </aside> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->


    </div>



@endsection

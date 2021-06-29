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
@if($product != NULL)
    <div class="container">
        <br>


        <div class="card">
            <div class="row">
                <aside class="col-sm-5 border-right">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap">
                            <div>
                             @if ($product->subcategorytype->image == null)
                                <img id="pic1" src="/storage/placeholder.png" alt="item image">
                            @else
                                <img id="pic1"  src="/storage/{{ $product->subcategorytype->image }}"
                                    alt="item image">
                            @endif
                            </a></div>
                        </div> <!-- slider-product.// -->
                        <div class="img-big-wrap">
                            <div class="visible-print text-center">
                                <div id="printableArea" onclick="">
                                    {!! QrCode::size(250)->generate(Request::url()) !!}
                                    <p>Scan this to return to this product</p>
                                </div>


                            </div>
                        </div>
                       <!--  <div class="img-small-wrap">
                            <div class="item-gallery">
                                @if ($product->subcategorytype->image == null)
                                <img  src="/storage/placeholder.png" alt="item image">
                            @else
                                <img  src="/storage/{{ $product->subcategorytype->image }}"
                                    alt="item image">
                            @endif
                            </div>
                            <div class="item-gallery">
                                <div class="visible-print text-center">
                                    <div id="printableArea" onclick="window.print(this)">
                                        {!! QrCode::size(250)->generate(Request::url()) !!}
                                        <p>Scan this to return to this product</p>
                                    </div>

                                    <input type="button" onclick="printDiv('printableArea')" value="Print QR" />
                                </div>
                            </div>

                        </div> slider-nav.// -->
                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <aside class="col-sm-7">
                    <article class="card-body p-5">
                        <h3 class="title mb-3">{{ $product->subcategorytype->name }}</h3>

                        <p class="price-detail-wrap">
                            <span class="price h3 text-warning">
                                <span class="currency">{{ $product->subcategorytype->subcategory->name }}</span>
                            </span>
                            <span>-subcategory</span>
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
                                                <td> {{ $attr->value }}</td>
                                                <td> {{ $attr->unit }}</td>
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

                    </article> <!-- card-body.// -->
                </aside> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->


    </div>
    <!--container.//-->
    @if ($product->latitude != null)

    <div hidden id="latitude"> {{$product->latitude}} </div>
    <div hidden id="longitude"> {{$product->longitude}} </div>
        <div class="container">
            <div class="row" style="padding: 2em">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> Location of the item </h5>
                <div class="card-text col-md-12 center-text">
                    <div id="mapid" ></div>
                </div>
                </div>
            </div>

            </div>
        </div>
    @endif
    @else
    <div class="container">
    <p style="text-center"> <h4> Product not approved </h4> </p></div>
    @endif
    <script>
        var mymap = L.map('mapid').setView([51.505, -0.09], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiZGhydWJhbmthMTAiLCJhIjoiY2twdjdwczZyMXUzcDJuczR6Mm84d2dobSJ9.B0vm6Oe9UKnf56zHcyofUg'
        }).addTo(mymap);
        var latitude = document.getElementById('latitude').innerHTML;
        var longitude = document.getElementById('longitude').innerHTML;
        mymap.panTo(new L.LatLng(latitude, longitude));
        var popup = L.popup()
            .setLatLng([latitude, longitude])
            .setContent("Inserted Here.")
            .openOn(mymap);

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

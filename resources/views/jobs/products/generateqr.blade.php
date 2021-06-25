@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="text-center" style="margin: 2em">
            <div class="btn btn-info add-new" id="printbtn" onclick="printDiv()" value="Print QR"> Print</div>
        </div>
        <div class="row">

            @foreach ($items as $item)
                <div class="col ">
                    <div id="printableArea">
                        <div style="padding: 1em">
                            {!! QrCode::size($height)->generate(url('/product/show/' . $item->id)) !!}
                            <p> <small>{{ $item->material_id }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

<script>
    function printDiv() {
        var div = document.getElementById("printbtn");
        if (div.style.display !== "none") {
            div.style.display = "none";
        }
        window.print();
        if (div.style.display == "none") {
            div.style.display = "block";
        }
    }
</script>
@endsection

@extends('layouts.app')
@section('content')
<style>

@media print {
  figure {
    break-inside: avoid;

  }
}

</style>

<div class="container">
        <div class="text-center" style="margin: 2em">
            <div class="btn btn-info add-new" id="printbtn" onclick="printDiv()" value="Print QR"> Print</div>
        </div>

        <div class="row">
            @foreach ($items as $item)

                <div class="col" id="print1" >
                        <figure class="visible-print text-center" style="padding: 1em">
                            {!! QrCode::size($height)->generate(url('/product/show/' . $item->id)) !!}
                            <p><small>{{ $item->material_id }}</small></p>
                        </figure>
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

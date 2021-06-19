@extends('layouts.app')

@section('content')
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }



    </style>

<div class="container card" style="padding: 1em">

                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Create <b>Attribute</b> </h2>
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
                <form method="POST" action="{{ route('attributemaster-store') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputName4">Attribute Name</label>
                            <input type="text" name="name" class="form-control" id="inputName4" placeholder="Name">

                        </div>
                    </div>

                    <div class="form-group  row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>

                </form>


    </div>


@endsection

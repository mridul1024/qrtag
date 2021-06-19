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
                            <h2>Assign <b>Attribute</b> to this type of subcategory</h2>
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
                @hasanyrole('super-admin|admin|approver')
                <form method="POST" action="{{  route('attribute-store')  }}" >
                    @csrf


                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="inputRole">Attribute Name</label>
                        <select id="inputRole" name="name" id="name" class="form-control ">
                            <option selected value="">Select Attribute</option>
                            @foreach ($attributemasters as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach

                        </select>
                        </div>
                    </div>
                    <input hidden name="subcategorytype_id" value="{{ $id }}" placeholder="sub">
                        <div class="form-group row">
                            <div class="form-group col-md-12">
                            <label for="inputName2">Attribute Value</label>
                            <input type="text" name="value" class="form-control" id="inputName2" placeholder="Value">
                            </div>
                        </div>


                    <div class="form-group  row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>

                </form>
                @endhasanyrole

                @hasanyrole('editor')
                <form method="POST" action="{{  route('attributechange-store')  }}" >
                    @csrf


                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="inputRole">Attribute Name</label>
                        <select id="inputRole" name="name" id="name" class="form-control ">
                            <option selected value="">Select Attribute</option>
                            @foreach ($attributemasters as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach

                        </select>
                        </div>
                    </div>
                    <input hidden name="subcategorytype_id" value="{{ $id }}" placeholder="sub">
                        <div class="form-group row">
                            <div class="form-group col-md-12">
                            <label for="inputName2">Attribute Value</label>
                            <input type="text" name="value" class="form-control" id="inputName2" placeholder="Value">
                            </div>
                        </div>

                    <div class="form-group  row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>

                </form>
                @endhasanyrole


    </div>


@endsection

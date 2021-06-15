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
                            <h2>Update Type </h2>
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
                <form method="POST" action="/subcategorytype/update/{{ $subcategorytype->id}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="inputRole">Parent Category</label>
                        <input type="text" disabled class="form-control" id="inputName4" value="{{$subcategorytype->subcategory->category->name}}" placeholder=" {{ $subcategorytype->subcategory->category->name}}">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">

                        <input type="text" name="subcategory_id" hidden value="{{$subcategorytype->subcategory_id}}" class="form-control" id="inputName4" >

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputName4">Type Name</label>
                            <input type="text" name="name" value="{{$subcategorytype->name}}" class="form-control" id="inputName4" placeholder="Name">

                        </div>
                    </div>
                    <!--    <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label">Enter Description</label>
                            <div class="col-md-10">
                            <textarea name="description" class="form-control " id="description" rows="5">
                            </textarea>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="file" class="col-md-2 col-form-label">Change Product Display Image</label>
                            <input type="file" class="form-control-file col-md-4"
                                name="image"
                                id="File">
                        </div>


                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


@endsection

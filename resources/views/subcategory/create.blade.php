@extends('layouts.app')

@section('content')
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }



    </style>

    <div class="container-xl">

                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Create <b>SubCategory</b></h2>
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
                <form method="POST" action="{{ route('subcategory-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                        <label for="inputRole">Category</label>
                        <select id="inputRole" name="category_id" id="category_id" class="form-control ">
                            <option selected value="">Select Parent Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputName4">SubCategory Name</label>
                            <input type="text" name="name" class="form-control" id="inputName4" placeholder="Name">

                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-2 col-form-label">SubCategory Description</label>
                            <div class="col-md-10">
                            <textarea name="description" class="form-control " id="description" rows="5">
                            </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="file" class="col-md-2 col-form-label">Upload Product Display Image</label>
                            <input type="file" class="form-control-file col-md-4"
                                name="image"
                                id="File">
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


@endsection

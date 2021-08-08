@extends('layouts.app')

@section('content')
    <div class="container">


        <h2 class="text-center">
            Master Tables Excel/CSV Import
        </h2>

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{ Session::get('error') }}</strong>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif



        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            Choose your xls/csv File :
            <div x-data="{ isOpen: false ,buttonDisabled: true  }">
            <input type="file" name="file" x-ref="file" x-on:change="buttonDisabled = false" class="form-control" required id="poster" style="margin-top: 2em;margin-bottom:2em">

            <input type="submit" value="Submit" class="btn btn-success" x-ref="button" @click=" isOpen = !isOpen " x-bind:disabled="buttonDisabled">
            <div x-show="isOpen">Importing....Please Wait till you receive a success message. It will take a while!</div>

        </div>
        </form>

    </div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Roboto', sans-serif;
    }

    .hint-text {
        float: left;
        margin-top: 6px;
        font-size: 95%;
    }
    </style>

<div class="container-xl">
    <h1> User Details</h1>
    <div class="row">

        <div class="col">
            <b>Name : </b> {{ $user->name}} <br>
            <b>Email : </b> {{ $user->email}} <br>
            <b>Role : </b> {{$role}} <br>
            <b>Date of Creation : </b> {{$user->created_at}} <br>
        </div>
        <div class="col">
            <h4>Permissions Available</h4>
            <ul>
                @foreach ( $permissions as $permission )
                    <li> {{$permission->name}} </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


@endsection

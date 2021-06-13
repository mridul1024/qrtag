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

        <div class="card col">
            <p><b>Name : </b> {{ $user->name}} <br></p>
            <p><b>Email : </b> {{ $user->email}} <br></p>
            <p><b>Phone : </b> {{$user->phone}} <br></p>
            <p><b>Role : </b> {{$role[0]}} <br></p>
            <p><b>Date of Creation : </b> {{$user->created_at}} <br></p>
        </div>
        <div class="col">
            <h4>Permissions Available</h4>
            <ul>
                @if ( $role[0] == 'super-admin')
                <li> ALL PERMISSIONS GRANTED </li>
                @endif
                @foreach ( $permissions as $permission )
                    <li> {{$permission->name}} </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


@endsection

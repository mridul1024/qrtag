@extends('layouts.app')

@section('content')
    <div class="container">
        <!--<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row justify-content-center" style="margin-top: 3em" >
            @hasanyrole('super-admin|admin')
            <div class="card col-4 text-white bg-danger mb-3" style="margin: 1em">
                <div class="card-header text-center"><b>TOTAL USERS</b></div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ App\User::count()}}</h5>
                    <p class="card-text text-center"><a href="/users" class="btn btn-light">View</a></p>
                </div>
            </div>
            @endhasanyrole
            <div class="card col-4 text-white bg-success mb-3" style="18rem;margin: 1em">
                <div class="card-header text-center"><b>TOTAL CATEGORIES</b></div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ App\Category::count()}}</h5>
                    <p class="card-text text-center"><a href="/categories" class="btn btn-light">View</a></p>
                </div>
            </div>
            <div class="card col-4 text-white bg-secondary mb-3" style="margin: 1em">
                <div class="card-header text-center"><b>TOTAL SUBCATEGORIES</b></div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ App\Subcategory::count()}}</h5>
                    <p class="card-text text-center"><a href="/subcategories" class="btn btn-light">View</a></p>
                </div>
            </div>
            @hasanyrole('super-admin|admin')
            <div class="card col-4 text-white bg-info mb-3" style="margin: 1em">
                <div class="card-header text-center"><b>TOTAL ATTRIBUTES</b></div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ App\AttributeMaster::count()}}</h5>
                    <p class="card-text text-center"><a href="/attributemasters" class="btn btn-light">View</a></p>
                </div>
            </div>
            @endhasanyrole
        </div>


    </div>
@endsection

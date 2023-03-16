@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="cart-body p-5">
                    <h5 class="">Hello World</h5>
                    <div class="text-center">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

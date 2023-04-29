@extends('layouts.app_plane')

@section('title', 'Login Page')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-content-center" style="height: 100vh;">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Ninja HR" width="75px">
                </div>
                <div class="card ">
                    <div class="card-body">
                        <h5 class=" text-center">Login</h5>
                        <p class="text-muted text-center">Please fill the login form</p>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="my-3">
                                <div class="form-outline">
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" autocomplete="email"
                                        autofocus required id="validation">
                                    <label for="" class="form-label">Email</label>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="my-3">
                                <div class="form-outline ">
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    <label for="" class="form-label">Password</label>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="my-3 ">
                                <button class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

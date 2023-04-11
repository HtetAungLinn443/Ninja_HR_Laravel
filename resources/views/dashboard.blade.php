@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row ">
                <div class=" col-12 ">
                    <div class=" text-center">
                        <img src="{{ $employee->profile_img_path() }}" class="profile-img" alt="">
                        <div class="py-3 px-2">
                            <h4 class="text-capitalize">{{ $employee->name }}</h4>
                            <p class=" mb-2">
                                <span class="text-muted">{{ $employee->employee_id }}</span> | <span
                                    class="text-theme">{{ $employee->phone }}</span>
                            </p>
                            <p class=" text-muted mb-2"><span
                                    class=" badge rounded-pill badge-dark p-2">{{ $employee->department ? $employee->department->title : '-' }}</span>
                            </p>
                            <p class=" text-muted mb-2">
                                @foreach ($employee->roles as $role)
                                    <span class=" badge rounded-pill badge-primary p-2">{{ $role->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



@endsection

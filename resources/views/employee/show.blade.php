@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6 border-dash">
                    <p class="mb-1"><b>Phone</b>: <span class=" text-muted">{{ $employee->phone }}</span></p>
                    <p class="mb-1"><b>Email</b>: <span class=" text-muted">{{ $employee->email }}</span></p>
                    <p class="mb-1"><b>NRC Number</b>: <span class=" text-muted">{{ $employee->nrc_number }}</span></p>
                    <p class="mb-1"><b>Address</b>: <span class=" text-muted">{{ $employee->address }}</span></p>
                    <p class="mb-1"><b>Gender</b>: <span class=" text-muted">{{ ucfirst($employee->gender) }}</span></p>
                    <p class="mb-1"><b>Birthday</b>: <span class=" text-muted">{{ $employee->birthday }}</span></p>
                    <p class="mb-1"><b>Date Of Join</b>: <span class=" text-muted">{{ $employee->date_of_join }}</span>
                    </p>
                    <p class="mb-1"><b>Is Present?</b>:
                        @if ($employee->is_present == 1)
                            <span class=" badge badge-pill badge-success">Present</span>
                        @else
                            <span class=" badge badge-pill badge-danger">Leave</span>
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection

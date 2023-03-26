@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Employee ID</p>
                        <p class="my-0 text-muted">{{ $employee->employee_id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Name</p>
                        <p class="my-0 text-muted">{{ $employee->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Email</p>
                        <p class="my-0 text-muted">{{ $employee->email }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Phone</p>
                        <p class="my-0 text-muted">{{ $employee->phone }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Gender</p>
                        <p class="my-0 text-muted">{{ ucfirst($employee->gender) }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Address</p>
                        <p class="my-0 text-muted">{{ $employee->address }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Department</p>
                        <p class="my-0 text-muted">{{ $employee->department ? $employee->department->title : '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>NRC Number</p>
                        <p class="my-0 text-muted">{{ $employee->nrc_number }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Birthday</p>
                        <p class="my-0 text-muted">{{ $employee->birthday }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Date Of Join</p>
                        <p class="my-0 text-muted">{{ $employee->date_of_join }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fab fa-gg me-2"></i>Is Present</p>
                        <p class="my-0 text-muted">
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
    </div>
@endsection

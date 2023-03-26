@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('employee.update', $employee->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="my-2">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('employeeId') is-invalid @enderror" name="employeeId"
                            value="{{ old('employeeId', $employee->employee_id) }}">
                        <label for="" class="form-label">Employee ID</label>
                    </div>
                    @error('employeeId')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $employee->name) }}">
                        <label for="" class="form-label">Name</label>
                    </div>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone', $employee->phone) }}">
                        <label for="" class="form-label">Phone</label>
                    </div>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('nrcNumber') is-invalid @enderror" name="nrcNumber"
                            value="{{ old('nrcNumber', $employee->nrc_number) }}">
                        <label for="" class="form-label">NRC Number</label>
                    </div>
                    @error('nrcNumber')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $employee->email) }}">
                        <label for="" class="form-label">Email</label>
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="">
                        <label for="">Gender</label>
                        <select name="gender" id="" class=" form-select @error('gender') is-invalid @enderror">
                            <option value="">Choose Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}
                                @if ($employee->gender == 'male') selected @endif>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}
                                @if ($employee->gender == 'female') selected @endif>Female</option>
                        </select>
                    </div>
                    @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="text" class="form-control birthday @error('birthday') is-invalid @enderror"
                            name="birthday" value="{{ old('birthday', $employee->birthday) }}">
                        <label for="" class="form-label">Birthday</label>
                    </div>
                    @error('birthday')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my">
                    <div class="form-outline">
                        <textarea class="form-control @error('address') is-invalid @enderror" rows="4" name="address">{{ old('address', $employee->address) }}</textarea>
                        <label class="form-label">Address</label>
                    </div>
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="">
                        <select name="department" id=""
                            class="form-select @error('department') is-invalid @enderror">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department') == $department->title ? 'selected' : '' }}
                                    @if ($department->title == $employee->title) selected @endif>
                                    {{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('department')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="text" class="form-control date_of_join @error('date_of_join') is-invalid @enderror"
                            name="date_of_join" value="{{ old('date_of_join', $employee->date_of_join) }}">
                        <label for="" class="form-label">Date of Join</label>
                    </div>
                    @error('date_of_join')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="">
                        <label for="">Is Present?</label>
                        <select name="is_present" id=""
                            class="form-select @error('is_present') is-invalid @enderror">
                            <option value="">Choose Option</option>
                            <option value="1" {{ old('is_present') == '1' ? 'selected' : '' }}
                                @if ($employee->is_present == 1) selected @endif>Yes</option>
                            <option value="0" {{ old('is_present') == '0' ? 'selected' : '' }}
                                @if ($employee->is_present == 0) selected @endif>No</option>
                        </select>
                    </div>
                    @error('is_present')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="my-2">
                    <div class="form-outline">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" value="{{ old('password') }}">
                        <label for="" class="form-label">Password</label>
                    </div>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <input type="hidden" name="id" value="{{ $employee->id }}">
                <div class="mt-5 mb-4 d-flex justify-content-center ">
                    <div class="col-md-5">
                        <button class="btn  btn-primary btn-block">
                            Continute
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.birthday').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY-MM-YY",
                }
            });
            $('.date_of_join').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-YY",
                }
            });


        })
    </script>
@endsection

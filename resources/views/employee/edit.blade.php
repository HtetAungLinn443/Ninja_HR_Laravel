@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('employee.update', $employee->id) }}" method="post" id="edit-form"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('employeeId') is-invalid @enderror" name="employeeId"
                            value="{{ old('employeeId', $employee->employee_id) }}" autofocus>
                        <label class="form-label">Employee ID</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $employee->name) }}">
                        <label class="form-label">Name</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone', $employee->phone) }}">
                        <label class="form-label">Phone</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('nrcNumber') is-invalid @enderror" name="nrcNumber"
                            value="{{ old('nrcNumber', $employee->nrc_number) }}">
                        <label class="form-label">NRC Number</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $employee->email) }}">
                        <label class="form-label">Email</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class=" form-select @error('gender') is-invalid @enderror">
                            <option value="">Choose Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}
                                @if ($employee->gender == 'male') selected @endif>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}
                                @if ($employee->gender == 'female') selected @endif>Female</option>
                        </select>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control birthday @error('birthday') is-invalid @enderror"
                            name="birthday" value="{{ old('birthday', $employee->birthday) }}">
                        <label class="form-label">Birthday</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <textarea class="form-control @error('address') is-invalid @enderror" rows="4" name="address">{{ old('address', $employee->address) }}</textarea>
                        <label class="form-label">Address</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="">
                        <label for="department">Department</label>
                        <select name="department" id="department"
                            class="form-select @error('department') is-invalid @enderror">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department') == $department->title ? 'selected' : '' }}
                                    @if ($department->title == $employee->title) selected @endif>
                                    {{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <div class="">
                        <label>Role (or) Designation</label>
                        <select name="roles[]" class="form-select custom-select @error('roles') is-invalid @enderror"
                            multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @if (in_array($role->id, $old_roles)) selected @endif>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control date_of_join @error('date_of_join') is-invalid @enderror"
                            name="date_of_join" value="{{ old('date_of_join', $employee->date_of_join) }}">
                        <label class="form-label">Date of Join</label>
                    </div>

                </div>
                <div class="my-4">
                    <div class="">
                        <label>Is Present?</label>
                        <select name="is_present" id=""
                            class="form-select @error('is_present') is-invalid @enderror">
                            <option value="">Choose Option</option>
                            <option value="1" {{ old('is_present') == '1' ? 'selected' : '' }}
                                @if ($employee->is_present == 1) selected @endif>Yes</option>
                            <option value="0" {{ old('is_present') == '0' ? 'selected' : '' }}
                                @if ($employee->is_present == 0) selected @endif>No</option>
                        </select>
                    </div>

                </div>
                <div class="my-4">
                    <div class="">
                        <label for="profile_img" class="form-label">Prfile Image</label>
                        <input type="file" class="form-control @error('profileImg') is-invalid @enderror"
                            name="profileImg" id="profile_img">
                        <div class="preview_img my-4" id="preview_img">
                            @if ($employee->image)
                                <img src="{{ $employee->profile_img_path() }}" alt="">
                            @endif
                        </div>
                    </div>

                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="number" class="form-control @error('pin_code') is-invalid @enderror"
                            name="pin_code" value="{{ old('pin_code', $employee->pin_code) }}">
                        <label class="form-label">Pin Code</label>
                    </div>
                </div>

                <div class="my-4">
                    <div class="form-outline">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" value="{{ old('password') }}">
                        <label class="form-label">Password</label>
                    </div>

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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee'), 'edit-form' !!}
    <script>
        $(document).ready(function() {
            $('.birthday').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "maxDate": moment(),
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });
            $('.date_of_join').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });
            $('#profile_img').on('change', function() {
                var file_length = document.getElementById('profile_img').files.length;
                $('#preview_img').html('');
                for (let i = 0; i < file_length; i++) {
                    $('#preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
                }
            });

        })
    </script>
@endsection

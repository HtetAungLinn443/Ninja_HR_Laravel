@extends('layouts.app')

@section('title', 'Create Attendance')
@section('extra_css')
    <style>
        .daterangepicker.single .drp-calendar.left {
            margin-right: 8px !important;
        }

        .invalid-feedback {
            margin-top: 27px !important;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('attendance.store') }}" method="post" id="create-form">
                @csrf

                @include('layouts.error')

                <div class="my-4">
                    <div class="form-group">
                        <label class="form-label">Employee</label>
                        <select name="user_id" class="form-control custom-select  @error('user_id') is-invalid @enderror">
                            <option value="">-- Please Choose --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @if (old('user_id') == $employee->id) selected @endif>
                                    {{ $employee->employee_id }} ({{ $employee->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Date</label>
                        <input type="text" class="form-control date" name="date" value="{{ old('date') }}">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Checkin Time</label>
                        <input type="text" class="form-control timepicker @error('checkin_time') is-invalid @enderror"
                            name="checkin_time" value="{{ old('checkin_time') }}">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Checkout Time</label>
                        <input type="text" class="form-control timepicker @error('checkout_time') is-invalid @enderror"
                            name="checkout_time" value="{{ old('checkout_time') }}">
                    </div>
                </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreAttendance'), 'create-form' !!}

    <script>
        $(document).ready(function() {
            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,

                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });
            $('.timepicker').daterangepicker({
                "timePicker24Hour": true,
                "timePickerSeconds": true,
                "singleDatePicker": true,
                'timePicker': true,

                "autoApply": true,
                "locale": {
                    "format": "HH:mm:ss",
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find('.calendar-table').hide();
            });

        })
    </script>
@endsection

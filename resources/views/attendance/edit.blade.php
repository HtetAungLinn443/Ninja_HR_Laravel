@extends('layouts.app')

@section('title', 'Edit Attendance')
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
            <form action="{{ route('attendance.update', $attendance->id) }}" method="post" id="edit-form">
                @csrf
                @method('PUT')
                @include('layouts.error')
                <div class="my-4">
                    <div class="form-group">
                        <label class="form-label">Employee</label>
                        <select name="user_id" class="form-control custom-select  @error('user_id') is-invalid @enderror">
                            <option value="">-- Please Choose --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @if (old('user_id', $attendance->user_id) == $employee->id) selected @endif>
                                    {{ $employee->employee_id }} ({{ $employee->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Date</label>
                        <input type="text" class="form-control date" name="date"
                            value="{{ old('date', $attendance->date) }}">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Checkin Time</label>
                        <input type="text" class="form-control timepicker @error('checkin_time') is-invalid @enderror"
                            name="checkin_time"
                            value="{{ old('checkin_time', Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s')) }}">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="" class="form-label">Checkout Time</label>
                        <input type="text" class="form-control timepicker @error('checkout_time') is-invalid @enderror"
                            name="checkout_time"
                            value="{{ old('checkout_time', Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s')) }}">
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $attendance->id }}">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateAttendance'), '#edit-form' !!}
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

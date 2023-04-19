@extends('layouts.app')

@section('title', 'Edit Company Setting')
@section('extra_css')
    <style>
        .daterangepicker.single .drp-calendar.left {
            margin-right: 8px !important;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('company-setting.update', 1) }}" method="post" id="edit-form">
                @csrf
                @method('PUT')
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                            name="company_name" value="{{ old('company_name', $setting->company_name) }}">
                        <label for="" class="form-label">Company Name</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('company_email') is-invalid @enderror"
                            name="company_email" value="{{ old('company_email', $setting->company_email) }}">
                        <label for="" class="form-label">Company Email</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('company_phone') is-invalid @enderror"
                            name="company_phone" value="{{ old('company_phone', $setting->company_phone) }}">
                        <label for="" class="form-label">Company Phone</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">

                        <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" cols="30"
                            rows="3">{{ old('company_address', $setting->company_address) }}</textarea>
                        <label for="" class="form-label">Company Address</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text"
                            class="form-control timepicker @error('office_start_time') is-invalid @enderror"
                            name="office_start_time" value="{{ old('office_start_time', $setting->office_start_time) }}">
                        <label for="" class="form-label">Office Start Time</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control timepicker @error('office_end_time') is-invalid @enderror"
                            name="office_end_time" value="{{ old('office_end_time', $setting->office_end_time) }}">
                        <label for="" class="form-label">Office End Time</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text"
                            class="form-control timepicker @error('break_start_time') is-invalid @enderror"
                            name="break_start_time" value="{{ old('break_start_time', $setting->break_start_time) }}">
                        <label for="" class="form-label">Break Start Time</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control timepicker @error('break_end_time') is-invalid @enderror"
                            name="break_end_time" value="{{ old('break_end_time', $setting->break_end_time) }}">
                        <label for="" class="form-label">Break Start Time</label>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting'), '#edit-form' !!}
    <script>
        $(document).ready(function() {
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
                $('.calendar-table').hide();
            });
        })
    </script>
@endsection

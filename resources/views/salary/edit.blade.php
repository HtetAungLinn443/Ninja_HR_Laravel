@extends('layouts.app')

@section('title', 'Edit Salary')

@section('extra_css')
    <style>
        .invalid-feedback {
            padding-top: 40px
        }

        #amount-error {
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('salary.update', $salary->id) }}" method="post" id="edit-form">
                @csrf
                @method('PUT')
                <div class="form-group mb-4">
                    <label class="form-label">Employee</label>
                    <select name="user_id" class="form-select select-box @error('user_id') is-invalid @enderror">
                        <option value="">-- Please Choose --</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @if ($salary->user_id == $employee->id) selected @endif>
                                {{ $employee->employee_id }} ({{ $employee->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="">Month</label>
                    <select name="month" class="form-select select-box select-month">
                        <option value="">-- Please Choose (Month) --</option>
                        <option value="01" @if ($salary->month == '01') selected @endif>Jan</option>
                        <option value="02" @if ($salary->month == '02') selected @endif>Feb</option>
                        <option value="03" @if ($salary->month == '03') selected @endif>Mar</option>
                        <option value="04" @if ($salary->month == '04') selected @endif>Apr</option>
                        <option value="05" @if ($salary->month == '05') selected @endif>May</option>
                        <option value="06" @if ($salary->month == '06') selected @endif>Jun</option>
                        <option value="07" @if ($salary->month == '07') selected @endif>Jul</option>
                        <option value="08" @if ($salary->month == '08') selected @endif>Aug</option>
                        <option value="09" @if ($salary->month == '09') selected @endif>Sep</option>
                        <option value="10" @if ($salary->month == '10') selected @endif>Oct</option>
                        <option value="11" @if ($salary->month == '11') selected @endif>Nov</option>
                        <option value="12" @if ($salary->month == '12') selected @endif>Dec</option>
                    </select>

                </div>
                <div class="form-group mb-4">
                    <label for="">Years</label>
                    <select name="year" class="form-select select-box select-year">
                        <option value="">-- Please Choose (Year) --</option>
                        @for ($i = 0; $i < 15; $i++)
                            <option value="{{ now()->addYears(5)->subYears($i)->format('Y') }}"
                                @if (
                                    $salary->year ==
                                        now()->addYears(5)->subYears($i)->format('Y')) selected @endif>
                                {{ now()->addYears(5)->subYears($i)->format('Y') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group md-3">
                    <label for="" class="form-label">Amount (MMK)</label>
                    <input type="number" value="{{ $salary->amount }}" class="form-control" name="amount"
                        placeholder="Ender Amount">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateSalary'), 'edit-form' !!}
    <script>
        $(document).ready(function() {
            $('.select-box').select2({
                theme: "classic",
                placeholder: "-- Please Choose --",
                allowClear: true
            });

        })
    </script>
@endsection

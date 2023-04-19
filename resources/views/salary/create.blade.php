@extends('layouts.app')

@section('title', 'Create Salary')
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
            <form action="{{ route('salary.store') }}" method="post" id="create">
                @csrf


                <div class="form-group mb-4">
                    <label class="form-label">Employee</label>
                    <select name="user_id" class="form-select select-box ">
                        <option value="">-- Please Choose --</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @if (old('user_id') == $employee->id) selected @endif>
                                {{ $employee->employee_id }} ({{ $employee->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="">Month</label>
                    <select name="month" class="form-select select-box select-month">
                        <option value="">-- Please Choose (Month) --</option>
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>

                </div>
                <div class="form-group mb-4">
                    <label for="">Years</label>
                    <select name="year" class="form-select  select-year select-box">
                        <option value="">-- Please Choose (Year) --</option>
                        @for ($i = 0; $i < 15; $i++)
                            <option value="{{ now()->addYears(5)->subYears($i)->format('Y') }}">
                                {{ now()->addYears(5)->subYears($i)->format('Y') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group md-3">
                    <label for="" class="form-label">Amount (MMK)</label>
                    <input type="number" class="form-control" name="amount" placeholder="Ender Amount">
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreSalary'), 'create-form' !!}

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

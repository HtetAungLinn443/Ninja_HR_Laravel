@extends('layouts.app')

@section('title', 'Create Departmant')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('department.store') }}" method="post" id="create">
                @csrf
                <div class="my-4">
                    <div class="form-outline ">
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title') }}">
                        <label for="" class="form-label">Title</label>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreDepartment'), 'create-form' !!}

    <script>
        $(document).ready(function() {


        })
    </script>
@endsection

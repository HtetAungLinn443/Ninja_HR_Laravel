@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('department.update', $department->id) }}" method="post" id="edit-form">
                @csrf
                @method('PUT')
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title', $department->title) }}">
                        <label for="" class="form-label">Title</label>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $department->id }}">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateDepartment'), 'edit-form' !!}
    <script>
        $(document).ready(function() {


        })
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('permission.update', $permission->id) }}" method="post" id="edit-form">
                @csrf
                @method('PUT')
                <div class="my-4">
                    <div class="form-outline">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $permission->name) }}">
                        <label for="" class="form-label">Name</label>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $permission->id }}">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePermission'), '#edit-form' !!}
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection

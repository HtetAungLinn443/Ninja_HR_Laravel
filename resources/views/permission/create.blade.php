@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('permission.store') }}" method="post" id="create">
                @csrf
                <div class="my-4">
                    <div class="form-outline ">
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" autofocus>
                        <label for="" class="form-label">Name</label>
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
    {!! JsValidator::formRequest('App\Http\Requests\StorePermission'), '#create-form' !!}

    <script>
        $(document).ready(function() {


        })
    </script>
@endsection

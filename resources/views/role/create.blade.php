@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('role.store') }}" method="post" id="create">
                @csrf
                <div class="my-4">
                    <div class="form-outline ">
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" autofocus>
                        <label for="" class="form-label">Name</label>
                    </div>
                </div>
                <label for="">Permission</label>
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permission[]"
                                    value="{{ $permission->name }}" id="permission_{{ $permission->id }}" />
                                <label class="form-check-label"
                                    for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endforeach
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreRole'), 'create-form' !!}

    <script>
        $(document).ready(function() {


        })
    </script>
@endsection

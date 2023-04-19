@extends('layouts.app')

@section('title', 'Create Project')

@section('extra_css')
    <style>
        .daterangepicker.single .drp-calendar.left {
            margin-right: 8px !important;
        }

        .invalid-message .invalid-feedback {
            margin-top: 37px !important;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body ">
            <form action="{{ route('project.store') }}" method="post" id="create" enctype="multipart/form-data">
                @csrf
                <div class="my-4">
                    <div class="form-outline ">
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title') }}">
                        <label for="" class="form-label">Title</label>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-outline ">
                        <textarea name="description" class="form-control " rows="5">{{ old('description') }}</textarea>
                        <label for="" class="form-label">Description</label>
                    </div>
                </div>
                <div class="my-4">
                    <label for="images" class="form-label">Images (Only PNG, JPG, JPEG)</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" name="images[]"
                        id="images" multiple accept="image/.png, .jpg, .jpeg">

                    <div class="preview_img my-4" id="preview_img"></div>
                </div>
                <div class="my-4">
                    <label for="files" class="form-label">Files (Only PDF)</label>
                    <input type="file" class="form-control @error('files') is-invalid @enderror" name="files[]"
                        id="files" multiple accept="application/pdf">

                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="text" class="form-control datePicker @error('startDate') is-invalid @enderror"
                            name="startDate" value="{{ old('startDate') }}" id="startDate">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="text" class="form-control datePicker @error('deadline') is-invalid @enderror"
                            name="deadline" value="{{ old('deadline') }}" id="deadline">
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group invalid-message">
                        <label for="leader" class="form-label">Leaders</label>
                        <select name="leaders[]" id="leader" class="form-control custom-select" multiple>
                            <option value="">-- Please Choose --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group invalid-message">
                        <label for="member" class="form-label">Members</label>
                        <select name="members[]" id="member" class="form-control custom-select" multiple>
                            <option value="">-- Please Choose --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group invalid-message">
                        <label for="priority">Priority</label>
                        <select name="priority" class="form-control custom-select" id="priority">
                            <option value="">-- Please Choose --</option>
                            <option value="height" @if (old('priority') == 'height') selected @endif>Height</option>
                            <option value="middle" @if (old('priority') == 'middle') selected @endif>Middle</option>
                            <option value="low" @if (old('priority') == 'low') selected @endif>Low</option>
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <div class="form-group invalid-message">
                        <label for="">Status</label>
                        <select name="status" class="form-control custom-select" id="">
                            <option value="">-- Please Choose --</option>
                            <option value="pending" @if (old('status') == 'pending') selected @endif>Pending</option>
                            <option value="in_progress" @if (old('status') == 'in_progress') selected @endif>In Progress
                            </option>
                            <option value="complete" @if (old('status') == 'complete') selected @endif>Complete</option>
                        </select>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreProject'), 'create-form' !!}

    <script>
        $(document).ready(function() {
            $('#images').on('change', function() {
                var file_length = document.getElementById('images').files.length;
                $('#preview_img').html('');
                for (let i = 0; i < file_length; i++) {
                    $('#preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
                }
            });
            $('.datePicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

        })
    </script>
@endsection

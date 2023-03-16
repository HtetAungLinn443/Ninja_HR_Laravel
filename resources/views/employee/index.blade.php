@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="mb-3">
        <a href="{{ route('employee.create') }}" class="btn btn-primary">Create Employee</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class=" table-bordered table " id="user-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Employee ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Is Present?</th>
                        <th class="hidden">Updated at</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '/employee/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'id',
                        name: 'id',
                        class: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: "text-center"
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        class: "text-center"

                    },
                    {
                        data: 'email',
                        name: 'email',
                        class: "text-center"
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        class: "text-center"
                    },
                    {
                        data: 'is_present',
                        name: 'is_present',
                        class: "text-center"
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: "text-center"
                    },

                ],
                order: [
                    [6, 'desc']
                ],
                columnDefs: [{
                        targets: [0],
                        'class': "control",
                    },
                    {
                        targets: 'no-sort',
                        orderable: false,
                    },
                    {
                        targets: 'no-search',
                        searchable: false,
                    },
                    {
                        targets: 'hidden',
                        visible: false,
                    },
                ],
            })
            @if (session('createSuccess'))
                Swal.fire({
                    title: 'Success',
                    text: "{{ session('createSuccess') }}",
                    icon: 'success',
                    confirmButtonText: 'Confirm'
                })
            @endif
        })
    </script>
@endsection

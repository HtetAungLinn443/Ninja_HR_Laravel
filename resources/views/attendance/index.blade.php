@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    @can('create_attendance')
        <div class="mb-3">
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">Create Attendance</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <table class=" table-bordered table " id="user-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Check In Time</th>
                        <th class="text-center">Check Out Time</th>
                        <th class="text-center no-sort">Action</th>
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

                ajax: '/attendance/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'employee_name',
                        name: 'employee_name',
                        class: "text-center"
                    }, {
                        data: 'date',
                        name: 'date',
                        class: "text-center"
                    }, {
                        data: 'checkin_time',
                        name: 'checkin_time',
                        class: "text-center"
                    }, {
                        data: 'checkout_time',
                        name: 'checkout_time',
                        class: "text-center"
                    }, {
                        data: 'action',
                        name: 'action',
                        class: "text-center action-btn"
                    }, {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: "text-center"
                    },

                ],
                order: [
                    [2, 'desc']
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
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                swal({
                        text: "Are you sure went to Delete?",
                        buttons: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                method: "DELETE",
                                url: `/attendance/${id}`,
                            }).done(function(res) {

                                $('#user-table').DataTable().ajax.reload();
                            })
                        }
                    });
            })
        })
    </script>
@endsection

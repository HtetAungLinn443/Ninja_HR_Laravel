@extends('layouts.app')

@section('title', 'Role')

@section('content')
    @can('create_role')
        <div class="mb-3">
            <a href="{{ route('role.create') }}" class="btn btn-primary">Create Role</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <table class="table-bordered table" id="role-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Permission</th>
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

            $('#role-table').DataTable({

                ajax: '/role/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'name',
                        name: 'name',
                        class: "text-center"
                    }, {
                        data: 'permissions',
                        name: 'permissions',
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
                    [4, 'desc']
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
                                url: `/role/${id}`,
                            }).done(function(res) {

                                $('#role-table').DataTable().ajax.reload();
                            })
                        }
                    });
            })
        })
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Permission')

@section('content')
    @can('create_permission')
        <div class="mb-3">
            <a href="{{ route('permission.create') }}" class="btn btn-primary">Create Permission</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <table class="table-bordered table" id="permission-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Name</th>
                        <th class="">Created at</th>
                        <th class="">Updated at</th>
                        <th class="text-center no-sort">Action</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#permission-table').DataTable({

                ajax: '/permission/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'name',
                        name: 'name',
                        class: "text-center"
                    }, {
                        data: 'created_at',
                        name: 'created_at',
                        class: "text-center"
                    }, {
                        data: 'updated_at',
                        name: 'updated_at',
                        class: "text-center"
                    }, {
                        data: 'action',
                        name: 'action',
                        class: "text-center action-btn"
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
                                url: `/permission/${id}`,
                            }).done(function(res) {

                                $('#permission-table').DataTable().ajax.reload();
                            })
                        }
                    });
            })
        })
    </script>
@endsection

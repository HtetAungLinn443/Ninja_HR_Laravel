@extends('layouts.app')

@section('title', 'My Project')

@section('content')

    <div class="card">
        <div class="card-body">
            <table class=" table-bordered table " id="user-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Description</th>
                        <th class="text-center no-sort no-search">Leaders</th>
                        <th class="text-center no-sort no-search">Members</th>
                        <th class="text-center">Start Date</th>
                        <th class="text-center">Deadline</th>
                        <th class="text-center">Priority</th>
                        <th class="text-center">Status</th>
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

                ajax: '/my-project/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'title',
                        name: 'title',
                        class: "text-center"
                    }, {
                        data: 'description',
                        name: 'description',
                        class: "text-start"
                    }, {
                        data: 'leaders',
                        name: 'leaders',
                        class: "text-center"
                    }, {
                        data: 'members',
                        name: 'members',
                        class: "text-center"
                    }, {
                        data: 'start_of_date',
                        name: 'start_of_date',
                        class: "text-center"
                    }, {
                        data: 'deatline',
                        name: 'deatline',
                        class: "text-center"
                    }, {
                        data: 'priority',
                        name: 'priority',
                        class: "text-center"
                    }, {
                        data: 'status',
                        name: 'status',
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
                    [10, 'desc']
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
                                url: `/project/${id}`,
                            }).done(function(res) {

                                $('#user-table').DataTable().ajax.reload();
                            })
                        }
                    });
            })
        })
    </script>
@endsection

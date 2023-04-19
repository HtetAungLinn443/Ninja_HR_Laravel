@extends('layouts.app')

@section('title', 'Salary')

@section('content')
    @can('create_salary')
        <div class="mb-3">
            <a href="{{ route('salary.create') }}" class="btn btn-primary">Create Salary</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body">
            <table class=" table-bordered table " id="salary-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Amount (MMK)</th>
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

            $('#salary-table').DataTable({

                ajax: '/salary/datatable/ssd',
                columns: [{
                        data: 'plus-icon',
                        name: 'plus-icon',
                        class: 'text-center'
                    }, {
                        data: 'employee_name',
                        name: 'employee_name',
                        class: "text-center"
                    }, {
                        data: 'month',
                        name: 'month',
                        class: "text-center"
                    }, {
                        data: 'year',
                        name: 'year',
                        class: "text-center"
                    }, {
                        data: 'amount',
                        name: 'amount',
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
                                url: `/salary/${id}`,
                            }).done(function(res) {

                                $('#salary-table').DataTable().ajax.reload();
                            })
                        }
                    });
            })
        })
    </script>
@endsection

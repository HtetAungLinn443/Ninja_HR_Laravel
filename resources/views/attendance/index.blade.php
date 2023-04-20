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
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        text: '<i class="fa-solid fa-file-pdf me-1"></i> PDF',

                        orientation: 'portrait',
                        pageSize: 'A4',
                        title: 'Attendance',
                        className: 'btn btn-sm btn-dark',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        customize: function(doc) {

                            doc.content.splice(0, 1);
                            var now = new Date();

                            var datetime = now.getDay() + "/" + now
                                .getMonth() +
                                "/" + now.getFullYear() + " @ " +
                                now.getHours() + ":" +
                                now.getMinutes() + ":" + now.getSeconds();

                            doc.pageMargins = [20, 40, 20, 30];
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.tableBodyEven.alignment = 'center';
                            doc.styles.tableBodyOdd.alignment = 'center';

                            doc['header'] = (function() {
                                return {
                                    columns: [

                                        {
                                            alignment: 'left',
                                            text: 'Attendance',
                                            fontSize: 14,
                                            margin: [10, 0]
                                        },
                                        {
                                            alignment: 'right',
                                            fontSize: 8,
                                            text: 'Report Time:' + datetime,
                                        }
                                    ],
                                    margin: [20, 20, 20, 0]
                                }
                            });

                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            text: ''
                                        },
                                        {
                                            alignment: 'right',
                                            text: ['page ', {
                                                text: page.toString()
                                            }, ' of ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [20, 0, 20, 10]
                                }
                            });

                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            doc.content[0].layout = objLayout;
                            doc.content[0].table.widths = ['25%', '15%', '30%', '30%'];
                        }
                    }, {
                        text: '<i class="fa-solid  fa-sync"></i> Refresh',
                        className: 'btn btn-primary btn-sm',
                        action: function(e, dt, node, config) {
                            dt.ajax.reload(null, false);
                        }
                    }, {
                        extend: 'pageLength',
                        className: 'btn btn-info btn-sm',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    ['10 rows', '25 rows', '50 rows', '100 rows', '500 rows', ]
                ],
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

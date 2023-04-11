@extends('layouts.app')

@section('title', 'Home Page')
@section('extra_css')
    <style>
        #video {
            width: 100%;
            height: 300px;

        }
    </style>
@endsection
@section('content')
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('image/scan.svg') }}" alt="" style="width:250px;">
            <p class="text-muted">Please Scan Attendance QR</p>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#scanModal">
                Scan
            </button>


        </div>
    </div>
    <!-- Scan Modal -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scan Attendance QR</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video id="video"></video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-mdb-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">

        <div class="card-body">
            <h5 class="mb-2 text-center">Attendance History</h5>
            {{-- Attendance Overview --}}
            <div class="row mb-3">

                <div class="col-md-4">
                    <div class="form-group">
                        <select name="" class="form-select mb-3 select-month">
                            <option value="">-- Please Choose (Month) --</option>
                            <option value="01" @if (now()->format('m') == '01') selected @endif>Jan</option>
                            <option value="02" @if (now()->format('m') == '02') selected @endif>Feb</option>
                            <option value="03" @if (now()->format('m') == '03') selected @endif>Mar</option>
                            <option value="04" @if (now()->format('m') == '04') selected @endif>Apr</option>
                            <option value="05" @if (now()->format('m') == '05') selected @endif>May</option>
                            <option value="06" @if (now()->format('m') == '06') selected @endif>Jun</option>
                            <option value="07" @if (now()->format('m') == '07') selected @endif>Jul</option>
                            <option value="08" @if (now()->format('m') == '08') selected @endif>Aug</option>
                            <option value="09" @if (now()->format('m') == '09') selected @endif>Sep</option>
                            <option value="10" @if (now()->format('m') == '10') selected @endif>Oct</option>
                            <option value="11" @if (now()->format('m') == '11') selected @endif>Nov</option>
                            <option value="12" @if (now()->format('m') == '12') selected @endif>Dec</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select name="" class="form-select mb-3 select-year">
                            <option value="">-- Please Choose (Year) --</option>
                            @for ($i = 0; $i < 5; $i++)
                                <option value="{{ now()->subYears($i)->format('Y') }}"
                                    @if (now()->format('Y') ==
                                            now()->subYears($i)->format('Y')) selected @endif>
                                    {{ now()->subYears($i)->format('Y') }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block mb-3 search-btn"><i class="fa fa-search me-2"></i>
                            Search</button>
                    </div>
                </div>
            </div>
            <div class="attendance_overview_table mb-4"></div>
            {{-- Attendance History DataTable --}}
            <table class=" table-bordered table " id="user-table" style="width: 100%;">
                <thead>
                    <tr class="">
                        <th class="text-center no-sort no-search"></th>
                        <th class="text-center">Employee Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Check In Time</th>
                        <th class="text-center">Check Out Time</th>

                        <th class="hidden">Updated at</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            const videoElem = document.getElementById('video');
            const qrScanner = new QrScanner(
                videoElem,
                function(result) {

                    if (result) {
                        $('#scanModal').modal('hide');
                        qrScanner.stop();
                    }

                    $.ajax({
                        url: '/attendance-scan/store',
                        type: 'GET',
                        data: {
                            "hash_value": result,
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message,
                                });
                            } else if (res.status == 'fail') {
                                Toast.fire({
                                    icon: 'warning',
                                    title: res.message,
                                });
                            }


                        }
                    });
                }

            );

            $('#scanModal').on('show.bs.modal', function(event) {
                qrScanner.start();

            })

            $('#scanModal').on('hidden.bs.modal', function(event) {
                qrScanner.stop();
            })
            // Attendance History Datatable js
            var dataTable = $('#user-table').DataTable({

                ajax: '/my-attendance/datatable/ssd',
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

            // Attendance Overview

            attendanceOverviewTable();

            function attendanceOverviewTable() {
                var month = $('.select-month').val();
                var year = $('.select-year').val();
                $.ajax({
                    url: `/my-attendance-overview-table?month=${month}&year=${year}`,
                    type: 'GET',
                    success: function(res) {
                        $('.attendance_overview_table').html(res);
                    }
                })

                dataTable.ajax.url(`/my-attendance/datatable/ssd?month=${month}&year=${year}`).load();
            }

            $('.search-btn').on('click', function(event) {
                event.preventDefault();

                attendanceOverviewTable();
            })



        })
    </script>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('image/logo.jpg') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />

    {{-- Data Table --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    {{-- Daterange Picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra_css')



    {{-- @vite(['resources/js/app.js', 'resources/js/vendor/webauthn/webauthn.js']) --}}


</head>

<body style="background:#edf2f6;">

    <div class="page-wrapper chiller-theme">

        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="#">Ninja hr</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded" src="{{ Auth::user()->profile_img_path() }}"
                            alt="">
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span
                            class="user-role">{{ Auth::user()->department ? Auth::user()->department->title : '-' }}</span>
                        <span class="user-status">
                            <i class="fa fa-circle"></i>
                            <span>Online</span>
                        </span>
                    </div>
                </div>
                <!-- sidebar-header  -->

                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menu</span>
                        </li>

                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        @can('view_company_setting')
                            <li>
                                <a href="{{ route('company-setting.show', 1) }}">
                                    <i class="fa-regular fa-building"></i>
                                    <span>Company Setting</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_employee')
                            <li>
                                <a href="{{ route('employee.index') }}">
                                    <i class="fa fa-users"></i>
                                    <span>Employees</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_department')
                            <li>
                                <a href="{{ route('department.index') }}">
                                    <i class="fa fa-sitemap"></i>
                                    <span>Department</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_role')
                            <li>
                                <a href="{{ route('role.index') }}">
                                    <i class="fa fa-user-shield"></i>
                                    <span>Role</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_permission')
                            <li>
                                <a href="{{ route('permission.index') }}">
                                    <i class="fa fa-shield"></i>
                                    <span>Permission</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_attendance')
                            <li>
                                <a href="{{ route('attendance.index') }}">
                                    <i class="fa fa-calendar-check"></i>
                                    <span>Attendance (Employee)</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_attendance_overview')
                            <li>
                                <a href="{{ route('attendance.overview') }}">
                                    <i class="fa fa-calendar-check"></i>
                                    <span>Attendance (Overview)</span>
                                </a>
                            </li>
                        @endcan
                        {{-- <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                                <span class="badge badge-pill badge-warning">New</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Dashboard 1
                                            <span class="badge badge-pill badge-success">Pro</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="#">Dashboard 3</a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                        {{-- <li class="header-menu">
                            <span>Extra</span>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Documentation</span>
                                <span class="badge badge-pill badge-primary">Beta</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-calendar"></i>
                                <span>Calendar</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-folder"></i>
                                <span>Examples</span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->

        </nav>
        <div id="app" class="">
            <div class="top-menu">
                <div class="d-flex justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            @if (request()->is('dashboard'))
                                <a id="show-sidebar" href="#">
                                    <i class="fas fa-bars"></i>
                                </a>
                            @else
                                <a id="back-btn" class="text-dark" href="#">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            <h5>@yield('title')</h5>
                            <div class=""></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-4 content">
                <div class="d-flex justify-content-center">
                    <div class="col-11 col-md-10">
                        @yield('content')
                    </div>
                </div>
            </div>
            <div class="bottom-menu">
                <div class="d-flex justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-home"></i>
                                <p class="m-0">Home</p>
                            </a>
                            <a href="{{ route('attendanceScan@admin') }}">
                                <i class="fa fa-user-clock"></i>
                                <p class="m-0">Attendance</p>
                            </a>
                            <a href="{{ route('checkin-checkout@user') }}">
                                <i class="fa-solid fa-qrcode"></i>
                                <p class="m-0">Home</p>
                            </a>
                            <a href="{{ route('profile#Page') }}">
                                <i class="fa fa-user"></i>
                                <p class="m-0">Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

{{-- Data Table Script --}}
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>

{{-- Datatable mark js --}}
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

{{-- Bootstrap --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>

{{-- Date Range Picker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

{{-- sweet alert 2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweet alert 1 --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- JS Validation --}}
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>\

{{-- lordicon --}}
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

{{-- main js --}}
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token.content,
                }
            })
        } else {
            console.error('CSRF Token not found.');
        }
        $(".sidebar-dropdown > a").click(function() {
            $(".sidebar-submenu").slideUp(200);
            if (
                $(this).parent().hasClass("active")
            ) {
                $(".sidebar-dropdown").removeClass("active");
                $(this).parent().removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this).next(".sidebar-submenu").slideDown(200);
                $(this).parent().addClass("active");
            }
        });

        $("#close-sidebar").click(function(e) {
            e.preventDefault();
            $(".page-wrapper").removeClass("toggled");
        });
        $('#back-btn').on('click', function(e) {
            e.preventDefault();
            window.history.go(-1);
            return false;
        })

        @if (request()->is('/dashboard'))
            document.addEventListener('click', (event) => {
                if (document.getElementById('show-sidebar').contains(event.target)) {
                    $(".page-wrapper").addClass("toggled");
                } else if (!document.getElementById('sidebar').contains(event.target)) {
                    $(".page-wrapper").removeClass("toggled");
                }
            });
        @endif

        $("#show-sidebar").click(function(e) {
            e.preventDefault();
            $(".page-wrapper").addClass("toggled");
        });
        $.extend(true, $.fn.dataTable.defaults, {
            processing: true,
            serverSide: true,
            responsive: true,
            mark: true,

            columnDefs: [{
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
            language: {
                "paginate": {
                    'previous': '<i class="fa-regular fa-circle-left"></i>',
                    'next': '<i class="fa-regular fa-circle-right"></i>',
                },
                "processing": `<img src="{{ asset('image/loading.gif') }}" style="width:70px">`

            },
        });
        $('.custom-select').select2({

            theme: "classic",
            placeholder: "-- Please Choose --",
            allowClear: true
        });

    });
</script>
@yield('script')

</html>

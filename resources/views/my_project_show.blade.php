@extends('layouts.app')

@section('title', 'My Project Details')

@section('extra_css')
    <style>
        .task-item {
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
            background: #fff;
            margin-bottom: 5px;

        }

        .add_task_btn {
            border: 1px solid #d0d0d0 !important;
            background: #fff;
            padding: 12px;
            display: block;
            border-radius: 5px;
            width: 100%;
            font-weight: 500;
            transition: .3s;
            box-shadow: 0 2px 15px -3px #00000012, 0 10px 20px -2px #0000000a;
            text-align: center;
        }

        .add_task_btn i {
            margin-right: 5px;
        }

        .add_task_btn:hover {
            background: #ececec;
        }

        .add_task_btn:active {
            background: #ffffff;
        }

        .swal2-title {
            font-size: 23px !important;
        }

        .form-outline .form-control {
            border: 1px !important;
            z-index: 9000;
        }

        .daterangepicker.single .drp-calendar.left {
            margin-right: 8px !important;
        }

        .invalid-message .invalid-feedback {
            margin-top: 37px !important;
        }

        .select2-container {
            z-index: 9000 !important;
        }

        .select2-container--classic .select2-selection--multiple {
            height: 36px;
            line-height: 23px;
        }

        .dropdown-toggle:after {
            display: none !important;
        }

        .task-action a {
            width: 28px;
            height: 28px;
            background: #eee;
            display: inline-block;
            border-radius: 5px;
            text-align: center;
            font-size: 13px;
            line-height: 29px;
        }

        .sortable-ghost {
            background: #eee;
            border: 2px dashed #5e5e5e;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-3">
                <div class="card-body">
                    <h4>{{ $project->title }}</h4>
                    <p class="mb-1 ">Start Date : <span class="text-muted">{{ $project->start_of_date }}</span> , Deadline :
                        <span class="text-muted">{{ $project->deatline }}</span>
                    </p>
                    <p class="mb-4 ">Priority :
                        @if ($project->priority == 'height')
                            <span class="badge badge-pill badge-danger">Height</span>
                        @elseif($project->priority == 'middle')
                            <span class="badge badge-pill badge-info">Middle</span>
                        @elseif($project->priority == 'low')
                            <span class="badge badge-pill badge-dark">Low</span>
                        @endif
                        , Status :
                        @if ($project->status == 'pending')
                            <span class="badge badge-pill badge-warning">Pending</span>
                        @elseif ($project->status == 'in_progress')
                            <span class="badge badge-pill badge-info">In Progress</span>
                        @elseif ($project->status == 'complete')
                            <span class="badge badge-pill badge-success">Complete</span>
                        @endif
                    </p>
                    <h5 class="">Description</h5>
                    <p class="mb-2">{{ $project->description }}</p>

                    <div class="mb-3">
                        <h5><i class="fa-solid fa-user-tie"></i> Leaders</h5>
                        @foreach ($project->leaders ?? [] as $leader)
                            <img src="{{ $leader->profile_img_path() }}" alt="" class="profile-thumbnail2">
                        @endforeach
                    </div>
                    <div class="">
                        <h5><i class="fa-solid fa-users"></i> Members</h5>
                        @foreach ($project->members ?? [] as $member)
                            <img src="{{ $member->profile_img_path() }}" alt="" class="profile-thumbnail2">
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Images</h5>
                    <div class="" id="images">
                        @if ($project->image)
                            @foreach ($project->image as $image)
                                <img src="{{ asset('storage/project/image/' . $image) }}" class="image-thumbnail "
                                    style="cursor: pointer;">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Files</h5>
                    <div class="">
                        @if ($project->files)
                            @foreach ($project->files as $file)
                                <a href="{{ asset('storage/project/pdf/' . $file) }}" target="_blank" class="pdf-thumbnail">
                                    <i class="fa fa-file-pdf"></i>
                                    <p class="mb-1">File {{ $loop->iteration }}</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Task</h5>
                    <div class="task-data">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            var project_id = {{ $project->id }};

            function initSortable() {
                var pendingTaskBoard = document.getElementById('pendingTaskBoard');
                var inProgressTaskBoard = document.getElementById('inProgressTaskBoard');
                var completeTaskBoard = document.getElementById('completeTaskBoard');

                Sortable.create(pendingTaskBoard, {
                    group: "taskBoard",
                    animation: 200,
                    ghostClass: "sortable-ghost",
                    draggable: ".task-item",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('pendingTaskBoard', order.join(','));
                        }
                    },
                    onSort: function(evnt) {
                        setTimeout(() => {
                            var pendingTaskBoard = localStorage.getItem('pendingTaskBoard');

                            $.ajax({
                                url: `/task-draggable?projectId=${project_id}&pendingTaskBoard=${pendingTaskBoard}`,
                                type: 'GET',
                                success: function(respond) {

                                }
                            })
                        }, 1000);
                    },
                });

                Sortable.create(inProgressTaskBoard, {
                    group: "taskBoard",
                    animation: 200,
                    ghostClass: "sortable-ghost",
                    draggable: ".task-item",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('inProgressTaskBoard', order.join(','));
                        }
                    },
                    onSort: function(evnt) {
                        setTimeout(() => {
                            var inProgressTaskBoard = localStorage.getItem(
                                'inProgressTaskBoard');

                            $.ajax({
                                url: `/task-draggable?projectId=${project_id}&inProgressTaskBoard=${inProgressTaskBoard}`,
                                type: 'GET',
                                success: function(respond) {

                                }
                            })
                        }, 1000);
                    },
                });

                Sortable.create(completeTaskBoard, {
                    group: "taskBoard",
                    animation: 200,
                    ghostClass: "sortable-ghost",
                    draggable: ".task-item",
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('completeTaskBoard', order.join(','));
                        }
                    },
                    onSort: function(evnt) {
                        setTimeout(() => {
                            var completeTaskBoard = localStorage.getItem('completeTaskBoard');

                            $.ajax({
                                url: `/task-draggable?projectId=${project_id}&completeTaskBoard=${completeTaskBoard}`,
                                type: 'GET',
                                success: function(respond) {

                                }
                            })
                        }, 1000);
                    },
                });
            }

            function taskData() {
                $.ajax({
                    url: `/task-data?project_id=${project_id}`,
                    type: 'GET',
                    success: function(res) {
                        $('.task-data').html(res);
                        initSortable();
                    },
                })
            };
            taskData();
            new Viewer(document.getElementById('images'));
        });
    </script>
@endsection

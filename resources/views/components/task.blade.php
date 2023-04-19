<div class="row mb-3">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-warning text-white fs-5 "><i class="fa-solid fa-list-check"></i>
                Pending</div>
            <div class="card-body alert-warning">
                <div id="pendingTaskBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'pending') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>{{ $task->title }}</h6>

                                <div class="task-action">
                                    <a href="#" class="edit_task_btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                        <i class="far fa-edit text-warning"></i>
                                    </a>
                                    <a href="#" class="delete_task_btn" data-id="{{ $task->id }}"><i
                                            class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="">
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-danger badge-pill">High</span>
                                    @elseif ($task->priority == 'middle')
                                        <span class="badge badge-info badge-pill">Middle</span>
                                    @elseif ($task->priority == 'low')
                                        <span class="badge badge-dark badge-pill">Low</span>
                                    @endif
                                </div>
                                <div class="">
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3"
                                            alt="">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <button class="add_task_btn add_panding_task"><i class="fa-solid fa-circle-plus"></i>
                        Add Task
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-info text-white fs-5 ">
                <i class="fa-solid fa-list-check"></i> In Progress
            </div>
            <div class="card-body alert-info">
                <div id="inProgressTaskBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'in_progress') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>{{ $task->title }}</h6>
                                <div class="task-action">
                                    <a href="#" class="edit_task_btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                        <i class="far fa-edit text-warning"></i>
                                    </a>
                                    <a href="#" class="delete-btn"><i
                                            class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="">
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-danger badge-pill">High</span>
                                    @elseif ($task->priority == 'middle')
                                        <span class="badge badge-info badge-pill">Middle</span>
                                    @elseif ($task->priority == 'low')
                                        <span class="badge badge-dark badge-pill">Low</span>
                                    @endif
                                </div>
                                <div class="">
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3"
                                            alt="">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="#" class="add_task_btn add_in_progress_task"><i class="fa-solid fa-circle-plus"></i>
                        Add Task
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white fs-5 "><i class="fa-solid fa-list-check"></i>
                Success</div>
            <div class="card-body alert-success">
                <div id="completeTaskBoard">
                    @foreach (collect($project->tasks)->sortBy('serial_number')->where('status', 'complete') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>{{ $task->title }}</h6>
                                <div class="task-action">
                                    <a href="#" class="edit_task_btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"
                                        data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id')->toArray())) }}">
                                        <i class="far fa-edit text-warning"></i>
                                    </a>
                                    <a href="#" class="delete-btn"><i
                                            class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="">
                                    <p class="mb-0"><i class="fas fa-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <span class="badge badge-danger badge-pill">High</span>
                                    @elseif ($task->priority == 'middle')
                                        <span class="badge badge-info badge-pill">Middle</span>
                                    @elseif ($task->priority == 'low')
                                        <span class="badge badge-dark badge-pill">Low</span>
                                    @endif
                                </div>
                                <div class="">
                                    @foreach ($task->members as $member)
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3"
                                            alt="">
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <a href="#" class=" add_task_btn add_complete_task"><i class="fa-solid fa-circle-plus"></i>
                        Add Task
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        var leaders = @json($project->leaders);
        var members = @json($project->members);
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
            });

            Sortable.create(inProgressTaskBoard, {
                group: "taskBoard",
                animation: 200,
                ghostClass: "sortable-ghost",
                draggable: ".task-item",
            });

            Sortable.create(completeTaskBoard, {
                group: "taskBoard",
                animation: 200,
                ghostClass: "sortable-ghost",
                draggable: ".task-item",
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


        // For Pending
        $('.add_panding_task').click(function(event) {
            event.preventDefault();
            var task_members_option = '';
            leaders.forEach(function(leader) {
                task_members_option += `<option value="${leader.id}">${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_option += `<option value="${member.id}">${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Panding Task',

                html: `
                    <form id="pending_task_form">
                        <input type="hidden" name="status" value="pending">
                        <input type="hidden" name="project_id" value="${project_id}">
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control " name="title"
                                    value="{{ old('title') }}" placeholder="Ender Task Title">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control " rows="5" placeholder="Ender Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control datePicker @error('startDate') is-invalid @enderror"
                                    name="startDate" value="{{ old('startDate') }}" id="startDate">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="text" class="form-control datePicker @error('deadline') is-invalid @enderror"
                                    name="deadline" value="{{ old('deadline') }}" id="deadline">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="member" class="form-label">Members</label>
                                <select name="members[]" id="member" class="form-control custom-select" multiple>
                                    <option value="">-- Please Choose --</option>
                                    ${task_members_option}
                                </select>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="priority">Priority</label>
                                <select name="priority" class="form-control custom-select" id="priority">
                                    <option value="">-- Please Choose --</option>
                                    <option value="high" @if (old('priority') == 'high') selected @endif>High</option>
                                    <option value="middle" @if (old('priority') == 'middle') selected @endif>Middle</option>
                                    <option value="low" @if (old('priority') == 'low') selected @endif>Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#pending_task_form').serialize();

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                        }
                    })
                }
            });
            $('.datePicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

            $('.custom-select').select2({

                theme: "classic",
                placeholder: "-- Please Choose --",
                allowClear: true
            });
        });

        // For In Progress
        $('.add_in_progress_task').click(function(event) {
            event.preventDefault();
            var task_members_option = '';
            leaders.forEach(function(leader) {
                task_members_option += `<option value="${leader.id}">${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_option += `<option value="${member.id}">${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add In Progress Task',

                html: `
                    <form id="in_progress_task_form">
                        <input type="hidden" name="status" value="in_progress">
                        <input type="hidden" name="project_id" value="${project_id}">
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control " name="title"
                                    value="{{ old('title') }}" placeholder="Ender Task Title">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control " rows="5" placeholder="Ender Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control datePicker @error('startDate') is-invalid @enderror"
                                    name="startDate" value="{{ old('startDate') }}" id="startDate">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="text" class="form-control datePicker @error('deadline') is-invalid @enderror"
                                    name="deadline" value="{{ old('deadline') }}" id="deadline">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="member" class="form-label">Members</label>
                                <select name="members[]" id="member" class="form-control custom-select" multiple>
                                    <option value="">-- Please Choose --</option>
                                    ${task_members_option}
                                </select>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="priority">Priority</label>
                                <select name="priority" class="form-control custom-select" id="priority">
                                    <option value="">-- Please Choose --</option>
                                    <option value="high" @if (old('priority') == 'high') selected @endif>High</option>
                                    <option value="middle" @if (old('priority') == 'middle') selected @endif>Middle</option>
                                    <option value="low" @if (old('priority') == 'low') selected @endif>Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#in_progress_task_form').serialize();

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                        }
                    })
                }
            });
            $('.datePicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

            $('.custom-select').select2({

                theme: "classic",
                placeholder: "-- Please Choose --",
                allowClear: true
            });
        });

        // For Complete
        $('.add_complete_task').click(function(event) {
            event.preventDefault();
            var task_members_option = '';
            leaders.forEach(function(leader) {
                task_members_option += `<option value="${leader.id}">${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_option += `<option value="${member.id}">${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Complete Task',

                html: `
                    <form id="complete_task_form">
                        <input type="hidden" name="status" value="complete">
                        <input type="hidden" name="project_id" value="${project_id}">
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control " name="title"
                                    value="{{ old('title') }}" placeholder="Ender Task Title">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control " rows="5" placeholder="Ender Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control datePicker @error('startDate') is-invalid @enderror"
                                    name="startDate" value="{{ old('startDate') }}" id="startDate">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="text" class="form-control datePicker @error('deadline') is-invalid @enderror"
                                    name="deadline" value="{{ old('deadline') }}" id="deadline">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="member" class="form-label">Members</label>
                                <select name="members[]" id="member" class="form-control custom-select" multiple>
                                    <option value="">-- Please Choose --</option>
                                    ${task_members_option}
                                </select>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="priority">Priority</label>
                                <select name="priority" class="form-control custom-select" id="priority">
                                    <option value="">-- Please Choose --</option>
                                    <option value="high" @if (old('priority') == 'high') selected @endif>High</option>
                                    <option value="middle" @if (old('priority') == 'middle') selected @endif>Middle</option>
                                    <option value="low" @if (old('priority') == 'low') selected @endif>Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#complete_task_form').serialize();

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                        }
                    })
                }
            });
            $('.datePicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

            $('.custom-select').select2({

                theme: "classic",
                placeholder: "-- Please Choose --",
                allowClear: true
            });
        });

        $('.edit_task_btn').on('click', function(event) {
            event.preventDefault();

            var task = JSON.parse(atob($(this).data('task')));
            var task_members = JSON.parse(atob($(this).data('task-members')));

            var task_members_option = '';
            leaders.forEach(function(leader) {
                task_members_option +=
                    `<option value="${leader.id}" ${(task_members.includes(leader.id)?'selected':'')}>${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_option +=
                    `<option value="${member.id}" ${(task_members.includes(member.id)?'selected':'')}>${member.name}</option>`;
            });

            Swal.fire({
                title: 'Edit Panding Task',

                html: `
                    <form id="edit_task_form">

                        <input type="hidden" name="project_id" value="${project_id}">
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Title</label>
                                <input type="text" class="form-control " name="title"
                                    value="${task.title}" placeholder="Ender Task Title" >
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" class="form-control " rows="5" placeholder="Ender Description">${task.description}</textarea>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control datePicker "
                                    name="startDate" value="${task.start_date}" id="startDate">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="text" class="form-control datePicker "
                                    name="deadline" value="${task.deadline}" id="deadline">
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="member" class="form-label">Members</label>
                                <select name="members[]" id="member" class="form-control custom-select" multiple>
                                    <option value="">-- Please Choose --</option>
                                    ${task_members_option}
                                </select>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="form-group text-start invalid-message">
                                <label for="priority">Priority</label>
                                <select name="priority" class="form-control custom-select" id="priority">
                                    <option value="">-- Please Choose --</option>
                                    <option value="high" @if (old('priority') == 'high') selected @endif ${task.priority == 'high'? 'selected':''}>High</option>
                                    <option value="middle" @if (old('priority') == 'middle') selected @endif ${task.priority == 'middle'? 'selected':''}>Middle</option>
                                    <option value="low" @if (old('priority') == 'low') selected @endif ${task.priority == 'low'? 'selected':''}>Low</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#edit_task_form').serialize();

                    $.ajax({
                        url: `/task/${task.id}`,
                        type: 'PUT',
                        data: form_data,
                        success: function(res) {
                            taskData();
                        }
                    })
                }
            });
            $('.datePicker').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "showDropdowns": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });

            $('.custom-select').select2({

                theme: "classic",
                placeholder: "-- Please Choose --",
                allowClear: true
            });

        })

        $('.delete_task_btn').on('click', function(event) {
            event.preventDefault();
            let id = $(this).data('id');
            swal({
                    text: "Are you sure went to Delete?",
                    buttons: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/task/${id}`,
                        }).done(function(res) {
                            taskData();
                        });
                    }
                });
        })
    })
</script>

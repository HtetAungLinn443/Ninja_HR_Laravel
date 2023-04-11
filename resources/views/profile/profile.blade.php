@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class=" text-center">
                        <img src="{{ $employee->profile_img_path() }}" class="profile-img" alt="">
                        <div class="py-3 px-2">
                            <h4 class="text-capitalize">{{ $employee->name }}</h4>
                            <p class=" mb-2">
                                <span class="text-muted">{{ $employee->employee_id }}</span> | <span
                                    class="text-theme">{{ $employee->phone }}</span>
                            </p>
                            <p class=" text-muted mb-2"><span
                                    class=" badge rounded-pill badge-dark p-2">{{ $employee->department ? $employee->department->title : '-' }}</span>
                            </p>
                            <p class=" text-muted mb-2">
                                @foreach ($employee->roles as $role)
                                    <span class=" badge rounded-pill badge-primary p-2">{{ $role->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 border-dash my-3">
                    <p class="mb-1"><b>Phone</b>: <span class=" text-muted">{{ $employee->phone }}</span></p>
                    <p class="mb-1"><b>Email</b>: <span class=" text-muted">{{ $employee->email }}</span></p>
                    <p class="mb-1"><b>NRC Number</b>: <span class=" text-muted">{{ $employee->nrc_number }}</span></p>
                    <p class="mb-1"><b>Address</b>: <span class=" text-muted">{{ $employee->address }}</span></p>
                    <p class="mb-1"><b>Gender</b>: <span class=" text-muted">{{ ucfirst($employee->gender) }}</span></p>
                    <p class="mb-1"><b>Birthday</b>: <span class=" text-muted">{{ $employee->birthday }}</span></p>
                    <p class="mb-1"><b>Date Of Join</b>: <span class=" text-muted">{{ $employee->date_of_join }}</span>
                    </p>
                    <p class="mb-1"><b>Is Present?</b>:
                        @if ($employee->is_present == 1)
                            <span class=" badge badge-pill badge-success">Present</span>
                        @else
                            <span class=" badge badge-pill badge-danger">Leave</span>
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5>Biometric Authentication</h5>

            <button type="submit" class="register-btn" id="fingerprint-register">
                <lord-icon src="https://cdn.lordicon.com/efdhjqgx.json" trigger="hover" style="width:80px;height:80px">
                </lord-icon>
                <i class="fa-solid fa-circle-plus fa-beat-fade"></i>
            </button>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <a href="#" class="btn-primary btn btn-block mb-1 logout-btn"><i
                    class="fa fa-sign-out-alt me-2"></i>Logout</a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.logout-btn').on('click', function(e) {
                e.preventDefault();
                swal({
                        text: "Are you sure went to Logout?",
                        buttons: true,
                        dangerMode: true,
                        icon: 'warning',
                    })
                    .then((success) => {
                        if (success) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-Token': "{{ csrf_token() }}"
                                },
                                type: "POST",
                                url: '/logout',
                                success: function() {
                                    window.location.replace('/');
                                }
                            });
                        }
                    });

            })
            // Larapass Register
            const register = function(event) {
                const webAuthn = new WebAuthn({
                    registerOptions: 'webauthn/register/options',
                    register: 'webauthn/register',
                });
                webAuthn.register()
                    .then(function(response) {
                        Swal.fire({
                            title: 'Successfully Created',
                            text: "The Biometric Data Succefully Created.",
                            icon: 'success',
                            confirmButtonText: 'Confirm'
                        });
                    })
                    .catch(error => console.log(error));
            }

            $('#fingerprint-register').click(function(event) {

                register(event)
            })


        })
    </script>

@endsection

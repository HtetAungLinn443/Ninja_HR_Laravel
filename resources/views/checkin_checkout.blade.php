@extends('layouts.app_plane')

@section('title', 'Check In -Check Out')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="col-md-6 col-sm-11 px-3">
            <div class="card">
                <div class="card-body ">
                    <div class="text-center  my-5">
                        <h5>QR Code</h5>
                        <div class="visible-print text-center mb-3">
                            {!! QrCode::size(200)->generate($hash_value) !!}
                        </div>
                        <p>Please scan QR Code to check in or checkout</p>
                    </div>
                    <hr>
                    <div class="my-5 text-center">
                        <h5 class=" text-center ">Pin Code</h5>
                        <div class="my-3">
                            <input type="text" name="mycode" id="pincode-input">
                        </div>
                        <p>Please Ender your Pin Code to check in or checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#pincode-input').pincodeInput({
                inputs: 6,
                complete: function(value, e, errorElement) {

                    $.ajax({
                        url: '/checkin-checkout/store',
                        type: 'GET',
                        data: {
                            "pin_code": value,
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

                            $('.pincode-input-container .pincode-input-text').val('');
                            $('.pincode-input-text').first().select().focus();
                        }
                    });


                }
            });
            $('.pincode-input-text').first().select().focus();

        })
    </script>
@endsection

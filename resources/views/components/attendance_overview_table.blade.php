<div class="table-responsive">
    <table class="table table-bordered ">
        <thead>
            <th>Employee</th>
            @foreach ($periods as $period)
                <th @if ($period->format('D') == 'Sat' || $period->format('D') == 'Sun') style="background:#ed969698;" @endif class="text-center">
                    {{ $period->format('d') }} <br> {{ $period->format('D') }}
                </th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    @foreach ($periods as $period)
                        @php
                            $office_start_time = $period->format('Y-m-d') . ' ' . $company_setting->office_start_time;
                            $office_end_time = $period->format('Y-m-d') . ' ' . $company_setting->office_end_time;
                            $break_start_time = $period->format('Y-m-d') . ' ' . $company_setting->break_start_time;
                            $break_end_time = $period->format('Y-m-d') . ' ' . $company_setting->break_end_time;
                            
                            $attendance = collect($attendances)
                                ->where('user_id', $employee->id)
                                ->where('date', $period->format('Y-m-d'))
                                ->first();
                            $checkin_icon = '';
                            $checkout_icon = '';
                            if ($attendance) {
                                if (!is_null($attendance->checkin_time)) {
                                    if ($attendance->checkin_time < $office_start_time) {
                                        $checkin_icon = '<i class="fa-solid fa-circle-check text-success"></i>';
                                    } elseif ($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time) {
                                        $checkin_icon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                                    } else {
                                        $checkin_icon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                    }
                                } else {
                                    $checkin_icon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                }
                            
                                if (!is_null($attendance->checkout_time)) {
                                    if ($attendance->checkout_time < $break_end_time) {
                                        $checkout_icon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                    } elseif ($attendance->checkout_time > $break_end_time && $attendance->checkout_time < $office_end_time) {
                                        $checkout_icon = '<i class="fa-solid fa-circle-check text-warning"></i>';
                                    } else {
                                        $checkout_icon = '<i class="fa-solid fa-circle-check text-success"></i>';
                                    }
                                } else {
                                    $checkout_icon = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                }
                            }
                            
                        @endphp
                        <td class="text-center" @if ($period->format('D') == 'Sat' || $period->format('D') == 'Sun') style="background:#ed969698;" @endif>
                            <div class="">{!! $checkin_icon !!}</div>
                            <div class="">{!! $checkout_icon !!}</div>
                        </td>
                    @endforeach

                </tr>
            @endforeach

        </tbody>
    </table>
</div>

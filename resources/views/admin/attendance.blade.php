@extends('layouts.admin')
@section('content')
<h2>Attendance Records</h2>
<table>
    <tr>
        <th>Employee</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Status</th>
    </tr>
    @foreach($attendances as $attendance)
    <tr>
        <td>{{ $attendance->employee->name }}</td>
        <td>{{ $attendance->check_in }}</td>
        <td>{{ $attendance->check_out }}</td>
        <td>{{ $attendance->status }}</td>
    </tr>
    @endforeach
</table>
@endsection

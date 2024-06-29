@extends('admin.layout')
@section('section')
    <div class="py-3">
        <table class="table">
            <thead class="text-capitalize">
                <th>@lang('text.sn')</th>
                <th>@lang('text.word_applicant')</th>
                <th>@lang('text.former_program')</th>
                <th>@lang('text.new_program')</th>
                <th>@lang('text.done_by')</th>
                <th>@lang('text.word_date')</th>
            </thead>
            <tbody>
                @php
                    $sn = 1;
                @endphp
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $report->form->name??'' }}</td>
                        <td>{{ $report->former_program_name??'' }}</td>
                        <td>{{ $report->current_program_name??'' }}</td>
                        <td>{{ $report->user->name??'' }}</td>
                        <td>{{ $report->created_at->format('d/m/y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@extends('admin.layout')
@section('section')
@php
$user = \Auth()->user()
@endphp
<div>
    <div class="d-flex justify-content-end py-3">
        <a href="{{ route('admin.programs.set_admins') }}" class="btn btn-xs btn-primary rounded">@lang('text.word_administrators')</a>
    </div>
    <table class="table">
        <thead class="text-capitalize">
            <tr class="border-y">
                <th colspan="6" class="text-center header">{{ $title ?? 'Fee Settings' }}</th>
            </tr>
            <tr class="border-y">
                <th>#</th>
                <th>@lang('text.word_class')</th>
                <th>@lang('text.word_tution')</th>
                <th>@lang('text.word_international')</th>
                <th>@lang('text.first_instalment')</th>
                <th>@lang('text.registration_fee')</th>
                <th>@lang('text.word_bank')</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            
            @foreach ($data as $school)
                <tr class="border-y text-center"><td colspan="7"> <span class="heading"> SCHOOL OF {{ ($school->first()->first()->first()['school']) ?? '----' }}</span> </td></tr>
                @foreach ($school as $department)
                    <tr class="border-y text-center"><td colspan="7"> <span class="heading"> DEPARTMENT OF {{ ($department->first()->first()['department']) ?? '----' }}</span> </td></tr>
                    @foreach ($department as $program)
                        <tr class="border-y text-center">
                            <td colspan="6"> <span class="heading">{{ ($program->first()['program']) ?? '----' }}</span> </td>
                            <td></td>
                        </tr>
                        @foreach ($program as $class)
                            <tr>
                                <td class="border">{{ $counter++ }}</td>
                                <td class="border">{{ $class['class_name'] }}</td>
                                <td class="border">{{ $class['amount'] }}</td>
                                <td class="border">{{ $class['international_amount'] }}</td>
                                <td class="border">{{ $class['first_instalment'] }}</td>
                                <td class="border">{{ $class['registration']??'----' }}</td>
                                <td class="border">
                                    <span> bank: {{ $class['bank_name'] }}</span><br>
                                    <span> account name: {{ $class['bank_account_name'] }}</span><br>
                                    <span> account number: {{ $class['bank_account_number'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection

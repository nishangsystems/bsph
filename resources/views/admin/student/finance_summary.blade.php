@extends('admin.layout')
@section('section')
    <div class="container-fluid">
        <table class="border">
            <thead class="text-uppercase text-primary border-bottom" style="background-color: aliceblue; font-family: Arial, Helvetica, sans-serif;">
                <th class="border-left border-right">@lang('text.word_school')</th>
                <th class="border-left border-right">@lang('text.word_background')</th>
                <th class="border-left border-right">@lang('text.word_program')</th>
                <th class="border-left border-right">@lang('text.number_of_payments')</th>
                <th class="border-left border-right">@lang('text.number_of_bypasses')</th>
                <th class="border-left border-right">@lang('text.amount_recieved') (@lang('text.currency_cfa'))</th>
            </thead>
            <tbody>
                @foreach ($school_structure->groupBy('school_id') as $school)
                    @php $school_count = 0; @endphp
                    @foreach ($school->groupBy('background_id') as $background)
                        @php $background_count = 0; @endphp
                        @foreach ($background->groupBy('program_id') as $program)
                            <tr class="border bg-light">
                                @if($school_count == 0 and isset($program->first()['school']))
                                    {{-- @dd($program) --}}
                                    <td class="border-left border-right" rowspan="{{ $school->groupBy('program_id')->count() + $school->groupBy('background_id')->count() + 1 }}">{{ $program->first()['school'] }}</td>
                                    @php $school_count += 1; @endphp
                                @endif
                                @if($background_count == 0 and isset($program->first()['background_name']))
                                    @php $background_count += 1; @endphp
                                    <td class="border-left border-right" rowspan="{{ $background->groupBy('program_id')->count() + 1 }}">{{ $program->first()['background_name'] }}</td>
                                @endif
                                <td class="border-left border-right">{{ $program->first()['program'] }}</td>
                                <td class="border-left border-right">{{ $applications->where('program_first_choice', $program->first()['program_id'])->where('amount', '>', 0)->count() }}</td>
                                <td class="border-left border-right">{{ $applications->where('program_first_choice', $program->first()['program_id'])->where('amount', 0)->count() }}</td>
                                <td class="border-left border-right" class="text-danger">{{ number_format($applications->where('program_first_choice', $program->first()['program_id'])->where('amount', '>', 0)->sum('amount')) }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-info text-uppercase">
                            <td class="border-left border-right" colspan="1">@lang('text.word_total')</td>
                            <td class="border-left border-right" colspan="1">{{ $applications->whereIn('program_first_choice', $background->pluck('program_id'))->where('amount', '>', 0)->count() }}</td>
                            <td class="border-left border-right" colspan="1">{{ $applications->whereIn('program_first_choice', $background->pluck('program_id'))->where('amount', '=', 0)->count() }}</td>
                            <td class="border-left border-right">{{ number_format($applications->whereIn('program_first_choice', $background->pluck('program_id'))->where('amount', '>', 0)->sum('amount')) }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-warning text-uppercase">
                        <td class="border-left border-right" colspan="2">@lang('text.word_total')</td>
                        <td class="border-left border-right">{{ number_format($applications->whereIn('program_first_choice', $school->pluck('program_id'))->where('amount', '>', 0)->count()) }}</td>
                        <td class="border-left border-right">{{ $applications->whereIn('program_first_choice', $school->pluck('program_id'))->where('amount', '=', 0)->count() }}</td>
                        <td class="border-left border-right">{{ number_format($applications->whereIn('program_first_choice', $school->pluck('program_id'))->where('amount', '>', 0)->sum('amount')) }}</td>
                    </tr>
                @endforeach
                <tr class="bg-dark text-white text-uppercase">
                    <td class="border-left border-right" colspan="3">@lang('text.grand_total')</td>
                    <td class="border-left border-right">{{ number_format($applications->whereIn('program_first_choice', $school_structure->pluck('program_id'))->where('amount', '>', 0)->count()) }}</td>
                    <td class="border-left border-right">{{ $applications->whereIn('program_first_choice', $school_structure->pluck('program_id'))->where('amount', '=', 0)->count() }}</td>
                    <td class="border-left border-right">{{ number_format($applications->whereIn('program_first_choice', $school_structure->pluck('program_id'))->where('amount', '>', 0)->sum('amount')) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
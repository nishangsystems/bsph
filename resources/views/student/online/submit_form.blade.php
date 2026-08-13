@extends('student.layout')
@section('section')
    <div class="py-3">
        <table class="table">
            <thead><tr class="text-capitalize">
                <th>{{ __('text.sn') }}</th>
                <th>{{ __('text.word_applicant') }}</th>
                <th>{{ __('text.word_program') }}</th>
                <th></th>
            </tr></thead>
            <tbody>
                @php($k = 1)
                @foreach ($applications as $appl)
                    <tr class="border-bottom">
                        <td class="border-left border-right">{{ $k++ }}</td>
                        <td class="border-left border-right">{{ $appl->name }}</td>
                        <td class="border-left border-right">{{ ($appl->programFirstChoice==null ? null : $appl->programFirstChoice->name).' / '.($appl->programSecondChoice ==null ? null : $appl->programSecondChoice->name) }}</td>
                        <td class="border-left border-right d-flex flex-wrap">
                            <a class="btn btn-xs btn-primary mx-2" href="{{ route('student.application.start', [0, $appl->id]) }}">{{ __('text.word_fill') }}</a>
                            @if($appl->degree_id != null)
                                <a class="btn btn-xs btn-success mx-2" href="{{ route('student.application.start', [5, $appl->id]) }}">{{ __('text.word_preview') }}</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
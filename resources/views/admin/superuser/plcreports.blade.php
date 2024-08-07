@extends('admin.layout')
@section('section')
    <div class="py-3">
        <div class="card rounded-sm border-0">
            <div class="card-body">
                <table class="table">
                    <thead class="text-uppercase">
                        <th class="border-left border-right">@lang('text.sn')</th>
                        <th class="border-left border-right">{{ trans_choice('text.word_day', 1) }}</th>
                        <th class="border-left border-right">@lang('text.payments_made')</th>
                        <th class="border-left border-right">@lang('text.amount_recieved')</th>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1;
                        @endphp
                        @foreach($report as $key => $record)
                            <tr>
                                <td>{{$counter++}}</td>
                                <td>{{$record->day}}</td>
                                <td>{{$record->count}}</td>
                                <td>{{$record->amount_received}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
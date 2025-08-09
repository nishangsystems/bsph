@extends('admin.layout')
@section('section')
    <div class="py-3">
        @if(isset($degrees))
            <table class="table">
                <thead class="text-uppercase border-bottom">
                    <th class="border-left border-right">{{ __('text.sn') }}</th>
                    <th class="border-left border-right">{{ __('text.word_degree') }}</th>
                    <th class="border-left border-right">{{ __('text.word_count') }}</th>
                    <th class="border-left border-right"></th>
                </thead>
                <tbody>
                    @php($k = 1)
                    @foreach ($degrees as $deg)
                        <tr class="border-bottom">
                            <td class="border-left border-right">{{ $k++ }}</td>
                            <td class="border-left border-right">{{ $deg->deg_name }}</td>
                            @if($campus_id != null)
                            <td class="border-left border-right">{{ \App\Models\ApplicationForm::where('degree_id', $deg->id)->whereNotNull('submitted')->where('campus_id', $campus_id)->count() }}</td>
                            @else
                            <td class="border-left border-right">{{ \App\Models\ApplicationForm::where('degree_id', $deg->id)->whereNotNull('submitted')->count() }}</td>
                            @endif
                            <td class="border-left border-right"><a class="btn btn-sm btn-primary text-capitalize" href="{{ route('admin.applications.by_degree', ['id'=>$deg->id]) }}">{{ __('text.word_all') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <table class="border-left border-right table-stripped table">
                <thead class="text-capitalize border-bottom">
                    <th class="border-left border-right">{{ __('text.sn') }}</th>
                    <th class="border-left border-right">{{ __('text.full_name') }}</th>
                    <th class="border-left border-right">{{ __('text.word_tel') }}</th>
                    <th class="border-left border-right">{{ __('text.word_email') }}</th>
                    <th class="border-left border-right">{{ __('text.first_choice') }}</th>
                    <th class="border-left border-right">{{ __('text.second_choice') }}</th>
                    <th class="border-left border-right">{{ __('text.date_applied') }}</th>
                </thead>
                <tbody>
                    @php($k = 1)
                    @foreach ($appls as $appl)
                        <tr class="border-bottom">
                            <td class="border-left border-right">{{ $k++ }}</td>
                            <td class="border-left border-right">{{ $appl->name }}</td>
                            <td class="border-left border-right">{{ $appl->phone }}</td>
                            <td class="border-left border-right">{{ $appl->email }}</td>
                            <td class="border-left border-right">{{ $progs->where('id', $appl->program_first_choice)->first()->name??null }}</td>
                            <td class="border-left border-right">{{ $progs->where('id', $appl->program_second_choice)->first()->name??null }}</td>
                            <td class="border-left border-right">{{ $appl->transaction->created_at??null }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
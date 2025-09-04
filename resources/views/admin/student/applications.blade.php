@extends('admin.layout')
@section('section')
    @php
        $campuses = collect(json_decode($api_service->campuses())->data);
        $degrees = collect(json_decode($api_service->degrees())->data);
        $programs = collect(json_decode($api_service->programs())->data);
    @endphp
    <div class="py-3">
        <div class="py-2">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-light table-stripped" id="hidden-table-info">
                <thead>
                    <tr class="text-capitalize border-bottom border-dark">
                        <th class="border-left border-right" rowspan="2">#</th>
                        <th class="border-left border-right" rowspan="2">{{__('text.word_name')}}</th>
                        {{-- <th class="border-left border-right" rowspan="2">{{__('text.word_email')}}</th> --}}
                        <th class="border-left border-right" rowspan="2">{{__('text.word_phone')}}</th>
                        @isset($adml)<th class="border-left border-right" rowspan="2">{{__('text.admission_date')}}</th>@endisset
                        <th class="border-left border-right" rowspan="2">{{__('text.word_degree')}}</th> 
                        <th class="border-left border-right" colspan="2">{{__('text.word_programs')}}</th> 
                        <th class="border-left border-right" rowspan="2"></th>
                    </tr>
                    <tr class="text-capitalize border-bottom border-dark">
                        <th class="border-left border-right">{{__('text.word_first')}}</th>
                        <th class="border-left border-right">{{__('text.word_second')}}</th> 
                    </tr>
                </thead>
                <tbody id="table_body">
                    @php($k = 1)
                    @foreach ($applications as $appl)
                        <tr class="border-bottom">
                            <td class="border-left border-right">{{ $k++ }}</td>
                            <td class="border-left border-right">{{ $appl->name == null ? \App\Models\Students::find($appl->student_id)->name : $appl->name }}</td>
                            {{-- <td class="border-left border-right">{{ $appl->email == null ? \App\Models\Students::find($appl->student_id)->email : $appl->email }}</td> --}}
                            <td class="border-left border-right">{{ $appl->phone == null ? \App\Models\Students::find($appl->student_id)->phone : $appl->phone }}</td>
                            @isset($adml)<td class="border-left border-right">{{ $appl->admitted_at == null ? '' : $appl->admitted_at->format('d-m-Y') }}</td>@endisset
                            <td class="border-left border-right">{{ $degrees->where('id', $appl->degree_id)->first()->deg_name??null }}</td>
                            <td class="border-left border-right">{{ $programs->where('id', $appl->program_first_choice)->first()->name??null }}</td>
                            <td class="border-left border-right">{{ $programs->where('id', $appl->program_second_choice)->first()->name??null }}</td>
                            <td class="border-left border-right">
                                @isset($action)
                                    <a href="{{ route('admin.admission.show', $appl->id) }}" class="btn btn-xs btn-success mt-1">@lang('text.word_show')</a>|
                                    @if(isset($download))
                                        <a href="{{ Request::url() }}/{{  $appl->id }}?_atn=_dld" class="btn btn-xs btn-primary mt-1">{{ $download }}</a>
                                    @else
                                        <a href="{{ Request::url().'/'.$appl->id }}" class="btn btn-xs btn-primary mt-1">{{ $action }}</a>
                                    @endif
                                @endisset
                                @isset($adml)
                                    <a href="{{ Request::url() }}/{{ $appl->id }}?_atn=_dld" class="btn btn-xs btn-success mt-1">@lang('text.word_download')</a>
                                @endisset
                                @if(empty($appl->admitted))
                                    <a href="{{ route('admin.applications.delete', $appl->id)}}" class="btn btn-xs btn-danger mt-1">@lang('text.word_delete')</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">

            </div>
        </div>
    </div>
@endsection
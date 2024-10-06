@extends('admin.layout')
@section('section')
    <div class="py-3">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <a href="{{route('admin.custom_applications.create')}}" class="btn btn-sm rounded btn-primary">@lang('text.new_application')</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-capitalize">
                        <th>@lang('text.sn')</th>
                        <th>@lang('text.word_name')</th>
                        <th>@lang('text.word_gender')</th>
                        <th>@lang('text.word_phone')</th>
                        <th>@lang('text.date_of_birth')</th>
                        <th>@lang('text.place_of_birth')</th>
                        <th>@lang('text.word_program')</th>
                        <th>@lang('text.word_level')</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @php($sn = 1)
                        @foreach ($applications as $appl)
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$appl->name??''}}</td>
                                <td>{{$appl->gender??''}}</td>
                                <td>{{$appl->phone??''}}</td>
                                <td>{{$appl->dob != null ? $appl->dob->format('dS M Y') : null}}</td>
                                <td>{{$appl->pob??''}}</td>
                                <td>{{$appl->program_name??''}}</td>
                                <td>{{$appl->level??''}}</td>
                                <td>
                                    <a href="{{route('admin.applications.admission_letter', $appl->id)}}?_atn=download" class="btn btn-xs btn-primary rounded">@lang('text.admission_letter')</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
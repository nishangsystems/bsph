@extends('admin.layout')
@section('section')
    <div class="py-3 container-fluid">
        <div class="card border-0">
            <div class="card-header">
                <form method="get">
                    @csrf
                    <div class="py-2">
                        <small class="text-capitalize text-info"><b>@lang('text.select_program')</b></small>
                        <select name="program" id="" class="form-control rounded border-left-0 border-right-0">
                            <option value=""></option>
                            @foreach($programs as $key => $prog)
                                <option value="{{$prog->id}}" {{request('program', old('program')) == $prog->id ? 'selected' : ''}}>{{$prog->name}}</option>
                            @endforeach
                        </select>
                        <button class="btn form-control rounded btn-primary btn-md text-capitalize" type="submit">@lang('text.word_next')</button>
                    </div>
                </form>
            </div>
            <div class="card-body py-3">
                <table class="table table-stripped">
                    <thead class="text-capitalize text-dark">
                        <tr>
                            <th colspan="6"><b class="h4 text-uppercase">{{$title??''}}</b></th>
                        </tr>
                        <tr class="border-top border-bottom">
                            <th>@lang('text.sn')</th>
                            <th>@lang('text.word_name')</th>
                            <th>@lang('text.date_of_birth')</th>
                            <th>@lang('text.place_of_birth')</th>
                            <th>@lang('text.phone_number')</th>
                            <th>@lang('text.word_program')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($students)
                            @php
                                $counter = 1;
                            @endphp
                            @foreach($students as $key => $stud)
                                <tr>
                                    <td class="border-right">{{$counter++}}</td>
                                    <td class="border-right">{{$stud->name}}</td>
                                    <td class="border-right">{{isset($stud->dob) ? $stud->dob->format('d/m/Y') : ''}}</td>
                                    <td class="border-right">{{$stud->pob}}</td>
                                    <td class="border-right">{{$stud->phone}}</td>
                                    <td class="border-right">{{$program->name}}</td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
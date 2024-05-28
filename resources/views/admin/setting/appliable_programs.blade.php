@extends('admin.layout')
@section('section')
    <div class="py-3">
        <form method="POST">
            @csrf
            <div class="alert-success py-3 h3 text-center text-capitalize border-top border-bottom border-dark"><b>@lang('text.set_appliable_programs')</b></div>
            <div class="container-fluid my-2">
                @php
                    $k = 1;
                @endphp
                @foreach ($programs as $program)
                    <div class="row py-2 border-bottom border-secondary {{ ($program->appliable??'') == 1 ? 'alert-info': '' }}">
                        <div class="col-sm-1">{{ $k++ }}</div>
                        <div class="col-sm-3"><input type="checkbox" name="programs[]" value="{{ $program->id??'' }}" class="checkbox input" {{ ($program->appliable??'') == 1 ? 'checked' : ''}}></div>
                        <div class="col-sm-8">{{ $program->name??'' }}</div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end py-2">
                <button class="btn btn-primary btn-sm rounded text-capitalize">@lang('text.word_update')</button>
            </div>
        </form>
    </div>
@endsection
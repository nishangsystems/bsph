@extends('admin.layout')
@section('section')
    <div class="py-3">
        <table class="table-stripped my-2 table">
            <thead class="text-capitalize">
                <th>@lang('text.sn')</th>
                <th>@lang('text.word_program')</th>
                <th></th>
            </thead>
            <tbody>
                @php $k = 1; @endphp
                @foreach($programs as $program)
                    <tr>
                        <td>{{ $k++ }}</td>
                        <td>{{ $program->name }}</td>
                        <td><a href="{{ route('admin.programs.p2.create', ['program_id'=>$program->id]) }}" class="btn btn-primary btn-sm rounded">@lang('text.word_next')</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@extends('student.layout')
@section('section')
    <div class="w-100">
        <div id="accordion" class="panel-group">
            @foreach (($campuses[0]->programs) ?? [] as $key => $school)                    
                <table class="border">
                    <thead><tr class="text-capitalize border-bottom">
                        <th class="border-left border-right">{{ __('text.sn') }}</th>
                        <th class="border-left border-right">{{ __('text.word_program') }}</th>
                        <th class="border-left border-right"></th>
                    </tr></thead>
                    <tbody>
                        @php($k = 1)
                        <tr><th class="text-center text-uppercase border-top border-bottom border-dark" colspan="3">{{ $key }}</th></tr>
                        {{-- @dd($campus->programs) --}}
                        @foreach ($school??[] as $program)
                        <tr class="border-bottom">  
                            <td class="border-left border-right">{{ $k++ }}</td>
                            <td class="border-left border-right">{{ $program->name }}</td>
                            <td class="border-left border-right">
                                @if ($program->appliable == 1)
                                    <a href="{{ route('student.application.start', 0) }}?_prg={{ $program->id }}" class="btn btn-sm rounded btn-primary">apply</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection
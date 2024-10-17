@extends('admin.layout')
@section('script')
    <script>
        let load_levels = (element)=>{
            let program = $(element).val();
            let url = "{{route('_program_levels', '__PROG_ID__')}}".replace('__PROG_ID__', program);
            $.ajax({
                method : 'GET', url : url, success : function(data){
                    console.log(data);
                    let html = `<select name="level" required id="" class="form-control rounded border-top-0 border-left-0 border-right-0">
                                    <option value="">@lang('text.select_level')</option>`;
                    data.forEach(element => {
                        html += `<option value="${element.level}">${element.level}</option>`;
                    });
                    html += `</select>
                            <small class="text-secondary text-capitalize"><i>@lang('text.word_level')</i></small>`;
                    $('#level_listing').html(html);
                }
            });
        }
    </script>
@endsection
@section('section')
    <div class="py-2">
        <div class="container-fluid">
            <div class="card my-3">
                <div class="card-header text-center text-uppercase">
                    <strong>@lang('text.program_switch')</strong>
                </div>
                <div class="card-body py-2">
                    <form method="post">
                        @csrf
                        <div class="d-flex justify-content-end py-2 text-capitalize">
                            <strong class="mr-4">@lang('text.word_foreigner') <input type="radio" name="foreigner" value="F" id="" class="mx-2"></strong>
                            <strong class="mr-4">@lang('text.word_cameroonian') <input type="radio" name="foreigner" value="" id="" class="mx-2" checked></strong>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 container-fluid">
                                <div class="mb-2 border-bottom rounded text-center text-capitalize"><strong>@lang('text.personal_information')</strong></div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0">{{$student['name']}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_name')</i></small>
                                </div>
                                <div class="my-2">
                                    <input type="hidden" name="matric" value="{{$student['matric']}}">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0">{{$student['matric']}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_matricule')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0">{{$student['gender']}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_gender')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0">{{$student['phone']}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_phone')</i></small>
                                </div>
                            </div>
                            <div class="col-lg-6 container-fluid">
                                <div class="mb-2 border-bottom rounded text-center text-capitalize"><strong>@lang('text.current_program')</strong></div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0">{{($program = $programs->where('id', $student_class['program_id'])->first()) != null ? $program->name : '----'}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_program')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 border-left-0 border-right-0" >{{($level = $levels->where('id', $student_class['level_id'])->first()) != null ? $level->level : '----'}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_level')</i></small>
                                </div>
                                <div class="mb-2 mt-4 border-bottom rounded text-center text-capitalize"><strong>@lang('text.new_program')</strong></div>
                                <div class="my-2">
                                    <select name="program_id" class="form-control rounded border-top-0 border-left-0 border-right-0" required onchange="load_levels(this)">
                                        <option value="">@lang('text.select_program')</option>
                                        @foreach ($programs as $program)
                                            <option value="{{$program->id}}">{{$program->name??''}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_program')</i></small>
                                </div>
                                <div class="my-2" id="level_listing"></div>
                            </div>
                        </div>
                        <div class="container-fluid d-flex justify-content-end py-2 mt-3">
                            <button class="btn btn-sm rounded btn-primary text-capitalize" type="submit">@lang('text.switch_program')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

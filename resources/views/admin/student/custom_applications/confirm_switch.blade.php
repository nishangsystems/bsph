@extends('admin.layout')

@section('section')
    <div class="py-2">
        <div class="container-fluid">
            <div class="card my-3">
                <div class="card-header text-center text-uppercase">
                    <strong>@lang('text.confirm_program_switching')</strong>
                </div>
                <div class="card-body py-2">
                    <form method="post" action="{{route('admin.custom_applications.switch_confirmed')}}">
                        @csrf
                        
                        <div class="row mt-4">
                            <div class="col-12 mb-2 border-bottom rounded text-center text-capitalize"><strong>@lang('text.personal_information')</strong></div>
                            <div class="my-2 col-lg-8">
                                <label class="form-control rounded border-top-0">{{$student['name']}}</label>
                                <small class="text-secondary text-capitalize"><i>@lang('text.word_name')</i></small>
                            </div>
                            <div class="my-2 col-lg-4">
                                <label class="form-control rounded border-top-0">{{$student['gender']}}</label>
                                <small class="text-secondary text-capitalize"><i>@lang('text.word_gender')</i></small>
                            </div>
                            <div class="my-2 col-lg-4">
                                <label class="form-control rounded border-top-0">{{$student['dob'] != null ? now()->parse($student['dob'])->format('l dS M Y') : '----'}}</label>
                                <small class="text-secondary text-capitalize"><i>@lang('text.date_of_birth')</i></small>
                            </div>
                            <div class="my-2 col-lg-4">
                                <label class="form-control rounded border-top-0">{{$student['pob']}}</label>
                                <small class="text-secondary text-capitalize"><i>@lang('text.place_of_birth')</i></small>
                            </div>
                            <div class="my-2 col-lg-4">
                                <label class="form-control rounded border-top-0">{{$student['phone']}}</label>
                                <small class="text-secondary text-capitalize"><i>@lang('text.word_phone')</i></small>
                            </div>
                            <hr class="col-12">
                            <div class="col-lg-6 container-fluid pt-4">
                                <div class="mb-2 border-bottom rounded text-center text-capitalize"><strong>@lang('text.current_program')</strong></div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0">{{$old_program->name??''}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_program')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0" >{{$old_level}}</label>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_level')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0" >{{$student['matric']}}</label>
                                    <input type="hidden" name="old_matric" value="{{$student['matric']}}" required>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_matricule')</i></small>
                                </div>
                            </div>
                            <div class="col-lg-6 container-fluid pt-4">
                                <div class="mb-2 border-bottom rounded text-center text-capitalize"><strong>@lang('text.new_program')</strong></div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0">{{$new_program->name}}</label>
                                    <input type="hidden" name="program_id" value="{{$new_program->id}}" required>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_program')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 ">{{$new_level}}</label>
                                    <input type="hidden" name="level" value="{{$new_level}}" required>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_level')</i></small>
                                </div>
                                <div class="my-2">
                                    <label class="form-control rounded border-top-0 ">{{$matricule}}</label>
                                    <input type="hidden" name="matric" value="{{$matricule}}" required>
                                    <small class="text-secondary text-capitalize"><i>@lang('text.word_matricule')</i></small>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid d-flex justify-content-end py-2 mt-3">
                            <button class="btn btn-sm rounded btn-primary text-capitalize" type="submit">@lang('text.word_confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

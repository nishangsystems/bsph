@extends('admin.layout')
@section('script')
    <script>
        let degreeChanged = function(event){
            let degree = $(event.target).val();
            let _url = "{{route('degree_programs', '__DEG_ID__')}}".replace('__DEG_ID__', degree);
            $.ajax({
                method: "GET", url: _url, success: function(response){
                    console.log(response);
                    let html = `<option value="">@lang('text.word_program')</option>`;
                    // response.forEach(element => {
                    //     html += `<option value="${element.id}">${element.name}</option>`;
                    // });
                    for (const key in response) {
                        if (Object.prototype.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            html += `<option value="${element.id}">${element.name}</option>`;
                        }
                    }
                    $('#program_selection').html(html);
                }
            });
        }

        let programChanged = function(event){
            let program = $(event.target).val();
            let _url = "{{route('_program_levels', '__PROG_ID__')}}".replace('__PROG_ID__', program);
            $.ajax({
                method: "GET", url: _url, success: function(response){
                    console.log(response);
                    let html = `<option value="">@lang('text.word_level')</option>`;
                    for (const key in response) {
                        if (Object.prototype.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            html += `<option value="${element.level}">${element.level}</option>`
                        }
                    }
                    $('#level_selection').html(html);
                }
            });
        }
    </script>
@endsection
@section('section')
    <div class="py-3">
        <div class="card">
            <div class="card-header text-center text-capitalize"><b>{{$title??'----'}}</b></div>
            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="row py-2">
                        <div class="col-lg-6">
                            <h4 class="text-center text-capitalize text-primary"><b>@lang('text.personal_information')</b></h4>
                            <hr>
                            <div class="mb-3">
                                <input type="text" required class="form-control border-top-0 border-left-0 border-right-0 border-bottom  rounded" name="name" value="{{old('name')}}">
                                <i class="text-info">@lang('text.word_name')</i>
                            </div>
                            <div class="mb-3">
                                <select class="form-control border-top-0 border-left-0 border-right-0 border-bottom  rounded" name="gender" required value="{{old('gender')}}">
                                    <option value=""></option>
                                    <option value="male" {{old('gender') == 'male' ? 'selected': ''}}>male</option>
                                    <option value="female" {{old('gender') == 'female' ? 'selected': ''}}>female</option>
                                </select>
                                <i class="text-info">@lang('text.word_gender')</i>
                            </div>
                            <div class="mb-3">
                                <input type="date" class="form-control border-top-0 border-left-0 border-right-0 border-bottom  rounded" name="dob" value="{{old('dob')}}">
                                <i class="text-info">@lang('text.date_of_birth')</i>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control border-top-0 border-left-0 border-right-0 border-bottom  rounded" name="pob" value="{{old('pob')}}">
                                <i class="text-info">@lang('text.place_of_birth')</i>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control border-top-0 border-left-0 border-right-0 border-bottom  rounded" name="phone" required value="{{old('phone')}}">
                                <i class="text-info">@lang('text.word_phone')</i>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="text-center text-capitalize text-primary"><b>@lang('text.word_program')</b></h4>
                            <hr>
                            <input type="hidden" name="campus_id" value="5">
                            <div class="mb-3">
                                <select name="degree_id" required class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " id="" onchange="degreeChanged(event)">
                                    <option value=""></option>
                                    @foreach ($degrees as $deg)
                                        <option value="{{$deg->id??''}}" {{old('degree_id') == $deg->id ? 'selected' : ''}}>{{$deg->deg_name}}</option>
                                    @endforeach
                                </select>
                                <i class="text-info">@lang('text.word_degree')</i>
                            </div>
                            <div class="mb-3">
                                <select name="program_first_choice" required class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " id="program_selection" onchange="programChanged(event)">
                                    <option value=""></option>
                                </select>
                                <i class="text-info">@lang('text.word_program')</i>
                            </div>
                            <div class="mb-3">
                                <select name="level" required class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " id="level_selection">
                                    <option value=""></option>
                                </select>
                                <i class="text-info">@lang('text.word_level')</i>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end pt-3">
                            <button class="btn btn-xs rounded btn-primary text-capitalize px-3" type="submit">@lang('text.word_save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

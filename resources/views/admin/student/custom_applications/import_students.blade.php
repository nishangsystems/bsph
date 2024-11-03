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
    <div class="mx-3">
        <div class="form-panel card border-0 shadow">
            <div class="py-3 card-body">
                <form class="form-horizontal" role="form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 border-right h-lg-100">
                            
                            <div class="mb-3 @error('name') has-error @enderror">
                                <input class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " required name="name" value="{{old('name')}}">
                                <i class="text-info">{{__('text.word_name')}}</i>
                                @error('name')
                                    <em class="text-danger">{{$message}}</em>
                                @enderror
                            </div>
                            
                            <div class="mb-3 @error('matric') has-error @enderror">
                                <input class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " required name="matric" value="{{old('matric')}}">
                                <i class="text-info">{{__('text.word_matricule')}}</i>
                                @error('matric')
                                    <em class="text-danger">{{$message}}</em>
                                @enderror
                            </div>
        
                            <div class="mb-3 @error('gender') has-error @enderror">
                                <select class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " required name="gender">
                                    <option selected></option>
                                    <option value="male" {{old('gender') == 'male' ? 'selected' : ''}}>Male</option>
                                    <option value="female" {{old('gender') == 'female' ? 'selected' : ''}}>Female</option>
                                </select>
                                <i class="text-info">{{__('text.word_gender')}}</i>
                                @error('gender')
                                    <em class="text-danger">{{$message}}</em>
                                @enderror
                            </div>
                            
                            <div class="mb-3 @error('dob') has-error @enderror">
                                <input class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " type="date" name="dob" value="{{old('dob')}}">
                                <i class="text-info">{{__('text.date_of_birth')}}</i>
                                @error('dob')
                                    <em class="text-danger">{{$message}}</em>
                                @enderror
                            </div>
        
                            <div class="mb-3 @error('pob') has-error @enderror">
                                <input class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " name="pob" value="{{old('pob')}}">
                                <i class="text-info">{{__('text.date_of_birth')}}</i>
                                @error('pob')
                                    <em class="text-danger">{{$message}}</em>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <h5 class="mt-5 mb-4 font-weight-bold text-capitalize">{{__('text.admission_class_information')}}</h5>
                            
                            <input type="hidden" name="campus_id" value="5">
                            <div class="mb-3 @error('section') has-error @enderror">
                                <select class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " required name="batch" {{!(auth()->user()->campus_id == null) ? 'disabled' : ''}}>
                                    <option selected></option>
                                    @forelse(\App\Models\Batch::orderBy('name')->get() as $section)
                                        <option {{ $section->id == \App\Helpers\Helpers::instance()->getCurrentAccademicYear() ? 'selected' : '' }} value="{{$section->id}}">{{$section->name}}</option>
                                    @empty
                                        <option>{{__('text.no_batch_created')}}</option>
                                    @endforelse
                                </select>
                                <i class="text-info">{{__('text.word_batch')}}</i>
                            </div>
            
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
                    </div>
                    
                    
    
                    <div class="form-group">
                        <div class="d-flex justify-content-end col-lg-12">
                            <button id="save" class="btn btn-xs btn-primary mx-3" type="submit">{{__('text.word_save')}}</button>
                        </div>
                    </div>
    
                </form>
                
            </div>
        </div>
    </div>
@endsection

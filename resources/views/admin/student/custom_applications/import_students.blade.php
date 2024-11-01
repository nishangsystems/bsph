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
        <div class="form-panel row">
            <div class="col-lg-6 border-right py-3">
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST">
                    @csrf
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
    
                    <div class="mb-3 @error('file') has-error @enderror text-capitalize">
                        <input class="form-control rounded border-top-0 border-left-0 border-right-0 border-bottom " name="file" value="{{old('file')}}" type="file" required/>
                        @error('file')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <i class="text-info">{{__('text.csv_file')}} ({{__('text.word_required')}})</i>
                    </div>
    
                    <h5 class="mt-5 mb-4 font-weight-bold text-capitalize">{{__('text.admission_class_information')}}</h5>
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
    
                    <div class="form-group">
                        <div class="d-flex justify-content-end col-lg-12">
                            <button id="save" class="btn btn-xs btn-primary mx-3" type="submit">{{__('text.word_save')}}</button>
                        </div>
                    </div>
    
                </form>
                
            </div>
            <div class="col-lg-6 py-3 px-2">
                <div class="text-center text-capitalize text-primary py-3">{{__('text.file_format_csv')}}</div>
                <table class="bg-light">
                    <thead class="text-capitalize bg-dark text-light fs-6">
                        <th>@lang('text.word_name') <span class="text-danger">*</span></th>
                        <th>@lang('text.word_matricule') <span class="text-danger">*</span></th>
                        <th>@lang('text.word_gender')</th>
                        <th>@lang('text.place_of_birth')</th>
                        <th>@lang('text.date_of_birth')</th>
                    </thead>
                    <tbody>
                        @for($i=0; $i < 4; $i++)
                        <tr class="border-bottom">
                            <td>---</td>
                            <td>---</td>
                            <td>---</td>
                            <td>---</td>
                            <td>---</td>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

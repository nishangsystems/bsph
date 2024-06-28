@extends('admin.layout')
@section('section')
    <div class="py-4">
        <form enctype="multipart/form-data" id="application_form" method="post">
            @csrf
            <div class="py-2 row text-capitalize bg-light">
                
                <div class="py-2 col-sm-6 col-md-6 col-lg-6">
                    <label class="text-secondary  text-capitalize">{{ __('text.word_name') }}</label>
                    <div class="">
                        <input value="{{ $application->name }}" class="form-control text-primary" readonly  required>
                    </div>
                </div>
                <div class="py-2 col-sm-6 col-md-2 col-lg-2">
                    <label class="text-secondary  text-capitalize">{{ __('text.word_matricule') }}</label>
                    <div class="">
                        <input value="{{ $application->matric }}" class="form-control text-primary" readonly  required>
                    </div>
                </div>
                <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                    <label class="text-secondary  text-capitalize">{{ __('text.word_campus') }}</label>
                    <div class="">
                        <select class="form-control text-primary"  name="campus_id" required disabled>
                            <option value=""></option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ $application->campus_id== $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <label class="text-secondary  text-capitalize">{{ __('text.current_program') }}</label>
                    <div class="">
                        <select class="form-control text-primary"  name="current_program" required disabled>
                            <option>{{ __('text.select_program') }}</option>
                            @forelse ($programs as $program)
                                <option value="{{ $program->id }}" {{ $application->program_first_choice == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                            @empty
                                <option>{{ __('text.no_data_available') }}</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <label class=" text-secondary text-capitalize">{{ __('text.new_program') }}</label>
                    <div class="">
                        <select class="form-control text-primary"  name="new_program" required oninput="loadCplevels(event)">
                            <option></option>
                            @forelse ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @empty
                                <option>{{ __('text.no_data_available') }}</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                    <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}</label>
                    <div class="">
                        <select class="form-control text-primary"  name="level" required id="cplevels">
                            <option></option>
                            @foreach ($levels as $lvl)
                                <option value="{{ $lvl->level }}" {{ $application->level == $lvl->level ? 'selected' : '' }}>{{ $lvl->level }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                        
                <div class="col-sm-12 col-md-12 col-lg-12 py-4 mt-5 d-flex justify-content-center text-uppercase">
                    <button type="submit" class="px-4 py-1 btn btn-lg btn-primary text-uppercase">{{ __('text.word_update') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>

        $(document).ready(function(){
            if("{{ $application->level }}" != null){
                setLevels("{{ $application->program_first_choice }}");
            }
        });

        let loadCplevels = function(event){
            campus_id = "{{ $application->campus_id }}";
            program_id = event.target.value;
            setLevels(program_id);
        }

        let setLevels = function(program_id){
            campus_id = "{{ $application->campus_id }}";
            _url = "{{ route('admin.campus.program.levels', ['__CmpID__', '__PrgID__']) }}".replace('__CmpID__', campus_id).replace('__PrgID__', program_id);
            console.log(_url);
            $.ajax({
                method : 'GET', url : _url, 
                success : function(data){
                    console.log(data);
                    let html = `<option></option>`;
                    data.forEach(element=>{
                        html += `<option value="${element.level}" ${ "{{ $application->level }}" == element.level ? 'selected' : ''}>${element.level}</option>`;
                    });
                    $('#cplevels').html(html);
                }
            });
        }

    </script>
@endsection

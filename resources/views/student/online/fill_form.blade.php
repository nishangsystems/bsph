@extends('student.layout')
@php
$___year = intval(now()->format('Y'));
$ol_key = time().random_int(1000, 1099);
$al_key = time().random_int(2000, 2099);
$em_key = time().random_int(3000, 3099);
@endphp
@section('section')

    <div class="py-4">
        @switch($step)
            @case(0)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [1, $application->id]) }}">
                    @csrf
                    <div class="px-5 py-5 border-top shadow bg-light">
                        <div class="row w-100">
                            <input type="hidden" name="campus_id" value="{{ $campuses[0]->id }}">
                            <div class="col-sm-12 col-md-12">
                                <label class="text-capitalize"><span style="font-weight: 700;">{{ __('text.applying_for_phrase') }}</span><i class="text-danger text-xs">*</i></label>
                                <select name="degree_id" class="form-control text-primary"  id="degree_types">  
                                    @if($application->degree_id != null)
                                                                                    
                                    @endif                                  
                                </select>
                            </div>
                        </div>
                        <div class="pt-5 d-flex justify-content-center">
                            <button type="submit" class="px-5 py-1 btn btn-lg btn-primary" onclick="event.preventDefault(); confirm('Are you sure the selected degree type is OK?') ? ($('#application_form').submit()) : null">{{ __('text.new_application') }}</button>
                        </div>
                    </div>
                </form>
                @break

            @case('18')
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [1, $application->id]) }}">
                    @csrf
                    <div class="px-5 py-5 border-top shadow bg-light" style="font-size: 2rem; font-weight: 700;">
                        <a class="text-uppercase d-block w-100 alert-primary text-center py-5 border">
                            Applying for {{ $application->type }} in {{ $application->campus }} campus
                        </a>
                        <div class="pt-5 d-flex justify-content-center text-uppercase">
                            <a href="{{ url()->previous() }}" class="px-5 py-2 btn btn-lg btn-danger mx-3" >{{ __('text.word_back') }}</a>
                            <a href="" class="px-5 py-2 btn btn-lg btn-primary mx-3" onclick="confirm('Are you sure you are applying for  BACHELOR  Program?') ? (window.location=`{{ route('student.application.start', [1, $application->id]) }}`) : null">{{ __('text.word_continue') }}</a>
                        </div>
                    </div>
                </form>
                @break

            @case(1)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [2, $application->id]) }}">
                    @csrf
                    <div class="py-2 row border-top border-x">
                        <div style="display: flex; justify-content: end; padding-block: 0.3rem; padding-inline: 0.7rem;" class="col-12">
                            <a href="{{ route('student.application.start', ['id'=>$application->id, 'step'=>6]) }}" class="btn btn-danger px-4 text-capitalize">@lang('text.change_payment_method')</a>
                        </div>
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 1: {{ __('text.personal_details_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        <div class="py-2 col-sm-5 col-md-4 col-md-3 col-xl-3">
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="first_name" value="{{ old('first_name', $application->firstName()) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.first_name_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-7 col-md-5 col-xl-4">
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="other_names" value="{{ old('other_names', $application->otherNames()) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.middle_and_last_name') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-5 col-md-4 col-xl-2">
                            <div class="">
                                <select class="form-control text-primary"  name="gender" required>
                                    <option value="male" {{ old('gender', $application->gender) == 'male' ? 'selected' : '' }}>{{ __('text.word_male') }}</option>
                                    <option value="female" {{ old('gender', $application->gender) == 'female' ? 'selected' : '' }}>{{ __('text.word_female') }}</option>
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_gender_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-7 col-md-3 col-xl-3">
                            <div class="">
                                <input type="date" class="form-control text-primary"  name="dob" value="{{ old('dob', $application->dob?->format('Y-m-d')??null) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_birth_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-7 col-md-5 col-xl-4">
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="pob" value="{{ old('pob', $application->pob) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_birth_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-5 col-md-4 col-xl-2">
                            <div class="">
                                <select class="form-control text-primary"  name="marital_status">
                                    <option value=""></option>
                                    <option value="single" {{ old('marital_status', $application->marital_status) == 'single' ? 'selected' : '' }}>single</option>
                                    <option value="married" {{ old('marital_status', $application->marital_status) == 'married' ? 'selected' : '' }}>married</option>
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.marital_status') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="nationality" required>
                                    <option value=""></option>
                                    @foreach(config('all_countries.list') as $key=>$value)
                                        <option value="{{ $value['name'] }}" {{ old('nationality', $application->nationality) == $value['name'] ? 'selected' : ($value['name'] == 'Cameroon' ? 'selected' : '') }}>{{ $value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_nationality_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="region" required oninput="loadDivisions(event)">
                                    <option value=""></option>
                                    @foreach(\App\Models\Region::all() as $value)
                                        <option value="{{ $value->id }}" {{ old('region', $application->region) == $value->id ? 'selected' : '' }}>{{ $value->region }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <div class="">
                                <select class="form-control text-primary"  name="division" required id="divisions">
                                    <option value=""></option>
                                    @if($application->division != null)
                                        <option value="{{ $application->_division->id }}" selected>{{ $application->_division->name??'' }}</option>
                                    @endif
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_division') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-4">
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="residence" value="{{ old('residence', $application->residence) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.permanent_address_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div>
                                <input type="tel" class="form-control text-primary"  name="phone_2" value="{{ old('phone_2', $application->phone_2) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }} (@lang('text.word_whatsapp'))</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div>
                                <input type="tel" class="form-control text-primary"  name="phone" value="{{ old('phone', $application->phone) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        
                        <input type="hidden" name="campus_id" value="{{ $application->campus_id }}">
                        
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <input class="form-control text-primary"  name="id_number" value="{{ old('id_number', $application->id_number) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.id_slash_passport_number') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        
                        <div class="py-2 col-sm-6 col-md-4 col-xl-4">
                            <div class="">
                                <input type="text" class="form-control text-primary" required name="id_place_of_issue" value="{{ old('id_place_of_issue', $application->id_place_of_issue) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_issue') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <input type="date" class="form-control text-primary" required name="id_date_of_issue" value="{{ old('id_date_of_issue', $application->id_date_of_issue) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_issue') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <div class="">
                                <input type="date" class="form-control text-primary" required name="id_expiry_date" value="{{ old('id_expiry_date', $application->id_expiry_date) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.expiry_date') }}<i class="text-danger text-xs">*</i></label>
                        </div>

                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div>
                                <input type="email" class="form-control text-primary" name="email" value="{{ old('email', $application->email) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_email') }}<i class="text-danger text-xs">*</i></label>
                        </div>

                        <div class="py-2 col-sm-6 col-md-4 col-xl-4">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 px-1 container-fluid">
                                    <select name="" id="" class="form-control rounded" onchange="toggleDisability(this)" required>
                                        <option value=""></option>
                                        <option value="YES" {{ strlen(old('disability', $application->disability??'')) > 0 ? 'selected' : '' }}>YES</option>
                                        <option value="NONE" {{ strlen(old('disability', $application->disability??'')) == 0 ? 'selected' : '' }}>NONE</option>
                                    </select>
                                </div>
                                <div class="col-sm-7 col-md-7 col-lg-7">
                                    <input type="text" class="form-control text-primary" name="disability" {{ strlen(old('disability', $application->disability??'')) > 0 ? '' : 'readonly' }}  value="{{ old('disability', $application->disability) }}" id="disability" required>
                                </div>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_disability') }}<i class="text-danger text-xs">*(select <b>None</b> if none)</i></label>
                        </div>

                        <div class="py-2 col-sm-6 col-md-5 col-xl-4">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 px-1 container-fluid">
                                    <select name="" id="" class="form-control rounded" onchange="toggleHealthCondition(this)" required>
                                        <option value=""></option>
                                        <option value="YES" {{ strlen(old('health_condition', $application->health_condition??'')) > 0 ? 'selected' : '' }}>YES</option>
                                        <option value="NONE" {{ strlen(old('health_condition', $application->health_condition??'')) == 0 ? 'selected' : '' }}>NONE</option>
                                    </select>
                                </div>
                                <div class="col-sm-7 col-md-7 col-lg-7">
                                    <input type="text" class="form-control text-primary" {{ strlen(old('health_condition', $application->health_condition??'')) > 0 ? '' : 'readonly' }} name="health_condition" id="health_condition" value="{{ old('health_condition', $application->health_condition) }}" required>
                                </div>
                            </div>
                            <label class="text-secondary text-capitalize">{{ __('text.health_condition') }}<i class="text-danger text-xs">*(select <b>None</b> if none)</i></label>
                        </div>


                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;"> {{ __('text.emergency_contact_details') }} </h4>
                        
                        <div class="col-sm-12 col-md-6 col-xl-5">
                            <div class="">
                                <input class="form-control text-primary" required name="emergency_name" value="{{ old('emergency_name', $application->emergency_name??'') }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_name_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="">
                                <input class="form-control text-primary" required name="emergency_address" value="{{ old('emergency_address', $application->emergency_address??'') }}">
                            </div>
                            <label class=" text-secondary text-capitalize">{{ __('text.emergency_address_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <input class="form-control text-primary" required name="emergency_tel" required value="{{ old('emergency_tel', $application->emergency_tel??'') }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_tel_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <input class="form-control text-primary" type="email" name="emergency_email" value="{{ old('emergency_email', $application->emergency_email??'') }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_email') }} (optional)</label>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="emergency_personality" required>
                                    <option value=""></option>
                                    <option value="PARENT" {{ old('emergency_personality', $application->emergency_personality??'') == 'PARENT' ? 'selected' : '' }}>PARENT</option>
                                    <option value="SPOUSE" {{ old('emergency_personality', $application->emergency_personality??'') == 'SPOUSE' ? 'selected' : '' }}>SPOUSE</option>
                                    <option value="FRIEND" {{ old('emergency_personality', $application->emergency_personality??'') == 'FRIEND' ? 'selected' : ''}}>FRIEND</option>
                                    <option value="RELATIVE" {{ old('emergency_personality', $application->emergency_personality??'') == 'RELATIVE' ? 'selected' : '' }}>RELATIVE</option>
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_relationship') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break
        
            @case(2)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [ 3, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        

                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;"> {{ __('text.degree_slash_diploma_study_choice') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="program_first_choice" required oninput="loadCplevels(event)">
                                    <option value="">{{ __('text.select_program') }}</option>
                                    @foreach (collect($programs)->where('appliable', 1)->sortBy('name') as $program)
                                        <option value="{{ $program->id }}" {{ old('program_first_choice', $application->program_first_choice) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.first_choice_bilang') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="program_second_choice">
                                    <option value="">{{ __('text.select_program') }}</option>
                                    @foreach ($all_programs->where('appliable', 1) as $program)
                                        <option value="{{ $program->id }}" {{ old('program_second_choice', $application->program_second_choice) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="program_third_choice">
                                    <option value="">{{ __('text.select_program') }}</option>
                                    @foreach ($all_programs->where('appliable', 1) as $program)
                                        <option value="{{ $program->id }}" {{ old('program_third_choice', $application->program_third_choice) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class=" text-secondary text-capitalize">{{ __('text.third_choice') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-3 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="level" required id="cplevels">
                                    
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        
                        <div class="py-2 col-sm-6 col-md-6 col-xl-12">
                            <div class="">
                                <input rows="2" class="form-control rounded" max="250" name="enrollment_purpose" value="{{ old('enrollment_purpose', $application->enrollment_purpose) }}" required>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.enrollment_purpose_phrase') }}<i class="text-danger text-xs">*</i></label>
                        </div>

                        <div class="py-2 col-sm-6 col-md-3 col-xl-2">
                            <div class="">
                                <select class="form-control text-primary" required onchange="set_payment_channel(this)" id="" name="fee_payment_channel">
                                    <option value=""></option>
                                    {{-- <option value="MOMO" data-action="" {{ $application->payment_method == "MOMO" ? 'selected' : '' }}>MOMO</option> --}}
                                    <option value="CBCHS Station" data-action="" {{ $application->payment_method == "CBCHS" ? 'selected' : '' }}>CBCHS Station</option>
                                    <option value="Bank payment" data-action="" {{ $application->payment_method == "BANK" ? 'selected' : '' }}>Bank payment</option>
                                    <option value="School Bursary" data-action="" {{ $application->payment_method == "BURSARY" ? 'selected' : '' }}>School Bursary</option>
                                    <option value="Others" {{ $application->payment_method == "OTHER" ? 'selected' : '' }} data-action="specify">Others? (Specify)</option>
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}?<i class="text-danger text-xs">*</i></label>
                        </div>
{{-- 
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <input type="text" name="fee_payment_channel" value="{{ old('fee_payment_channel', $application->fee_payment_channel??'') }}" class="form-control text-primary" required {{ $application->payment_method == "OTHER" ? '' : 'readonly' }} id="payment_channel">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}?<i class="text-danger text-xs">*</i></label>
                        </div> --}}

                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <div class="">
                                <select class="form-control text-primary"  name="info_source" required onchange="source_identity(this)" id="info_source">
                                    <option value=""></option>
                                    <option value="BSPH Website" {{ old('info_source', $application->info_source) == "BSPH Website" ? 'selected' : '' }} data-action="">BSPH WEBSITE</option>
                                    <option value="CBC Website" {{ old('info_source', $application->info_source) == "CBC Website" ? 'selected' : '' }} data-action="">CBC Website</option>
                                    <option value="School Marketing Officer" {{ old('info_source', $application->info_source) == "School Marketing Officer" ? 'selected' : '' }} data-action="">School Marketing Officer</option>
                                    <option value="BSPH student" {{ old('info_source', $application->info_source) == "BSPH student" ? 'selected' : '' }} data-action="specify" data-hint="student name">BSPH Student (Specify)</option>
                                    <option value="BSPH advert" {{ old('info_source', $application->info_source) == "BSPH advert" ? 'selected' : '' }} data-action="">BSPH Advert (Flyers, posters, billboard)</option>
                                    <option value="BSPH Social Media" {{ old('info_source', $application->info_source) == "BSPH Social Media" ? 'selected' : '' }} data-action="specify" data-hint="which media">BSPH Social Media (Specify)</option>
                                    <option value="BSPH outdoor marketing" {{ old('info_source', $application->info_source) == "BSPH outdoor marketing" ? 'selected' : '' }} data-action="">BSPH outdoor marketing (visit to school, social gathering, sporting activities)</option>
                                    <option value="Others" data-action="specify" data-hint="which individaul/gathering you got information from">Others (church, name of person/number, ...) (specify)</option>
                                </select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.information_source_phrase') }}<i class="text-danger text-xs">*</i></label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-4" id="source_identity">
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="info_source_identity" value="{{ old('info_source_identity', $application->info_source_identity) }}">
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.specify_information_source') }}</label>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break

            @case(4)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [5, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 4: {{ __('text.odinary_and_or_advanced_level_results_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-2 px-2">
                            <div class="py-2 border card px-2">
                                <h5 style="text-transform: uppercase; font-weight: 700; margin-bottom: 2rem;" class="text-primary text-center">@lang('text.ordinary_level_results')</h5>
                                <span class="text-center text-danger"><b>Subject and Grade for General Education. Subject, Coef & Note*Coef for Technical Education</b></span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="ol_center_number" class="form-control" value="{{ $application->ol_center_number }}" required>
                                        <small class="text-danger"><i>@lang('text.center_no')</i>*</small>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="ol_candidate_number" class="form-control" value="{{ $application->ol_candidate_number }}" required>
                                        <small class="text-danger"><i>@lang('text.candidate_no')</i>*</small>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        @php
                                            $this_year = intval(now()->format('Y'));
                                        @endphp
                                        <select name="ol_year" required class="form-control" id="">
                                            <option value="">@lang('text.academic_year')</option>
                                            @for($i = $this_year-25; $i <= $this_year; $i++)
                                                @php
                                                    $yr = ($i-1).'/'.$i;
                                                @endphp
                                                <option value="{{ $yr }}" {{ $yr == old('ol_year', $application->ol_year) ? 'selected' : '' }}>{{ $yr }}</option>
                                            @endfor
                                        </select>
                                        <small class="text-danger"><i>@lang('text.word_year')</i>*</small>
                                    </div>
                                </div>
                                
                                <table class="table table-light" style="table-layout:fixed; max-width:inherit;">
                                    <div id="ol_results">
                                        @php $counter = 1; @endphp
                                        @foreach (json_decode($application->ol_results)??[] as $_result)
                                            @php
                                                $ol_key++;
                                                $counter++
                                            @endphp
                                            <div class="text-capitalize container-fluid row py-3">
                                                <div class="col-sm-7 col-md-4 col-xl-4">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" required value="{{ $_result->subject }}">
                                                    <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <select class="form-control text-primary"  name="ol_results[{{ $ol_key }}][grade]">
                                                        <option value=""></option>
                                                        <option value="A" {{ $_result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                        <option value="B" {{ $_result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                        <option value="C" {{ $_result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                        <option value="D" {{ $_result->grade == 'D' ? 'selected' : '' }}>D</option>
                                                        <option value="E" {{ $_result->grade == 'E' ? 'selected' : '' }}>E</option>
                                                        <option value="U" {{ $_result->grade == 'U' ? 'selected' : '' }}>U</option>
                                                    </select>
                                                    <span>@lang('text.word_grade')</span>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][coef]" value="{{ $_result->coef??'' }}">
                                                    <span>COEF</span>
                                                </div>
                                                <div class="col-sm-6 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][nc]" value="{{ $_result->nc??'' }}">
                                                    <span>NOTE * COEF</span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @while ($counter <= 2)
                                            @php
                                                $ol_key++;
                                                $counter++
                                            @endphp
                                            <div class="text-capitalize container-fluid row py-3">
                                                <div class="col-sm-7 col-md-4 col-xl-4">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" required>
                                                    <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <select class="form-control text-primary"  name="ol_results[{{ $ol_key }}][grade]">
                                                        <option value=""></option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                        <option value="U">U</option>
                                                    </select>
                                                    <span>@lang('text.word_grade')</span>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][coef]">
                                                    <span>COEF</span>
                                                </div>
                                                <div class="col-sm-6 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][nc]">
                                                    <span>NOTE * COEF</span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                                                </div>
                                            </div>
                                        @endwhile
                                    </div>
                                    <hr>
                                    <div class="text-capitalize">
                                        <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-end h5"><span class="btn btn-sm btn-primary rounded" onclick="addOLResult()">add</span> </h5>
                                    </div>
                                </table>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-center py-4">
                                <span class="btn btn-primary text-uppercase px-3 rounded" onclick="toggleALResults()">ADD ADVANCED LEVEL RESULTS</span>
                            </div>
                            <div class="py-2 border card px-2 {{ $application->al_results == null ? 'hidden' : '' }}" id="al_toggle_view">
                                <h5 style="text-transform: uppercase; font-weight: 700; margin-bottom: 2rem;" class="text-primary text-center">@lang('text.advanced_level_results')</h5>
                                <span class="text-center text-danger"><b>Subject and Grade for General Education. Subject, Coef & Note*Coef for Technical Education</b></span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="al_center_number" class="form-control" value="{{ $application->al_center_number }}" required>
                                        <small class="text-danger"><i>@lang('text.center_no')</i>*</small>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <input type="text" name="al_candidate_number" class="form-control" value="{{ $application->al_candidate_number }}" required>
                                        <small class="text-danger"><i>@lang('text.candidate_no')</i>*</small>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        @php
                                            $this_year = intval(now()->format('Y'));
                                        @endphp
                                        <select name="al_year" required class="form-control" id="">
                                            <option value="">@lang('text.academic_year')</option>
                                            @for($i = $this_year-25; $i <= $this_year; $i++)
                                                @php
                                                    $yr = ($i-1).'/'.$i;
                                                @endphp
                                                <option value="{{ $yr }}" {{ $yr == old('al_year', $application->al_year) ? 'selected' : '' }}>{{ $yr }}</option>
                                            @endfor
                                        </select>
                                        <small class="text-danger"><i>@lang('text.word_year')</i>*</small>
                                    </div>
                                </div>
                                
                                <table class="table table-light" style="table-layout:fixed; max-width:inherit;">
                                    <div id="al_results">
                                        @php $counter = 1; @endphp
                                        @foreach (json_decode($application->al_results)??[] as $_result)
                                            @php
                                                $ol_key++;
                                                $counter++
                                            @endphp
                                            <div class="text-capitalize container-fluid row py-3">
                                                <div class="col-sm-7 col-md-4 col-xl-4">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" required value="{{ $_result->subject }}">
                                                    <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <select class="form-control text-primary"  name="al_results[{{ $al_key++ }}][grade]">
                                                        <option value=""></option>
                                                        <option value="A" {{ $_result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                        <option value="B" {{ $_result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                        <option value="C" {{ $_result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                        <option value="D" {{ $_result->grade == 'D' ? 'selected' : '' }}>D</option>
                                                        <option value="E" {{ $_result->grade == 'E' ? 'selected' : '' }}>E</option>
                                                        <option value="O" {{ $_result->grade == 'O' ? 'selected' : '' }}>O</option>
                                                        <option value="F" {{ $_result->grade == 'F' ? 'selected' : '' }}>F</option>
                                                    </select>
                                                    <span>@lang('text.word_grade')</span>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][coef]" value="{{ $_result->coef??'' }}">
                                                    <span>COEF</span>
                                                </div>
                                                <div class="col-sm-6 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][nc]" value="{{ $_result->nc??'' }}">
                                                    <span>NOTE * COEF</span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropALResult(event)">{{ __('text.word_drop') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @while ($counter <= 2)
                                            @php
                                                $al_key++;
                                                $counter++
                                            @endphp
                                            <div class="text-capitalize container-fluid row py-3">
                                                <div class="col-sm-7 col-md-4 col-xl-4">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" required>
                                                    <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <select class="form-control text-primary"  name="al_results[{{ $al_key++ }}][grade]">
                                                        <option value=""></option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                        <option value="E">O</option>
                                                        <option value="F">F</option>
                                                    </select>
                                                    <span>@lang('text.word_grade')</span>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][coef]">
                                                    <span>COEF</span>
                                                </div>
                                                <div class="col-sm-6 col-md-2 col-xl-2">
                                                    <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][nc]">
                                                    <span>NOTE * COEF</span>
                                                </div>
                                                <div class="col-sm-3 col-md-2 col-xl-2">
                                                    <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropALResult(event)">{{ __('text.word_drop') }}</span>
                                                </div>
                                            </div>
                                        @endwhile
                                    </div>
                                    <hr>
                                    <div class="text-capitalize">
                                        <h5 class="text-dark font-weight-semibold text-uppercase text-center h5"><span class="btn btn-sm btn-primary rounded" onclick="addALResult()">add</span> </h5>
                                    </div>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break
        

            @case(3)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [4, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;">{{ __('text.word_stage') }} 3: {{ __('text.schools_attended') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            
                            <div class="card my-1">
                                <div class="card-body container-fluid">
                                    <h5 class="font-weight-bold text-capitalize text-center h4">{{ __('text.schools_attended') }} (OL, AL, Diploma)</h5>
                                    <table class="table table-light" style="table-layout:fixed; max-width:inherit;">
                                        <div id="schools_attended">
                                            @php $counter = 1; @endphp
                                            @foreach (json_decode($application->schools_attended)??[] as $_result)
                                                @php
                                                    $al_key++;
                                                    $counter++
                                                @endphp
                                                <div class="text-capitalize row py-3 rounded shadow">
                                                    <div class="col-sm-7 col-md-6 col-xl-3">
                                                        <input type="text" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][school]" required value="{{ $_result->school }}">
                                                        <span>@lang('text.word_school')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-5 col-md-3 col-xl-2">
                                                        <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_from]" required value="{{ $_result->date_from }}">
                                                        <span>@lang('text.date_from')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-4 col-md-3 col-xl-2">
                                                        <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_to]" required value="{{ $_result->date_to }}">
                                                        <span>@lang('text.date_to')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-5 col-md-6 col-xl-3">
                                                        <select name="schools_attended[{{ $al_key }}][qualification]" required class="form-control text-primary">
                                                            <option value=""></option>
                                                            <option value="GCE OL" {{ $_result->qualification == 'GCE OL' ? 'selected' : '' }}>GCE OL</option>
                                                            <option value="GCE AL" {{ $_result->qualification == 'GCE AL' ? 'selected' : '' }}>GCE AL</option>
                                                            <option value="FSLC" {{ $_result->qualification == 'FSLC' ? 'selected' : '' }}>FSLC</option>
                                                            <option value="CAP" {{ $_result->qualification == 'CAP' ? 'selected' : '' }}>CAP</option>
                                                            <option value="BACC" {{ $_result->qualification == 'BACC' ? 'selected' : '' }}>BACC</option>
                                                            <option value="PROBATOIRE" {{ $_result->qualification == 'PROBATOIRE' ? 'selected' : '' }}>PROBATOIRE</option>
                                                            <option value="DIPLOMA" {{ $_result->qualification == 'DIPLOMA' ? 'selected' : '' }}>DIPLOMA</option>
                                                            <option value="HND" {{ $_result->qualification == 'HND' ? 'selected' : '' }}>HND</option>
                                                            <option value="Bachelors" {{ $_result->qualification == 'Bachelors' ? 'selected' : '' }}>Bachelors</option>
                                                        </select>
                                                        <span>@lang('text.word_qualification')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-3 col-md-6 col-xl-2"><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropSchoolAttended(event)">{{ __('text.word_drop') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @while ($counter <= 2)
                                                @php
                                                    $al_key++;
                                                    $counter++
                                                @endphp
                                                <div class="text-capitalize row py-3 rounded shadow">
                                                    <div class="col-sm-7 col-md-6 col-xl-3">
                                                        <input type="text" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][school]" required>
                                                        <span>@lang('text.word_school')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-5 col-md-3 col-xl-2">
                                                        <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_from]" required>
                                                        <span>@lang('text.date_from')<i class="text-danger text-xs">*</i></span> 
                                                    </div>
                                                    <div class="col-sm-4 col-md-3 col-xl-2">
                                                        <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_to]" required>
                                                        <span>@lang('text.date_to')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-5 col-md-6 col-xl-3">
                                                        <select name="schools_attended[{{ $al_key }}][qualification]" required class="form-control text-primary">
                                                            <option value=""></option>
                                                            <option value="GCE OL">GCE OL</option>
                                                            <option value="GCE AL">GCE AL</option>
                                                            <option value="FSLC">FSLC</option>
                                                            <option value="CAP">CAP</option>
                                                            <option value="BACC">BACC</option>
                                                            <option value="PROBATOIRE">PROBATOIRE</option>
                                                            <option value="DIPLOMA">DIPLOMA</option>
                                                            <option value="HND">HND</option>
                                                            <option value="Bachelors">Bachelors</option>
                                                        </select>
                                                        <span>@lang('text.word_qualification')<i class="text-danger text-xs">*</i></span>
                                                    </div>
                                                    <div class="col-sm-3 col-md-6 col-xl-2"><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropSchoolAttended(event)">{{ __('text.word_drop') }}</span>
                                                    </div>
                                                </div>
                                            @endwhile
                                        </div>
                                        <hr>
                                        <div class="text-capitalize">
                                            <h5 class="text-dark font-weight-semibold text-uppercase text-center h5"><span class="btn btn-sm btn-primary rounded" onclick="addSchoolAttended()">add</span> </h5>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break

            @case(5)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [6.5, $application->id]) }}">
                    @csrf
                    <div class="py-2 row text-capitalize bg-light">
                        <!-- hidden field for submiting application form -->
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 5: {{ __('text.preview_and_submit_form_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        
                        <!-- STAGE 1 PREVIEW -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 1: <a href="{{ route('student.application.start', [1, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.word_edit') }} @lang('text.personal_details')</a></h4>
                        <div class="py-2 col-sm-6 col-md-3 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->firstName() }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.first_name') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->otherNames() }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">@lang('text.middle_and_last_name')</label>
                        </div>
                        <div class="py-2 col-sm-3 col-md-3 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->gender ?? '' }}</select>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_gender_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-3 col-md-2 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->dob->format('dS M Y') ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_birth_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->pob ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_birth_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->nationality ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_nationality_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->_region->region ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->_division->name ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_division') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->marital_status ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.marital_status') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->phone ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->phone_2 ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.phone_number') }} ({{ __('text.word_whatsapp') }})</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->email ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_email_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->residence ?? '' }}<label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_residence_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $campus->name ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_campus') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->id_number ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.id_slash_passport_number') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->id_place_of_issue ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_issue') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->id_date_of_issue ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_issue') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->id_expiry_date ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.expiry_date') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->disability ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_disability') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->health_condition ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.health_condition') }}</label>
                        </div>
                        <div class="col-12"><hr></div>
                        
                        <div class="py-2 col-sm-6 col-md-4 col-lg-5">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->emergency_name ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_name') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->emergency_address ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_address') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->emergency_tel ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_tel') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->emergency_email ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_email') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->emergency_personality ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_relationship') }}</label>
                        </div>


                        <!-- STAGE 2 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 2: <a href="{{ route('student.application.start', [2, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.word_edit') }} @lang('text.program_details')</a></h4>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $program1->name ?? '' }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.first_choice_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $program2->name ?? '' }}</label>
                            </div>
                            <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $program3->name ?? '' }}</label>
                            </div>
                            <label class=" text-secondary text-capitalize">{{ __('text.third_choice_bilang') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->level ?? null }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->enrollment_purpose ?? null }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.life_purse_of_enrollment') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->fee_payment_channel ?? null }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->info_source ?? null }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.information_source') }}</label>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->info_source_identity ?? null }}</label>
                            </div>
                            <label class="text-secondary  text-capitalize">{{ __('text.specify_information_source') }}</label>
                        </div>

                        <!-- STAGE 3 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 3: <a href="{{ route('student.application.start', [3, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.word_edit') }} @lang('text.schools_attended')</a></h4>
                        <h4 class="py-3 border-bottom border-top bg-white text-dark my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;"> {{ __('text.schools_attended') }}</h4>
                        <div class="border my-4 container-fluid">
                            @foreach (json_decode($application->schools_attended)??[] as $key=>$training)
                                <div class="text-capitalize row py-3 border-bottom border-dark">
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <label class="form-control text-primary border-0">{{ $training->school ?? '' }}</label>
                                        <span class="text-secondary">@lang('text.word_school')</span>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <label class="form-control text-primary border-0">{{ now()->parse($training->date_from ?? '')->format('M Y') }}</label>
                                        <span class="text-secondary">@lang('text.date_from')</span>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <label class="form-control text-primary border-0">{{ now()->parse($training->date_to ?? '')->format('M Y') }}</label>
                                        <span class="text-secondary">@lang('text.date_to')</span>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        <label class="form-control text-primary border-0">{{ $training->qualification ?? '' }}</label>
                                        <span class="text-secondary">@lang('text.word_qualification')</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- STAGE 4 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 4: <a href="{{ route('student.application.start', [4, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.word_edit') }} @lang('text.word_results')</a></h4>
                        <div class="container-fluid my-4 row">
                            <div class="col-lg-6 col-xl-6 ">
                                <div class="container-fluid card">
                                    <h6 class="text-center text-uppercase text-primary"><b>@lang('text.ordinary_level_results')</b></h6>
                                    <hr>
                                    <div class="row container-fluid">
                                        <div class="col-4">
                                            <label class="form-control border-light">{{ $application->ol_center_number }}</label>
                                            <small class="text-info"><i>@lang('text.center_no')</i></small>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-control border-light">{{ $application->ol_candidate_number }}</label>
                                            <small class="text-info"><i>@lang('text.candidate_no')</i></small>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-control border-light">{{ $application->ol_year }}</label>
                                            <small class="text-info"><i>@lang('text.word_year')</i></small>
                                        </div>
                                    </div>
                                    @foreach (json_decode($application->ol_results)??[] as $key=>$res)
                                        <div class="text-capitalize row py-3 border-bottom border-dark">
                                            <div class="col-sm-4 px-2">
                                                <label class="form-control rounded text-primary border-light">{{ $res->subject ?? '' }}</label>
                                                <span class="text-secondary">{{ trans_choice('text.word_subject', 1) }}</span>
                                            </div>
                                            <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->grade??'' }}</label>
                                                <span class="text-secondary">@lang('text.word_grade')</span>
                                            </div>
                                            <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->coef??'' }}</label>
                                                <span class="text-secondary">COEF</span>
                                            </div>
                                            <div class="col-sm-3 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->nc??'' }}</label>
                                                <span class="text-secondary">NOTE * COEF</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6 ">
                                <div class="container-fluid card">
                                    <h6 class="text-center text-uppercase text-primary"><b>@lang('text.advanced_level_results')</b></h6>
                                    <hr>
                                    <div class="row container-fluid">
                                        <div class="col-4">
                                            <label class="form-control border-light">{{ $application->al_center_number }}</label>
                                            <small class="text-info"><i>@lang('text.center_no')</i></small>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-control border-light">{{ $application->al_candidate_number }}</label>
                                            <small class="text-info"><i>@lang('text.candidate_no')</i></small>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-control border-light">{{ $application->al_year }}</label>
                                            <small class="text-info"><i>@lang('text.word_year')</i></small>
                                        </div>
                                    </div>
                                    @foreach (json_decode($application->al_results)??[] as $key=>$res)
                                        <div class="text-capitalize row py-3 border-bottom border-dark">
                                            <div class="col-sm-4 px-2">
                                                <label class="form-control rounded text-primary border-light">{{ $res->subject ?? '' }}</label>
                                                <span class="text-secondary">{{ trans_choice('text.word_subject', 1) }}</span>
                                            </div>
                                            <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->grade??'' }}</label>
                                                <span class="text-secondary">@lang('text.word_grade')</span>
                                            </div>
                                            <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->coef??'' }}</label>
                                                <span class="text-secondary">COEF</span>
                                            </div>
                                            <div class="col-sm-3 px-2" style="overflow-x: hidden;">
                                                <label class="form-control rounded text-primary border-light">{{ $res->nc??'' }}</label>
                                                <span class="text-secondary">NOTE * COEF</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 mt-5 d-flex justify-content-center text-uppercase">
                            <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            {{-- <a href="{{ route('student.home') }}" class="px-4 py-1 btn btn-lg btn-success">{{ __('text.pay_later') }}</a> --}}
                            @if(!$application->is_filled())<button type="submit" class="px-4 py-1 btn btn-lg btn-primary text-uppercase">{{ __('text.word_submit') }}</button>@endif
                        </div>
                    </div>
                </form>
                @break

            @case(6)
            @case(6.5)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [7, $application->id]) }}">
                    @csrf
                    <hr>
                    <div class="py-2 row">
                        
                        @if($step == 6.5)
                            <div class="col-sm-12 col-md-12 col-lg-12 d-flex">
                                <div class="col-sm-10 col-md-8 col-lg-6 rounded bg-white py-5 my-3 shadow mx-auto">
                                    {{-- @if ($application->payment_method == 'MOMO')
                                        <div class="container-fluid">
                                            <div class="py-4 text-info text-center ">You are about to make a payment of {{ $degree->amount }} CFA for application fee
                                            </div>
                                            <div class="py-3">
                                                <label class="text-secondary text-capitalize">{{ __('text.momo_number_used_in_payment') }} (<span class="text-danger">{{ __('text.without_country_code') }}</span>)</label>
                                                <div class="">
                                                    <input type="tel" class="form-control text-primary"  name="momo_number" value="{{ $application->momo_number }}">
                                                </div>
                                            </div>
                                            <div class="py-3">
                                                <label class="text-secondary text-capitalize">{{ __('text.word_amount') }} </label>
                                                <div class="">
                                                    <input readonly type="text" class="form-control text-primary"  name="amount" value="{{ $degree->amount }}">
                                                </div>
                                            </div>
                                        </div>
                                    @else --}}
                                        <div class="container-fluid">
                                            <div class="card py-3">
                                                <div class="card-header bg-white">
                                                    <h5 class="text-center text-primary text-uppercase"><b>Uplaod a proof of payment</b></h5>
                                                </div>
                                                <div class="card-body">
                                                    <p><b class="text-center">A clear photo of the payment receipt (From Bank, CBCHS Stattion, Bursary, ...)</b> </p>
                                                    <div class="py-4">
                                                        <input type="text" readonly value="{{ $application->payment_method }}" class="form-control">
                                                        <span class="text-dark"><b>@lang('text.payment_method')</b></span>
                                                    </div>
                                                    <div class="py-4">
                                                        <input type="file" name="payment_proof" accept="image/*" class="form-control" id="" required>
                                                        <span class="text-dark"><b>@lang('text.word_photo')</></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- @endif --}}
                                    <div class="py-5 d-flex justify-content-center">
                                        <a href="{{ url()->previous() }}" class="px-4 py-1 btn btn-xs btn-danger">{{ __('text.word_back') }}</a>
                                        <input type="submit" class="px-4 py-1 btn btn-xs btn-primary" value="{{ __('text.save_and_continue') }}">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-12 col-md-8">
                                <select name="payment_method" class="form-control" id="">
                                    <option value=""></option>
                                    {{-- <option value="MOMO" {{ $application->payment_method == 'MOMO' ? 'selected' : '' }}>MOMO</option> --}}
                                    <option value="CBCHS" {{ $application->payment_method == 'CBCHS' ? 'selected' : '' }}>CBCHS Station</option>
                                    <option value="BANK" {{ $application->payment_method == 'BANK' ? 'selected' : '' }}>Bank payment</option>
                                    <option value="BURSARY" {{ $application->payment_method == 'BURSARY' ? 'selected' : '' }}>School Bursary</option>
                                    <option value="OTHER"  {{ $application->payment_method == 'OTHER' ? 'selected' : '' }}>Other</option>
                                </select>
                                <small class="text-capitalize text-danger"><i>How do you pay your application fee?</i></small>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <button type="submit" class="form-control btn btn-sm btn-primary">@lang('text.word_save')</button>
                            </div>
                        @endif
                        
                        
                    </div>
                </form>
            @break
        @endswitch
    </div>
@endsection
@section('script')
    <script>

        $(document).ready(function(){
            console.log('{{ $application->region }}');
            if("{{ $application->degree_id }}" != null){
                loadCampusDegrees('{{ $application->campus_id }}');
            }
            if("{{ $application->division }}" != null){
                setDivisions('{{ $application->region }}');
            }
            if("{{ $application->level }}" != null){
                setLevels("{{ $application->program_first_choice }}");
            }

            loadCampusDegrees("{{ $campuses[0]->id }}");
        });
        // momo preview generator
        let momoPreview = function(event){
            let file = event.target.files[0];
            if(file != null){
                let url = URL.createObjectURL(file);
                $('#momo_image_preview').attr('src', url);
            }
        }
        
                
        // Add and drop previous trainings form table rows
        let addOLResult = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<div class="text-capitalize container-fluid row py-3">
                            <div class="col-sm-7 col-md-4 col-xl-4">
                                <input type="text" class="form-control text-primary"  name="ol_results[${key}][subject]" required>
                                <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-3 col-md-2 col-xl-2">
                                <select class="form-control text-primary"  name="ol_results[${key}][grade]">
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="U">U</option>
                                </select>
                                <span>@lang('text.word_grade')</span>
                            </div>
                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <input type="text" class="form-control text-primary"  name="ol_results[${key}][coef]">
                                <span>COEF</span>
                            </div>
                            <div class="col-sm-6 col-md-2 col-xl-2">
                                <input type="text" class="form-control text-primary"  name="ol_results[${key}][nc]">
                                <span>NOTE * COEF</span>
                            </div>
                            <div class="col-sm-3 col-md-2 col-xl-2">
                                <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                            </div>
                        </div>`;
            $('#ol_results').append(html);
        }
       
        // Add and drop previous trainings form table rows
        let addALResult = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<div class="text-capitalize container-fluid row py-3">
                            <div class="col-sm-7 col-md-4 col-xl-4">
                                <input type="text" class="form-control text-primary"  name="al_results[${key}][subject]" required>
                                <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-3 col-md-2 col-xl-2">
                                <select class="form-control text-primary"  name="al_results[${key}][grade]">
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                                    <option value="F">F</option>
                                </select>
                                <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <input type="text" class="form-control text-primary"  name="al_results[${key}][coef]">
                                <span>COEF</span>
                            </div>
                            <div class="col-sm-6 col-md-2 col-xl-2">
                                <input type="text" class="form-control text-primary"  name="al_results[${key}][nc]">
                                <span>NOTE * COEF</span>
                            </div>
                            <div class="col-sm-3 col-md-2 col-xl-2">
                                <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                            </div>
                        </div>`;
            $('#al_results').append(html);
        }
        
        
        let addSchoolAttended = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<div class="text-capitalize row py-3 rounded shadow">
                            <div class="col-sm-7 col-md-6 col-xl-3">
                                <input type="text" class="form-control text-primary"  name="schools_attended[${key}][school]" required>
                                <span>@lang('text.word_school')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-5 col-md-3 col-xl-2">
                                <input type="month" class="form-control text-primary"  name="schools_attended[${key}][date_from]" required>
                                <span>@lang('text.date_from')<i class="text-danger text-xs">*</i></span> 
                            </div>
                            <div class="col-sm-4 col-md-3 col-xl-2">
                                <input type="month" class="form-control text-primary"  name="schools_attended[${key}][date_to]" required>
                                <span>@lang('text.date_to')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-5 col-md-6 col-xl-3">
                                <select name="schools_attended[${key}][qualification]" required class="form-control text-primary">
                                    <option value=""></option>
                                    <option value="GCE OL">GCE OL</option>
                                    <option value="GCE AL">GCE AL</option>
                                    <option value="FSLC">FSLC</option>
                                    <option value="CAP">CAP</option>
                                    <option value="BACC">BACC</option>
                                    <option value="PROBATOIRE">PROBATOIRE</option>
                                    <option value="DIPLOMA">DIPLOMA</option>
                                    <option value="HND">HND</option>
                                    <option value="Bachelors">Bachelors</option>
                                </select>
                                <span>@lang('text.word_qualification')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-3 col-md-6 col-xl-2">
                                <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropSchoolAttended(event)">{{ __('text.word_drop') }}</span>
                            </div>
                        </div>`;
            $('#schools_attended').append(html);
        } 

        let dropALResult = function(event){
            let training = $(event.target).parent().parent();
            // let training = $('#previous_trainings').children().last();
            if(training != null){
                training.remove();
            }
        }

        let dropOLResult = function(event){
            let training = $(event.target).parent().parent();
            // let training = $('#previous_trainings').children().last();
            if(training != null){
                training.remove();
            }
        }

        let dropSchoolAttended = function(event){
            let training = $(event.target).parent().parent();
            // let training = $('#previous_trainings').children().last();
            if(training != null){
                training.remove();
            }
        }
        
        let completeForm = function(){
            let confirmed = confirm('By clicking this button, you are confirming that every information supplied is correct.');
            if(confirmed){
                $('#application_form').submit();
            }
        }

        let setDegreeTypes = function(event){
            let campus = event.target.value;
            loadCampusDegrees(campus);
        }

        let loadCampusDegrees = function(campus){
            url = `{{ route('student.campus.degrees', '__CID__') }}`.replace('__CID__', campus);
            $.ajax({
                method: 'get', url: url,
                success: function(data){
                    console.log(data);
                    let html = `<option></option>`;
                    data.forEach(element => {
                        html+=`<option value="${element.id}" ${ '{{ $application->degree_id }}' == element.id ? 'selected' : '' } >${element.deg_name}</option>`;
                    });
                    $('#degree_types').html(html);
                }
            })
        }

        let loadDivisions = function(event){
            let region = event.target.value;
            console.log("regionregionregion",region);
            setDivisions(region);
        }

        let setDivisions = function(region){
            url = "{{ route('student.region.divisions', '__RID__') }}".replace('__RID__', region);
            console.log("url",url);
            $.ajax({
                method: 'get', url: url, 
                success: function(data){
                    let html = `<option></option>`
                    data.forEach(element => {
                        html+=`<option value="${element.id}" ${'{{ $application->division}}' == element.id ? 'selected' : '' }>${element.name}</option>`.replace('region_id', element.id)
                    });
                    $('#divisions').html(html);
                }
            })
        }

        let campusDegreeCertPorgrams = function(event){
            cert_id = event.target.value;
            campus_id = "{{ $application->campus_id }}";
            degree_id = "{{ $application->degree_id }}";

            url = "{{ route('student.campus.degree.cert.programs', ['__CmpID__', '__DegID__', '__CertID__']) }}".replace('__CmpID__', camus_id).replace('__DegID__').replace('__CertID__');
            $.ajax({
                method: 'get', url: url,
                success: function(data){
                    console.log(data);
                    let html = `<option></option>`;
                    data.forEach(element=>{
                        html += `<option value="${element.id}">${element.certi}</option>`;
                    })

                }
            })
        }

        let loadCplevels = function(event){
            campus_id = "{{ $application->campus_id }}";
            program_id = event.target.value;

            setLevels(program_id);
        }

        let setLevels = function(program_id){

            campus_id = "{{ $application->campus_id }}";

            url = "{{ route('student.campus.program.levels', ['__CmpID__', '__PrgID__']) }}".replace('__CmpID__', campus_id).replace('__PrgID__', program_id);
            $.ajax({
                method : 'get', url : url, 
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

        let source_identity = (element)=>{
            let option_action = $(element).find(':selected').data('action');
            if(option_action == 'specify'){
                //let hint = $(element).find(':selected').data('hint');
                //$('#source_identity').removeClass('hidden');
                //$('#source_identity input').attr('placeholder', "Specify "+hint);
            }else{
                //$('#source_identity').addClass('hidden');
            }
        }

        let set_payment_channel = (element)=>{
            let option_action = $(element).find(':selected').data('action');
            if(option_action == 'specify'){
                $('#payment_channel').prop('readonly', false);
                $('#payment_channel').attr('placeholder', "specify how you paid your application fee");
                $('#payment_channel').val('');
            }else{
                $('#payment_channel').prop('readonly', true);
                $('#payment_channel').val($(element).val());
            }
        }

        let toggleHealthCondition = (element)=>{
            let value = $(element).val();
            if(value == 'YES'){
                $('#health_condition').prop('readonly', false);
            }else{
                $('#health_condition').prop('readonly', true);
            }
        }

        let toggleDisability = (element)=>{
            let value = $(element).val();
            if(value == 'YES'){
                $('#disability').prop('readonly', false);
            }else{
                $('#disability').prop('readonly', true);
            }
        }

        let toggleALResults = ()=>{
            $('#al_toggle_view').toggleClass('hidden');
        }
    </script>
@endsection
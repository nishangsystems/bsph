@extends('admin.layout')
@php
$___year = intval(now()->format('Y'));
$ol_key = time().random_int(1000, 1099);
$al_key = time().random_int(2000, 2099);
$em_key = time().random_int(3000, 3099);
@endphp
@section('section')
    <div class="py-4">
        <form enctype="multipart/form-data" id="application_form" method="post">
            @csrf

            <div class="py-5 container-fluid row">
                <input type="hidden" name="campus_id" value="{{ $campuses[0]->id }}">
                <div class="col-sm-12 col-md-12">
                    <label class="text-capitalize"><span style="font-weight: 700;">{{ __('text.applying_for_phrase') }}</span><i class="text-danger text-xs">*</i></label>
                    <select name="degree_id" class="form-control text-primary"  id="degree_types">  
                        @if($application->degree_id != null)
                            <option value="{{ $degree->id }}" selected>{{ $degree->deg_name }}</option>                                        
                        @endif                                  
                    </select>
                </div>
            </div>

            <div class="py-2 container-fluid row">
                <h4 class="py-3 border-bottom border-top bg-info text-white my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 1: {{ __('text.personal_details_bilang') }}</h4>
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
                            <option></option>
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
                            @if($application->division != null)
                                @php
                                    $division = \App\Models\Division::find($application->division);
                                @endphp
                                <option value="{{ $division->id }}" selected>{{ $division->name }}</option>
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
                        <div class="col-sm-2">
                            <select name="" id="" class="form-control" onchange="toggleDisability(this)">
                                <option value="YES" {{ old('disability', $application->disability) != null ? 'selected' : '' }}>YES</option>
                                <option value="NONE" {{ old('disability', $application->disability) == null ? 'selected' : '' }}>NONE</option>
                            </select>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-primary" name="disability"  value="{{ old('disability', $application->disability) }}" id="disability" required>
                        </div>
                    </div>
                    <label class="text-secondary  text-capitalize">{{ __('text.word_disability') }}<i class="text-danger text-xs">*(<b>None</b> if none)</i></label>
                </div>

                <div class="py-2 col-sm-6 col-md-5 col-xl-4">
                    <div class="row">
                        <div class="col-sm-2">
                            <select name="" id="" class="form-control" onchange="toggleHealthCondition(this)">
                                <option value="YES" {{ old('health_condition', $application->health_condition) != null ? 'selected' : '' }}>YES</option>
                                <option value="NONE" {{ old('health_condition', $application->health_condition) == null ? 'selected' : '' }}>NONE</option>
                            </select>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-primary" name="health_condition" id="health_condition" value="{{ old('health_condition', $application->health_condition) }}" required>
                        </div>
                    </div>
                    <label class="text-secondary text-capitalize">{{ __('text.health_condition') }}<i class="text-danger text-xs">*(<b>None</b> if none)</i></label>
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
            </div>
            
            <div class="py-2 container-fluid row">
                <h4 class="py-3 border-bottom border-top bg-info text-white my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;"> {{ __('text.degree_slash_diploma_study_choice') }}</h4>
                <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                    <div class="">
                        <select class="form-control text-primary"  name="program_first_choice" required oninput="loadCplevels(event)">
                            <option>{{ __('text.select_program') }}</option>
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
                            <option>{{ __('text.select_program') }}</option>
                            @foreach (collect($programs)->where('appliable', 1)->sortBy('name') as $program)
                                <option value="{{ $program->id }}" {{ old('program_second_choice', $application->program_second_choice) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                </div>
                <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                    <div class="">
                        <select class="form-control text-primary"  name="program_third_choice">
                            <option>{{ __('text.select_program') }}</option>
                            @foreach (collect($programs)->where('appliable', 1)->sortBy('name') as $program)
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
                        <textarea rows="1" class="form-control text-primary" maxlength="50"  name="enrollment_purpose" required>
                            {{ old('enrollment_purpose', $application->enrollment_purpose??'') }}
                        </textarea>
                    </div>
                    <label class="text-secondary  text-capitalize">{{ __('text.enrollment_purpose_phrase') }}<i class="text-danger text-xs">*</i></label>
                </div>

                <div class="py-2 col-sm-6 col-md-3 col-xl-2">
                    <div class="">
                        <select class="form-control text-primary" required onchange="set_payment_channel(this)" id="" @if(in_array($application->payment_method, ['CBCHS', 'BANK', 'BURSARY'])) disabled @endif>
                            <option value=""></option>
                            {{-- <option value="MOMO" data-action="" {{ $application->payment_method == "MOMO" ? 'selected' : '' }}>MOMO</option> --}}
                            <option value="CBCHS Station" data-action="" {{ $application->fee_payment_channel == "CBCHS Station" ? 'selected' : '' }}>CBCHS Station</option>
                            <option value="Bank payment" data-action="" {{ $application->fee_payment_channel == "Bank payment" ? 'selected' : '' }}>Bank payment</option>
                            <option value="School Bursary" data-action="" {{ $application->fee_payment_channel == "School Bursary" ? 'selected' : '' }}>School Bursary</option>
                            <option value="Others" {{ $application->fee_payment_channel == "OTHER" ? 'selected' : '' }} data-action="specify">Others? (Specify)</option>
                        </select>
                    </div>
                    <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}?<i class="text-danger text-xs">*</i></label>
                </div>

                <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                    <div class="">
                        <input type="text" name="fee_payment_channel" value="{{ old('fee_payment_channel', $application->fee_payment_channel??'') }}" class="form-control text-primary" required {{ $application->payment_method == "OTHER" ? '' : 'readonly' }} id="payment_channel">
                    </div>
                    <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}?<i class="text-danger text-xs">*</i></label>
                </div>

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
                <div class="py-2 col-sm-6 col-md-4 col-xl-4 hidden" id="source_identity">
                    <div class="">
                        <input type="text" class="form-control text-primary"  name="info_source_identity" value="{{ old('info_source_identity', $application->info_source_identity) }}">
                    </div>
                    <label class="text-secondary  text-capitalize">{{ __('text.specify_information_source') }}<i class="text-danger text-xs">*</i></label>
                </div>
            </div>

            <div class="py-2 container-fluid row">
                <h4 class="py-3 border-bottom border-top bg-info text-white my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;">{{ __('text.word_stage') }} 3: {{ __('text.schools_attended') }}</h4>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    
                    <div class="card my-1">
                        <div class="card-body container-fluid">
                            <h5 class="font-weight-bold text-capitalize text-center h4">{{ __('text.schools_attended') }}</h5>
                            <table class="table table-light" style="table-layout:fixed; max-width:inherit;">
                                <div class="text-capitalize">
                                    <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-end h5"><span class="btn btn-sm btn-primary rounded" onclick="addSchoolAttended()">add</span> </h5>
                                </div>
                                <hr>
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
                                                <input type="text" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][qualification]" required value="{{ $_result->qualification }}">
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
                                                <input type="text" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][school]">
                                                <span>@lang('text.word_school')<i class="text-danger text-xs">*</i></span>
                                            </div>
                                            <div class="col-sm-5 col-md-3 col-xl-2">
                                                <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_from]">
                                                <span>@lang('text.date_from')<i class="text-danger text-xs">*</i></span> 
                                            </div>
                                            <div class="col-sm-4 col-md-3 col-xl-2">
                                                <input type="month" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][date_to]">
                                                <span>@lang('text.date_to')<i class="text-danger text-xs">*</i></span>
                                            </div>
                                            <div class="col-sm-5 col-md-6 col-xl-3">
                                                <input type="text" class="form-control text-primary"  name="schools_attended[{{ $al_key }}][qualification]">
                                                <span>@lang('text.word_qualification')<i class="text-danger text-xs">*</i></span>
                                            </div>
                                            <div class="col-sm-3 col-md-6 col-xl-2"><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropSchoolAttended(event)">{{ __('text.word_drop') }}</span>
                                            </div>
                                        </div>
                                    @endwhile
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 container-fluid row">
                <h4 class="py-3 border-bottom border-top bg-info text-white my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 4: {{ __('text.odinary_and_or_advanced_level_results_bilang') }}</h4>
                <div class="col-sm-12 col-md-12 col-lg-12 py-2 px-2">
                    <div class="py-2 border card px-2">
                        <h5 style="text-transform: uppercase; font-weight: 700; margin-bottom: 2rem;" class="text-primary text-center">@lang('text.ordinary_level_results')</h5>
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
                            <div class="text-capitalize">
                                <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-end h5"><span class="btn btn-sm btn-primary rounded" onclick="addOLResult()">add</span> </h5>
                            </div>
                            <hr>
                            <div id="ol_results">
                                @php $counter = 1; @endphp
                                @foreach (json_decode($application->ol_results)??[] as $_result)
                                    @php
                                        $ol_key++;
                                        $counter++
                                    @endphp
                                    <div class="text-capitalize container-fluid row py-3">
                                        <div class="col-sm-7 col-md-7 col-xl-8">
                                            <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" required value="{{ $_result->subject }}">
                                            <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xl-2">
                                            <select class="form-control text-primary"  name="ol_results[{{ $ol_key }}][grade]" required>
                                                <option value=""></option>
                                                <option value="A" {{ $_result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $_result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C" {{ $_result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="D" {{ $_result->grade == 'D' ? 'selected' : '' }}>D</option>
                                                <option value="E" {{ $_result->grade == 'E' ? 'selected' : '' }}>E</option>
                                                <option value="F" {{ $_result->grade == 'F' ? 'selected' : '' }}>F</option>
                                                <option value="Compensatory" {{ $_result->grade == 'Compensatory' ? 'selected' : '' }}>Compensatory</option>
                                            </select>
                                            <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-xl-2">
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
                                        <div class="col-sm-7 col-md-7 col-xl-8">
                                            <input type="text" class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" required>
                                            <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xl-2">
                                            <select class="form-control text-primary"  name="ol_results[{{ $ol_key }}][grade]" required>
                                                <option value=""></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="Compensatory">Compensatory</option>
                                            </select>
                                            <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-xl-2">
                                            <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                                        </div>
                                    </div>
                                @endwhile
                            </div>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center py-4">
                        <span class="btn btn-primary text-uppercase px-3 rounded" onclick="toggleALResults()">ADD ADVANCED LEVEL RESULTS</span>
                    </div>
                    <div class="py-2 border card px-2 {{ $application->al_results == null ? 'hidden' : '' }}" id="al_toggle_view">
                        <h5 style="text-transform: uppercase; font-weight: 700; margin-bottom: 2rem;" class="text-primary text-center">@lang('text.advanced_level_results')</h5>
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
                                        <option value="{{ $yr }}" {{ $yr == old('al_year', $application->ol_year) ? 'selected' : '' }}>{{ $yr }}</option>
                                    @endfor
                                </select>
                                <small class="text-danger"><i>@lang('text.word_year')</i>*</small>
                            </div>
                        </div>
                        
                        <table class="table table-light" style="table-layout:fixed; max-width:inherit;">
                            <div class="text-capitalize">
                                <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-end h5"><span class="btn btn-sm btn-primary rounded" onclick="addALResult()">add</span> </h5>
                            </div>
                            <hr>
                            <div id="al_results">
                                @php $counter = 1; @endphp
                                @foreach (json_decode($application->al_results)??[] as $_result)
                                    @php
                                        $ol_key++;
                                        $counter++
                                    @endphp
                                    <div class="text-capitalize container-fluid row py-3">
                                        <div class="col-sm-7 col-md-7 col-xl-8">
                                            <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" required value="{{ $_result->subject }}">
                                            <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xl-2">
                                            <select class="form-control text-primary"  name="al_results[{{ $al_key++ }}][grade]" required>
                                                <option value=""></option>
                                                <option value="A" {{ $_result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $_result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C" {{ $_result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="D" {{ $_result->grade == 'D' ? 'selected' : '' }}>D</option>
                                                <option value="E" {{ $_result->grade == 'E' ? 'selected' : '' }}>E</option>
                                                <option value="F" {{ $_result->grade == 'F' ? 'selected' : '' }}>F</option>
                                                <option value="Compensatory" {{ $_result->grade == 'Compensatory' ? 'selected' : '' }}>Compensatory</option>
                                            </select>
                                            <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-xl-2">
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
                                        <div class="col-sm-7 col-md-7 col-xl-8">
                                            <input type="text" class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" required>
                                            <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-2 col-md-2 col-xl-2">
                                            <select class="form-control text-primary"  name="al_results[{{ $al_key }}][grade]" required>
                                                <option value=""></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="Compensatory">Compensatory</option>
                                            </select>
                                            <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-xl-2">
                                            <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropALResult(event)">{{ __('text.word_drop') }}</span>
                                        </div>
                                    </div>
                                @endwhile
                            </div>
                        </table>
                    </div>
                </div>
            </div>

            <div class="py-2 container-fluid">
                <button type="submit" class="btn btn-sm btn-primary px-5 rounded form-control text-uppercase mx-auto">@lang('text.word_update')</button>
            </div>
        </form>
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
                            <div class="col-sm-7 col-md-7 col-xl-8">
                                <input type="text" class="form-control text-primary"  name="ol_results[${key}][subject]" required>
                                <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <select class="form-control text-primary"  name="ol_results[${key}][grade]" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="Compensatory">Compensatory</option>
                                </select>
                                <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-2">
                                <span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOLResult(event)">{{ __('text.word_drop') }}</span>
                            </div>
                        </div>`;
            $('#ol_results').append(html);
        }
       
        // Add and drop previous trainings form table rows
        let addALResult = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<div class="text-capitalize container-fluid row py-3">
                            <div class="col-sm-7 col-md-7 col-xl-8">
                                <input type="text" class="form-control text-primary"  name="al_results[${key}][subject]" required>
                                <span>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-2 col-md-2 col-xl-2">
                                <select class="form-control text-primary"  name="al_results[${key}][grade]" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="Compensatory">Compensatory</option>
                                </select>
                                <span>@lang('text.word_grade')<i class="text-danger text-xs">*</i></span>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-2">
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
                                <input type="text" class="form-control text-primary"  name="schools_attended[${key}][qualification]" required>
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
                let hint = $(element).find(':selected').data('hint');
                $('#source_identity').removeClass('hidden');
                $('#source_identity input').attr('placeholder', "Specify "+hint);
            }else{
                $('#source_identity').addClass('hidden');
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
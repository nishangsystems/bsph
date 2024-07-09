@extends('student.layout')
@php
$___year = intval(now()->format('Y'));
$ol_key = time().random_int(1000, 1099);
$al_key = time().random_int(2000, 2099);
$em_key = time().random_int(3000, 3099);
@endphp
@section('section')

    <div class="py-4">
        {{-- <h1>1234</h1> --}}
        @switch($step)
            @case(0)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [1, $application->id]) }}">
                    @csrf
                    <div class="px-5 py-5 border-top shadow bg-light">
                        <div class="row w-100">
                            {{-- <div class="col-sm-12 col-md-6">
                                <label class="text-capitalize"><span style="font-weight: 700;">{{ __('text.word_campus') }}</span></label>
                                <select name="campus_id" class="form-control text-primary"  oninput="setDegreeTypes(event)">
                                    <option>{{ __('text.select_campus') }}</option>
                                    @if (count($campuses) > 0)
                                        <option selected value="{{ $campuses[0]->id }}" {{ $application->campus_id == $campuses[0]->id ? 'selected' : '' }}>{{ $campuses[0]->name }}</option>  
                                    @endif
                                </select>
                            </div> --}}
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
                            <a href="" class="px-5 py-2 btn btn-lg btn-danger mx-3" >{{ __('text.word_back') }}</a>
                            <a href="" class="px-5 py-2 btn btn-lg btn-primary mx-3" onclick="confirm('Are you sure you are applying for  BACHELOR  Program?') ? (window.location=`{{ route('student.application.start', [1, $application->id]) }}`) : null">{{ __('text.word_continue') }}</a>
                        </div>
                    </div>
                </form>
                @break

            @case(1)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [2, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 1: {{ __('text.personal_details_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        <div class="py-2 col-sm-6 col-md-5 col-xl-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_name_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="name" value="{{ auth('student')->user()->name }}" readonly required>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-3 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_gender_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="gender" required>
                                    <option value="male" {{ $application->gender == 'male' ? 'selected' : '' }}>{{ __('text.word_male') }}</option>
                                    <option value="female" {{ $application->gender == 'female' ? 'selected' : '' }}>{{ __('text.word_female') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_birth_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <input type="date" class="form-control text-primary"  name="dob" value="{{ $application->dob }}" required>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_birth_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="pob" value="{{ $application->pob }}" required>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.marital_status') }}</label>
                            <div class="">
                                <select class="form-control text-primary"  name="marital_status">
                                    <option value=""></option>
                                    <option value="single" {{ $application->marital_status == 'single' ? 'selected' : '' }}>single</option>
                                    <option value="married" {{ $application->marital_status == 'married' ? 'selected' : '' }}>married</option>
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_country_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="nationality" required>
                                    <option></option>
                                    @foreach(config('all_countries.list') as $key=>$value)
                                        <option value="{{ $value['name'] }}" {{ $application->nationality== $value['name'] ? 'selected' : ($value['name'] == 'Cameroon' ? 'selected' : '') }}>{{ $value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="region" required oninput="loadDivisions(event)">
                                    <option value=""></option>
                                    @foreach(\App\Models\Region::all() as $value)
                                        <option value="{{ $value->id }}" {{ $application->region == $value->id ? 'selected' : '' }}>{{ $value->region }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_division') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="division" required id="divisions">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.permanent_address_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <input type="text" class="form-control text-primary"  name="residence" value="{{ $application->residence }}" required>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }}<i class="text-danger text-xs">*</i></label>
                                <input type="tel" class="form-control text-primary"  name="phone" value="{{ auth('student')->user()->phone }}" readonly required>
                            </div>
                        </div>
                        
                        {{-- <input type="hidden"  name="email" value="{{ auth('student')->user()->email }}"> --}}
                        
                        <input type="hidden" name="campus_id" value="{{ $application->campus_id }}">
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.entry_qualification') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="entry_qualification" required>
                                    <option value=""></option>
                                    @foreach ($certs as $cert)
                                        <option value="{{ $cert->id }}" {{ $application->entry_qualification== $cert->id ? 'selected' : '' }}>{{ $cert->certi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-6 col-xl-4">
                            <label class="text-secondary text-capitalize">{{ __('text.special_needs') }}</label>
                            <div>
                                <textarea class="form-control text-primary"  name="special_needs">{{ $application->special_needs }}</textarea>
                            </div>
                        </div>
                        {{-- <div class="py-2 col-sm-6 col-md-4 col-xl-2">
                            <label class="text-secondary  text-capitalize">{{ __('text.id_slash_passport_number') }}(<i class="text-success text-xs">optional</i>)</label>
                            <div class="">
                                <input class="form-control text-primary"  name="id_number" value="{{ $application->id_number }}">
                            </div>
                        </div> --}}



                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;"> {{ __('text.additional_personal_details') }} </h4>
                        {{-- <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.father_name') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="father_name" value="{{ $application->father_name??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.father_address') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="father_address" value="{{ $application->father_address??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.father_tel') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="father_tel" value="{{ $application->father_tel??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.mother_name') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="mother_name" value="{{ $application->mother_name??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.mother_address') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="mother_address" value="{{ $application->mother_address??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.mother_tel') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="mother_tel" value="{{ $application->mother_tel??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.guardian_name') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="guardian_name" value="{{ $application->guardian_name??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.guardian_address') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="guardian_address" value="{{ $application->guardian_address??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.guardian_tel') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="guardian_tel" value="{{ $application->guardian_tel??'' }}">
                            </div>
                        </div> --}}
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_name_bilang') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="emergency_name" value="{{ $application->emergency_name??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class=" text-secondary text-capitalize">{{ __('text.emergency_address_bilang') }}</label>
                            <div class="">
                                <input class="form-control text-primary"  name="emergency_address" value="{{ $application->emergency_address??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_tel_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <input class="form-control text-primary"  name="emergency_tel" required value="{{ $application->emergency_tel??'' }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ route('student.application.start', [$step-1, $application->id]) }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
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
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.first_choice_bilang') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="program_first_choice" required oninput="loadCplevels(event)">
                                    <option>{{ __('text.select_program') }}</option>
                                    @foreach (collect($programs)->where('appliable', 1)->sortBy('name') as $program)
                                        <option value="{{ $program->id }}" {{ $application->program_first_choice == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                            <div class="">
                                <select class="form-control text-primary"  name="program_second_choice">
                                    <option>{{ __('text.select_program') }}</option>
                                    @foreach (collect($programs)->where('appliable', 1)->sortBy('name') as $program)
                                        <option value="{{ $program->id }}" {{ $application->program_second_choice == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">

                            <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}<i class="text-danger text-xs">*</i></label>
                            <div class="">
                                <select class="form-control text-primary"  name="level" required id="cplevels">
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ route('student.application.start', [$step-1, $application->id]) }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break

            @case(3)

                @if($isMaster)
                    <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [4, $application->id]) }}">
                        @csrf
                        <div class="py-2 row bg-light border-top shadow">
                            <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 3: {{ __('text.previous_higher_education_training_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                            <div class="col-sm-12 col-md-12 col-lg-12 py-2">
                                <table class="border">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="text-center border-0" colspan="5">
                                                <div class="d-flex justify-content-end py-2 w-100">
                                                    <span class="btn btn-sm px-4 py-1 btn-secondary rounded" onclick="addTraining()">{{ __('text.word_add') }}</span>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="text-capitalize">
                                            <th class="text-center border">{{ __('text.word_school_bilang') }}<i class="text-danger text-xs">*</i></th>
                                            <th class="text-center border">{{ __('text.word_year_bilang') }}<i class="text-danger text-xs">*</i></th>
                                            <th class="text-center border">{{ __('text.word_course_bilang') }}<i class="text-danger text-xs">*</i></th>
                                            <th class="text-center border">{{ __('text.word_certificate_bilang') }}<i class="text-danger text-xs">*</i></th>
                                            <th class="text-center border"></th>
                                        <tr>
                                    </thead>
                                    <tbody id="previous_trainings">
                                        
                                        @foreach (json_decode($application->previous_training)??[] as $key=>$training)
                                            <tr class="text-capitalize">
                                                <td class="border"><input class="form-control text-primary"  name="previous_training[school][$key]" required value="{{ $training->school }}"></td>
                                                <td class="border"><select class="form-control text-primary"  name="previous_training[year][$key]" required>
                                                    <option value=""></option>
                                                    @for($i = $___year; $i >=  $___year-100; $i--)
                                                        <option value="{{ $i }}" {{ $training->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select></td>
                                                <td class="border"><input class="form-control text-primary"  name="previous_training[course][$key]" required value="{{ $training->course }}"></td>
                                                <td class="border"><input class="form-control text-primary"  name="previous_training[certificate][$key]" required value="{{ $training->certificate }}"></td>
                                                <td class="border"><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropTraining(event)">{{ __('text.word_drop') }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                                <a href="{{ route('student.application.start', [$step-1, $application->id]) }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                                <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                            </div>
                        </div>
                    </form>
                @endif
                @break
        
            @case(4)
            @case(4.5)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [4.5, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;">{{ __('text.word_stage') }} 4: {{ __('text.education_qualification') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        <div class="col-sm-12 col-md-12 col-lg-12">

                            <div class="card my-1">
                                <div class="card-body container-fluid">
                                    <h5 class="font-weight-bold text-capitalize text-center h4">{{ __('text.ordinary_level_results') }}</h5>
                                    <table class="table-light" style="table-layout:fixed; max-width:inherit;">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th colspan="3">
                                                    <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-between h5">{{ __('text.word_subjects') }} <span class="btn btn-sm btn-primary rounded" onclick="addOlResult()">add</span> </h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.center_no')<i class="text-danger text-xs">*</i>:</div>
                                                                <div class="col-md-6 col-lg-6"><input type="text" name="ol_center_number" class="form-control rounded border-0" placeholder="center number" requried value="{{ old('ol_center_number', $application->ol_center_number) }}"></div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.candidate_no')<i class="text-danger text-xs">*</i>:</div>
                                                                <div class="col-md-6 col-lg-6"><input type="text" name="ol_candidate_number" class="form-control rounded border-0" placeholder="candidate number" required value="{{ old('ol_candidate_number', $application->ol_candidate_number) }}"></div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.word_year'):</div>
                                                                <div class="col-md-6 col-lg-6">
                                                                    @php
                                                                        $__y = intval(now()->format('Y'));
                                                                    @endphp
                                                                    <select name="ol_year" class="form-control rounded border-0">
                                                                        <option value=""></option>
                                                                        @for($i = $__y; $i > $__y - 100; $i--)
                                                                            <option value="{{ $i }}" {{ old('ol_year', $application->ol_year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></th>
                                                <th>@lang('text.word_grade')<i class="text-danger text-xs">*</i></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="ol_results">
                                            @php $counter = 1; @endphp
                                            @foreach (json_decode($application->ol_results)??[] as $result)
                                                @php
                                                    $ol_key++;
                                                    $counter++;
                                                @endphp
                                                <tr class="text-capitalize">
                                                    <td><input class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" value="{{ $result->subject }}"></td>
                                                    <td>
                                                        <select class="form-control text-primary input imput-sm"  name="ol_results[{{ $ol_key }}][grade]" value="{{ $result->grade }}">
                                                            <option value=""></option>
                                                            <option value="A" {{ $result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                            <option value="B" {{ $result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                            <option value="C" {{ $result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                        </select>
                                                    </td>
                                                    <td><span class="btn btn-xs px-4 py-1 btn-danger rounded" onclick="dropOlResult(event)">{{ __('text.word_drop') }}</span></td>
                                                </tr>
                                            @endforeach
                                            @while ($counter <= 11)
                                                @php
                                                    $ol_key++;
                                                    $counter++;
                                                @endphp
                                                <tr class="text-capitalize">
                                                    <td><input class="form-control text-primary"  name="ol_results[{{ $ol_key }}][subject]" value=""></td>
                                                    <td>
                                                        <select class="form-control text-primary input imput-sm"  name="ol_results[{{ $ol_key }}][grade]" value="">
                                                            <option value=""></option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                        </select>
                                                    </td>
                                                    <td><span class="btn btn-xs px-4 py-1 btn-danger rounded" onclick="dropOlResult(event)">{{ __('text.word_drop') }}</span></td>
                                                </tr>
                                            @endwhile
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.word_save') }}">
                            <button type="button" class="px-4 py-1 btn btn-lg btn-success" onclick="window.location=`{{ route('student.application.start', [5, $application->id]) }}`"> {{ __('text.word_next') }}</button>
                        </div>
                    </div>
                </form>
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [5, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        {{-- <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:600;">{{ __('text.word_stage') }} 4: {{ __('text.education_qualification') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4> --}}
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            
                            <div class="card my-1">
                                <div class="card-body container-fluid">
                                    <h5 class="font-weight-bold text-capitalize text-center h4">{{ __('text.advanced_level_results') }}</h5>
                                    <table class="table-light" style="table-layout:fixed; max-width:inherit;">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th colspan="3">
                                                    <h5 class="text-dark font-weight-semibold text-uppercase text-center d-flex justify-content-between h5">{{ __('text.word_subjects') }} <span class="btn btn-sm btn-primary rounded" onclick="addAlResult()">add</span> </h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="3">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.center_no')<i class="text-danger text-xs">*</i>:</div>
                                                                <div class="col-md-6 col-lg-6"><input type="text" name="al_center_number" class="form-control rounded border-0" placeholder="center number" required value="{{ old('al_center_number', $application->al_center_number) }}"></div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.candidate_no')<i class="text-danger text-xs">*</i>:</div>
                                                                <div class="col-md-6 col-lg-6"><input type="text" name="al_candidate_number" class="form-control rounded border-0" placeholder="candidate number" required value="{{ old('al_candidate_number', $application->al_candidate_number) }}"></div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                        <div class="col-sm-6 col-md-4">
                                                            <div class="row border rounded mx-1 my-1">
                                                                <div class="col-md-6 col-lg-6 text-capitalize bg-secondary text-white">@lang('text.word_year')<i class="text-danger text-xs">*</i>:</div>
                                                                <div class="col-md-6 col-lg-6">
                                                                    @php
                                                                        $__y = intval(now()->format('Y'));
                                                                    @endphp
                                                                    <select name="al_year" class="form-control rounded border-0">
                                                                        <option value=""></option>
                                                                        @for($i = $__y; $i > $__y - 100; $i--)
                                                                            <option value="{{ $i }}" {{ old('al_year', $application->al_year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div class="col-sm-6 col-md-4">
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>{{ trans_choice('text.word_subject', 1) }}<i class="text-danger text-xs">*</i></th>
                                                <th>@lang('text.word_grade')<i class="text-danger text-xs">*</i></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="al_results">
                                            @php $counter = 1; @endphp
                                            @foreach (json_decode($application->al_results)??[] as $_result)
                                                @php
                                                    $al_key++;
                                                    $counter++
                                                @endphp
                                                <tr class="text-capitalize">
                                                    <td><input class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" required value="{{ $_result->subject }}"></td>
                                                    <td>
                                                        <select class="form-control text-primary"  name="al_results[{{ $al_key++ }}][grade]" required>
                                                            <option value=""></option>
                                                            <option value="A" {{ $_result->grade == 'A' ? 'selected' : '' }}>A</option>
                                                            <option value="B" {{ $_result->grade == 'B' ? 'selected' : '' }}>B</option>
                                                            <option value="C" {{ $_result->grade == 'C' ? 'selected' : '' }}>C</option>
                                                            <option value="D" {{ $_result->grade == 'D' ? 'selected' : '' }}>D</option>
                                                            <option value="E" {{ $_result->grade == 'E' ? 'selected' : '' }}>E</option>
                                                        </select>
                                                    </td>
                                                    <td><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropAlResult(event)">{{ __('text.word_drop') }}</span></td>
                                                </tr>
                                            @endforeach
                                            @while ($counter <= 5)
                                                @php
                                                    $al_key++;
                                                    $counter++
                                                @endphp
                                                <tr class="text-capitalize">
                                                    <td><input class="form-control text-primary"  name="al_results[{{ $al_key }}][subject]" value=""></td>
                                                    <td>
                                                        <select class="form-control text-primary"  name="al_results[{{ $al_key++ }}][grade]">
                                                            <option value=""></option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                        </select>
                                                    </td>
                                                    <td><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropAlResult(event)">{{ __('text.word_drop') }}</span></td>
                                                </tr>
                                            @endwhile
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 d-flex justify-content-center">
                            <a href="{{ route('student.application.start', [$step-1, $application->id]) }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            <input type="submit" class="px-4 py-1 btn btn-lg btn-primary" value="{{ __('text.save_and_continue') }}">
                        </div>
                    </div>
                </form>
                @break

            @case(5)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [8, $application->id]) }}">
                    @csrf
                    <div class="py-2 row text-capitalize bg-light">
                        <!-- hidden field for submiting application form -->
                        <h4 class="py-3 border-bottom border-top bg-white text-primary my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:800;">{{ __('text.word_stage') }} 5: {{ __('text.preview_and_submit_form_bilang') }} : <span class="text-danger">APPLYING FOR A(AN) {{ $degree->deg_name }} PROGRAM</span></h4>
                        
                        <!-- STAGE 1 PREVIEW -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 1: <a href="{{ route('student.application.start', [1, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.view_and_or_edit_stage') }} 1</a></h4>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-5">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_name') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->name ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_gender_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->gender ?? '' }}</select>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.date_of_birth_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->dob ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.place_of_birth_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->pob ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_nationality_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->nationality ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_residence_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->residence ?? '' }}<label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-5">
                            <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->phone ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_email_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $application->email ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_campus') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $campus->name ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.entry_qualification') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $cert->certi ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                            <label class="text-secondary  text-capitalize">{{ __('text.special_needs') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0 ">{{ $cert->special_needs ?? '' }}</label>
                            </div>
                        </div>


                        <!-- STAGE 2 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 2: <a href="{{ route('student.application.start', [2, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.view_and_or_edit_stage') }} 2</a></h4>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary text-capitalize">{{ __('text.emergency_name') }}</label>
                            <div>
                                <label class="form-control text-primary border-0">{{ $application->emergency_name ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_address') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->emergency_address ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.emergency_tel') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->emergency_tel ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.first_choice_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $program1->name ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $program2->name ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->level ?? null }}</label>
                            </div>
                        </div>

                        <!-- STAGE 3 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 3: <a href="{{ route('student.application.start', [3, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.view_and_or_edit_stage') }} 3</a></h4>
                        <h4 class="py-3 border-bottom border-top bg-white text-dark my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;"> {{ __('text.previous_higher_education_training_bilang') }}</h4>
                        <div class="col-sm-12 col-md-12 col-lg-12 py-2">
                            <table class="border">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th class="text-center border">{{ __('text.word_school_bilang') }}</th>
                                        <th class="text-center border">{{ __('text.word_year_bilang') }}</th>
                                        <th class="text-center border">{{ __('text.word_course_bilang') }}</th>
                                        <th class="text-center border">{{ __('text.word_certificate_bilang') }}</th>
                                    <tr>
                                </thead>
                                <tbody id="previous_trainings">
                                    @foreach (json_decode($application->previous_training)??[] as $key=>$training)
                                        <tr class="text-capitalize">
                                            <td class="border"><label class="form-control text-primary border-0">{{ $training->school ?? '' }}</label></td>
                                            <td class="border"><label class="form-control text-primary border-0">{{ $training->year ?? '' }}</label></td>
                                            <td class="border"><label class="form-control text-primary border-0">{{ $training->course ?? '' }}</label></td>
                                            <td class="border"><label class="form-control text-primary border-0">{{ $training->certificate ?? '' }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- STAGE 4 -->
                        <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 4: <a href="{{ route('student.application.start', [4, $application->id]) }}" class="text-white btn py-1 px-2 btn-sm">{{ __('text.view_and_or_edit_stage') }} 4</a></h4>
                        <h4 class="py-3 border-bottom border-top bg-white text-dark my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;"> {{ __('text.advanced_level_results') }}</h4>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.center_no') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->al_center_number ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class=" text-secondary text-capitalize">{{ __('text.candidate_no') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->al_candidate_number ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_year') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->al_year ?? null }}</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 py-2">
                            <table class="border">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th class="text-center border">{{ trans_choice('text.word_subject',1) }}</th>
                                        <th class="text-center border">{{ __('text.word_grade') }}</th>
                                    <tr>
                                </thead>
                                <tbody id="previous_trainings">
                                    {{-- @dd(json_decode($application->al_results)) --}}
                                    @foreach (json_decode($application->al_results)??[] as $key=>$result)
                                        <tr class="text-capitalize">
                                            <td class="border"><label class="form-control text-primary border-0">{{ $result->subject ?? '' }}</label></td>
                                            <td class="border"><label class="form-control text-primary border-0">{{ $result->grade ?? '' }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                        <h4 class="py-3 border-bottom border-top bg-white text-dark my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;"> {{ __('text.ordinary_level_results') }}</h4>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.center_no') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->ol_center_number ?? '' }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <label class=" text-secondary text-capitalize">{{ __('text.candidate_no') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->ol_candidate_number ?? '' }}</label>
                            </div>
                        </div>
                        <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                            <label class="text-secondary  text-capitalize">{{ __('text.word_year') }}</label>
                            <div class="">
                                <label class="form-control text-primary border-0">{{ $application->ol_year ?? null }}</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 py-2">
                            <table class="border">
                                <thead>
                                    <tr class="text-capitalize">
                                        <th class="text-center border">{{ trans_choice('text.word_subject',1) }}</th>
                                        <th class="text-center border">{{ __('text.word_grade') }}</th>
                                    <tr>
                                </thead>
                                <tbody id="previous_trainings">
                                    @foreach (json_decode($application->ol_results)??[] as $key=>$result)
                                        <tr class="text-capitalize">
                                            <td class="border"><label class="form-control text-primary border-0">{{ $result->subject ?? '' }}</label></td>
                                            <td class="border"><label class="form-control text-primary border-0">{{ $result->grade ?? '' }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="col-sm-12 col-md-12 col-lg-12 py-4 mt-5 d-flex justify-content-center text-uppercase">
                            <a href="{{ route('student.application.start', [$step-0.5, $application->id]) }}" class="px-4 py-1 btn btn-lg btn-danger">{{ __('text.word_back') }}</a>
                            {{-- <a href="{{ route('student.home') }}" class="px-4 py-1 btn btn-lg btn-success">{{ __('text.pay_later') }}</a> --}}
                            @if(!$application->is_filled())<button type="submit" class="px-4 py-1 btn btn-lg btn-primary text-uppercase">{{ __('text.word_submit') }}</button>@endif
                        </div>
                    </div>
                </form>
                @break

            @case(6)
                <form enctype="multipart/form-data" id="application_form" method="post" action="{{ route('student.application.start', [7, $application->id]) }}">
                    @csrf
                    <div class="py-2 row bg-light border-top shadow">
                        
                        <div class="col-sm-12 col-md-12 col-lg-12 d-flex">
                            <div class="col-sm-10 col-md-8 col-lg-6 rounded bg-white py-5 my-3 shadow mx-auto">
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
                                <div class="py-5 d-flex justify-content-center">
                                    <a href="{{ route('student.application.start', [$step-1, $application->id]) }}" class="px-4 py-1 btn btn-xs btn-danger">{{ __('text.word_back') }}</a>
                                    <input type="submit" class="px-4 py-1 btn btn-xs btn-primary" value="{{ __('text.save_and_continue') }}">
                                </div>
                            </div>
                        </div>
                        
                        
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
        let addAlResult = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<tr class="text-capitalize">
                            <td><input class="form-control text-primary"  name="al_results[${key}][subject]" required value="" placeholder="SUBJECT"></td>
                            <td>
                                <select class="form-control text-primary"  name="al_results[${key}][grade]" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </td>
                            <td><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropAlResult(event)">{{ __('text.word_drop') }}</span></td>
                        </tr>`;
            $('#al_results').append(html);
        } 

        let dropAlResult = function(event){
            let training = $(event.target).parent().parent();
            // let training = $('#previous_trainings').children().last();
            if(training != null){
                training.remove();
            }
        }
        // Add and drop employment form table rows
        let addOlResult = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<tr class="text-capitalize">
                            <td><input class="form-control text-primary"  name="ol_results[${key}][subject]" required value="" placeholder="SUBJECT"></td>
                            <td>
                                <select class="form-control text-primary"  name="ol_results[${key}][grade]" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </td>
                            <td><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropOlResult(event)">{{ __('text.word_drop') }}</span></td>
                        </tr>`;
            $('#ol_results').append(html);
        } 

        let dropOlResult = function(event){
            let training = $(event.target).parent().parent();
            // let training = $('#previous_trainings').children().last();
            if(training != null){
                training.remove();
            }
        }
        // Add and drop employment form table rows
        let addTraining = function(){
            let key = '_key_'+Date.now()+'_'+Math.random()*10000;
            let html = `<tr class="text-capitalize">
                            <td class="border"><input class="form-control text-primary"  name="previous_training[school][${key}]" required value="" placeholder="SCHOOL"></td>
                            <td class="border"><select class="form-control text-primary"  name="previous_training[year][${key}]" required>
                                                    <option></option>
                                                    @for($i = $___year; $i >= $___year-100; $i--)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select></td>
                            <td class="border"><input class="form-control text-primary"  name="previous_training[course][${key}]" required value="" placeholder="COURSE"></td>
                            <td class="border"><input class="form-control text-primary"  name="previous_training[certificate][${key}]" required value="" placeholder="CERTIFICATE"></td>
                            <td class="border"><span class="btn btn-sm px-4 py-1 btn-danger rounded" onclick="dropTraining(event)">{{ __('text.word_drop') }}</span></td>
                        </tr>`;
            $('#previous_trainings').append(html);
        } 

        let dropTraining = function(event){
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

    </script>
@endsection
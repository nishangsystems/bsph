@extends('admin.layout')
@section('section')
    <div class="py-4">
        <div class="py-2 row text-capitalize bg-light">
            
            <!-- STAGE 1 PREVIEW -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 1: @lang('text.personal_details')</h4>
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
                    <label class="form-control text-primary border-0 ">{{ $application->dob?->format('dS M Y') ?? '' }}</label>
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
                    <label class="form-control text-primary border-0 ">{{ $application->_region?->region ?? '' }}</label>
                </div>
                <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}</label>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->_division?->name ?? '' }}</label>
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
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 2: @lang('text.program_details')</h4>
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
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 3: @lang('text.schools_attended')</h4>
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
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 4: @lang('text.word_results')</h4>
            <div class="container-fluid my-4 row">
                <div class="col-lg-6 col-xl-6 ">
                    <div class="container-fluid card">
                        <h6 class="text-center text-uppercase text-primary"><b>@lang('text.ordinary_level_results')</b></h6>
                        <hr>
                        <div class="row">
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
                                <div class="col-sm-9 px-2">
                                    <label class="form-control rounded text-primary border-light">{{ $res->subject ?? '' }}</label>
                                    <span class="text-secondary">{{ trans_choice('text.word_subject', 1) }}</span>
                                </div>
                                <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                    <label class="form-control rounded text-primary border-light">{{ $res->grade }}</label>
                                    <span class="text-secondary">@lang('text.word_grade')</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 ">
                    <div class="container-fluid card">
                        <h6 class="text-center text-uppercase text-primary"><b>@lang('text.advanced_level_results')</b></h6>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-control border-light">{{ $application->al_center_number }}</label>
                                <small class="text-info"><i>@lang('text.center_no')</i></small>
                            </div>
                            <div class="col-4">
                                <label class="form-control border-light">{{ $application->al_candidate_number }}</label>
                                <small class="text-info"><i>@lang('text.candidate_no')</i></small>
                            </div>
                            <div class="col-4">
                                <label class="form-control border-light">{{ $application->al_year }}</label>
                                <small class="text-info"><i>@lang('text.word_year')</i></small>
                            </div>
                        </div>
                        @foreach (json_decode($application->al_results)??[] as $key=>$res)
                            <div class="text-capitalize row py-3 border-bottom border-dark">
                                <div class="col-sm-9 px-2">
                                    <label class="form-control rounded text-primary border-light">{{ $res->subject ?? '' }}</label>
                                    <span class="text-secondary">{{ trans_choice('text.word_subject', 1) }}</span>
                                </div>
                                <div class="col-sm-2 px-2" style="overflow-x: hidden;">
                                    <label class="form-control rounded text-primary border-light">{{ $res->grade }}</label>
                                    <span class="text-secondary">@lang('text.word_grade')</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container-fluid py-3">
                @if($application->payment_proof != null)
                    <a href="{{ $application->payment_proof }}">
                        <div>
                            <img src="{{ $application->payment_proof }}" alt="" style="height: 14rem; width: auto; margin: 2rem auto;">
                        </div>
                        <span class="text-secondary">@lang('text.proof_of_payment')</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
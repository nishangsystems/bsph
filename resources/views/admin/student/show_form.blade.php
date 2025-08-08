@extends('admin.layout')
@section('section')
    <div class="py-4">
        <div class="py-2 row text-capitalize bg-light">
            
            <!-- STAGE 1 PREVIEW -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 1: </h4>
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
                <label class="text-secondary  text-capitalize">@lang('text.other_names_bilang')</label>
            </div>
            <div class="py-2 col-sm-3 col-md-3 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.word_gender_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->gender ?? '' }}</select>
                </div>
            </div>
            <div class="py-2 col-sm-3 col-md-2 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.date_of_birth_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->dob?->format('dS M Y') ?? '' }}</label>
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
                <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->region ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.word_division') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->division ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.marital_status') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->marital_status ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.telephone_number_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->phone ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.phone_number') }} ({{ __('text.word_whatsapp') }})</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->phone_2 ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.word_email_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->email ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.word_residence_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->residence ?? '' }}<label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.word_campus') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $campus->name ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.id_slash_passport_number') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->id_number ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.place_of_issue') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->id_place_of_issue ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.date_of_issue') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->id_date_of_issue ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.expiry_date') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->id_expiry_date ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.word_disability') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->disability ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.health_condition') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->health_condition ?? '' }}</label>
                </div>
            </div>
            <div class="col-12"><hr></div>
            
            <div class="py-2 col-sm-6 col-md-4 col-lg-5">
                <label class="text-secondary  text-capitalize">{{ __('text.emergency_name') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->emergency_name ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.emergency_address') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->emergency_address ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.emergency_tel') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->emergency_tel ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.emergency_email') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->emergency_email ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.emergency_relationship') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->emergency_personality ?? '' }}</label>
                </div>
            </div>


            <!-- STAGE 2 -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 2: </h4>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.first_choice_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $program1->name ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class=" text-secondary text-capitalize">{{ __('text.second_choice_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $program2->name ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class=" text-secondary text-capitalize">{{ __('text.third_choice_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $program3->name ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-2">
                <label class="text-secondary  text-capitalize">{{ __('text.word_level') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->level ?? null }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.life_purse_of_enrollment') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->enrollment_purpose ?? null }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.how_did_you_pay_application_fee') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payment_channel ?? null }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.information_source') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->info_source ?? null }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.specify_information_source') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->info_source_identity ?? null }}</label>
                </div>
            </div>

            <!-- STAGE 3 -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 3: </h4>
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

        </div>
    </div>
@endsection
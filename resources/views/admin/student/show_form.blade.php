@extends('admin.layout')
@section('section')
    <div class="py-4">
        <div class="py-2 row text-capitalize bg-light">
            <!-- STAGE 1 PREVIEW -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 1: </h4>
            <div class="py-2 col-sm-6 col-md-4 col-lg-5">
                <label class="text-secondary  text-capitalize">{{ __('text.word_name') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->name == null ? \App\Models\Students::find($application->student_id)->name : $application->name }}</label>
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
                <label class="text-secondary  text-capitalize">{{ __('text.word_region_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->nationality ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.region_of_origin') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->_region->region ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.word_division_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 "  name="division" required>{{ $application->_division->name ?? '' }}</label>
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
                <label class="text-secondary  text-capitalize">{{ __('text.where_did_you_hear_about_us') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $application->referer ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.word_campus') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $campus->name??'' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary  text-capitalize">{{ __('text.entry_qualification') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0 ">{{ $cert->certi ?? '' }}</label>
                </div>
            </div>


            <!-- STAGE 2 -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 2:</h4>
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
                    <label class="form-control text-primary border-0">{{ $application->level??null }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.1st_language_spoken_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->first_spoken_language ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.1st_language_written_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->first_written_language ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.2nd_language_spoken_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->second_spoken_language ?? '' }}</label>
                </div>
            </div>
            <div class="py-2 col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.2nd_language_written_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->second_written_language ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.any_known_health_problem_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->has_health_problem ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.if_yes_mention_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->health_problem ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.any_known_health_allergy_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->has_health_allergy ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.if_yes_mention_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->health_allergy ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.any_disabilities_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->has_disability ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.if_yes_mention_bilang') }}</label>
                <div>
                    <label class="form-control text-primary border-0">{{ $application->disability ?? '' }}</label>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary  text-capitalize">{{ __('text.awaiting_results_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->awaiting_results ?? '' }}</label>
                </div>
            </div>

            @if($degree->deg_name??'' == 'MASTER DEGREE PROGRAMS')
                <!-- STAGE 3 -->
                <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 3: </h4>
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

                <h4 class="py-3 border-bottom border-top bg-white text-dark my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;"> {{ __('text.employment_history_bilang') }}</h4>
                <div class="col-sm-12 col-md-12 col-lg-12 py-2">
                    <table class="border">
                        <thead>
                            <tr class="text-capitalize">
                                <th class="text-center border">{{ __('text.employer_name_and_address_bilang') }}</th>
                                <th class="text-center border">{{ __('text.post_held_bilang') }}</th>
                                <th class="text-center border">{{ __('text.word_from_bilang') }}</th>
                                <th class="text-center border">{{ __('text.word_to_bilang') }}</th>
                                <th class="text-center border">{{ __('text.full_or_parttime_bilang') }}</th>
                            <tr>
                        </thead>
                        <tbody id="employments">
                            @foreach (json_decode($application->employments)??[] as $key=>$emp)
                                <tr class="text-capitalize">
                                    <td class="border"><label class="form-control text-primary border-0">{{ $emp->employer ?? '' }}</label></td>
                                    <td class="border"><label class="form-control text-primary border-0">{{ $emp->post ?? '' }}</label></td>
                                    <td class="border"><label class="form-control text-primary border-0">{{ $emp->start ?? '' }}</label></td>
                                    <td class="border"><label class="form-control text-primary border-0">{{ $emp->end ?? '' }}</label></td>
                                    <td class="border"><label class="form-control text-primary border-0">{{ $emp->type ?? '' }}</label></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- STAGE 4 -->
            <h4 class="py-1 border-bottom border-top border-warning bg-white text-danger my-4 text-uppercase col-sm-12 col-md-12 col-lg-12" style="font-weight:500;">{{ __('text.word_stage') }} 4: </h4>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <label class="text-secondary  text-capitalize">{{ __('text.who_is_responsible_for_your_fee_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payer ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <label class="text-secondary text-capitalize">{{ __('text.word_name_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payer_name ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.word_residence') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payer_residence ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.word_tel') }} (<span class="text-dabger">{{ __('text.with_country_code') }}</span>)</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payer_tel ?? '' }}</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <label class="text-secondary text-capitalize">{{ __('text.word_occupation_bilang') }}</label>
                <div class="">
                    <label class="form-control text-primary border-0">{{ $application->fee_payer_occupation ?? '' }}</label>
                </div>
            </div>
        </div>
    </div>
@endsection
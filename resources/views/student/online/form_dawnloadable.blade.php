@extends('student.printable')
@section('section')
    <div class="py-1">
        <table style="table-layout: fixed;">
            <thead>
                <tr style="border-bottom: 0.3rem double green; padding-bottom: 1rem;">
                    <th colspan="6"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-capitalize text-center py-2"></th>
                    <th colspan="4" class="text-capitalize text-center">
                        <p class="text-center px-2" style="font-weight: 500;">@lang('text.form_submission_phrase')</p>
                    </th>
                    <th rowspan="2" class="text-capitalize text-center py-2">
                        <div style="border-radius: 1rem; border: 0.2rem solid black; height: 13rem; width: 13rem; margin-left: -3rem; margin-top: -3rem; padding: 0.5rem 1rem; font-weight: 500; display: flex; flex-direction: column; justify-content: center; align-content: center;">
                            @lang('text.passport_photo_phrase')
                        </div>
                    </th>
                </tr>
                <tr>
                    <th class="text-capitalize text-center py-2"></th>
                    <th colspan="4" class="text-capitalize text-center">
                        <div style="border: 0.3rem solid rgb(129, 131, 108); border-radius: 0.8rem; background-color: rgb(167, 169, 148); padding: 2rem 3rem; margin: 1rem auto; max-width: 70%;">
                            <label class="text-capitalize">@lang('text.for_official_use_only')</label>:<br>
                            <label class="text-capitalize">@lang('text.registration_number')</label>:
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="6" class="pb-2 pt-5" style="text-decoration: underline; text-transform: uppercase; font-size: larger;">1. @lang('text.applicant_details') (Must be filled **)</td>
                </tr>
                <tr>
                    <td colspan="6" class="bg-light py-1 border text-uppercase text-center"><h5><b>@lang('text.applicant_personal_details')</b></h5></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">First Name**</td>
                    <td class="border py-1" colspan="2"><b>{{ $application->firstName() }}</b></td>
                    <td class="border py-1 text-secondary">Middle & Last Name**</td>
                    <td class="border py-1" colspan="2"><b>{{ $application->otherNames() }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.date_of_birth')**</td>
                    <td class="py-1"><span>DD  <b>{{ $application->dob->format('d') }}</b> </span></td>
                    <td class="py-1"><span>MMM <b>{{ $application->dob->format('F') }}</b> </span></td>
                    <td class="py-1" colspan="3"><span>YYYY <b>{{ $application->dob->format('Y') }}</b> </span></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.place_of_birth')**</td>
                    <td class="py-1 border" colspan="5"><b>{{ $application->pob }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_gender')**</td>
                    <td class="py-1 border" colspan="2"><span>Male     <b>{!! $application->gender == 'male' ? '&check;' : '' !!} </b></span></td>
                    <td class="py-1 border" colspan="3"><span>Female       <b>{!! $application->gender == 'female' ? '&check;' : '' !!}</b></span></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_address')**</td>
                    <td class="py-1 border" colspan="5"><b>{{ $application->address }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_contact')**</td>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_mobile') (@lang('text.word_whatsapp'))</td>
                    <td class="py-1 border"><b>{{ $application->phone_2 }}</b></td>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_mobile') 2</td>
                    <td class="py-1 border"><b>{{ $application->phone }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.marital_status')**</td>
                    <td class="py-1 border" colspan="2"><span>Married     <b>{!! $application->marital_status == 'married' ? '&check;' : '' !!} </b></span></td>
                    <td class="py-1 border" colspan="3"><span>Not Married       <b>{!! $application->marital_status == 'single' ? '&check;' : '' !!}</b></span></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_nationality')</td>
                    <td class="py-1 border" colspan="5"><b>{{ $application->nationality }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_region')</td>
                    <td class="py-1 border" colspan="5"><b>{{ $application->_region->name }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize" colspan="2" rowspan="2">Passport details (For International applicants) / <b>National Identity Card (NIC) (For Nationals)</b></td>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_number')</td>
                    <td class="py-1 border"><b>{{ $application->id_number }}</b></td>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.date_of_issue')</td>
                    <td class="py-1 border"><b>{{ $application->id_date_of_issue }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.place_of_issue')</td>
                    <td class="py-1 border"><b>{{ $application->id_place_of_issue }}</b></td>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.expiry_date')</td>
                    <td class="py-1 border"><b>{{ $application->id_expiry_date }}</b></td>
                </tr>
                <tr>
                    <td class="py-1 border text-secondary text-capitalize">@lang('text.word_email')</td>
                    <td class="py-1 border" colspan="5"><b>{{ $application->email }}</b></td>
                </tr>

                {{--  --}}
                <tr>
                    <td colspan="6" class="bg-light py-1 border text-uppercase text-center"><h5><b>@lang('text.emergency_contact_details')</b></h5></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">Name**</td>
                    <td class="border py-1" colspan="2"><b>{{ $application->emergency_name }}</b></td>
                    <td class="border py-1 text-secondary">Specify Relationship (Parent, friend, spouse, relative etc.)**</td>
                    <td class="border py-1" colspan="2"><b>{{ $application->emergency_personality }}</b></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.word_address')</td>
                    <td class="border py-1" colspan="5"><b>{{ $application->emergency_address }}</b></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.word_mobile')(s)  **</td>
                    <td class="border py-1" colspan="5"><b>{{ $application->emergency_tel }}</b></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.word_email') **</td>
                    <td class="border py-1" colspan="5"><b>{{ $application->emergency_email }}</b></td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: uppercase; font-size: larger; padding-top: 2rem;">2. @lang('text.program_details')</td>
                </tr>
                <tr>
                    <td colspan="6" class="bg-light py-1 border text-uppercase text-center"><h5><b>program applied for</b></h5></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.first_choice')</td>
                    <td class="border py-1" colspan="5"><b>{{ $program1->name }}</b></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.second_choice')</td>
                    <td class="border py-1" colspan="5"><b>{{ $program2->name }}</b></td>
                </tr>
                <tr>
                    <td class="border py-1 text-secondary">@lang('text.third_choice')</td>
                    <td class="border py-1" colspan="5"><b>{{ $program3->name }}</b></td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: uppercase; font-size: larger; padding-top: 2rem;">3. Education Background</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" class="bg-light py-1 border text-uppercase text-center"><h5><b>Name of Institution Attended</b></h5></td>
                    <td colspan="2" class="bg-light py-1 border text-uppercase text-center"><h5><b>Dates</b></h5></td>
                    <td colspan="2" rowspan="2" class="bg-light py-1 border text-uppercase text-center"><h5><b>Qualification</b></h5></td>
                </tr>
                <tr>
                    <td class="bg-light py-1 border text-uppercase text-center"><h5><b>From</b></h5></td>
                    <td class="bg-light py-1 border text-uppercase text-center"><h5><b>To</b></h5></td>
                </tr>
                @foreach (json_decode($application->schools_attended) as $instance)
                    <tr>
                        <td class="border py-1" colspan="2"><b>{{ $instance->school }}</b></td>
                        <td class="border py-1"><b>{{ $instance->date_from }}</b></td>
                        <td class="border py-1"><b>{{ $instance->date_to }}</b></td>
                        <td class="border py-1" colspan="2"><b>{{ $instance->qualification }}</b></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="border"><b>(Attach copies of A-Level and O-Level certificates or their equivalent for foreign Applicants as Application will not be reviewed without the documents.)</b></td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="padding-top: 2rem;">4. Explain in a short paragraph how the course you are applying for will assist you to achieve your goals in life</td>
                </tr>
                <tr>
                    <td class="py-2" colspan="6"><b>{{ $application->enrollment_purpose }}</b></td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: capitalize; font-size: larger; padding-top: 2rem;">5. Where did you get information about the program you are applying for?</td>
                </tr>
                <tr class="border-bottom mb-2">
                    <td colspan="5" class="py-1 text-secondary">{!! $application->info_source !!}</td>
                    <td colspan="" class="py-1"><b>{{ $application->info_source_identity }}</b></td>
                </tr>
                



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: capitalize; font-size: larger; padding-top: 2rem;">6. Do you have a disability?</td>
                </tr>
                <tr>
                    <td class="py-2" colspan=""><b>{{ $application->disability == null ? 'None' : $application->disability }}</b></td>
                    <td class="py-2" colspan="4">(kindly attach a document indicating the type of disability)</td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: capitalize; font-size: larger; padding-top: 2rem;">7. Do you have any known medical Condition?</td>
                </tr>
                <tr>
                    <td class="py-2" colspan="2"> - <b>{!! $application->health_condition != null ? 'YES' : '' !!}</b></td>
                    <td class="py-2" colspan="4"><b>{{ $application->health_condition }}</b></td>
                </tr>



                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: capitalize; font-size: larger; padding-top: 2rem;">8. REGISTRATION/APPLICATION FEE PAYMENT</td>
                </tr>
                <tr>
                    <td class="py-2" colspan="6"> How did you pay your registration fee?</td>
                </tr>
                <tr>
                    <td class="py-2" colspan="3"> - <b> {{ $application->fee_payment_channel }}</b></td>
                    <td class="py-2" colspan="3"> - <b><i>NB: FORM WILL NOT BE COLLECTED WITHOUT PROOF OF PAYMENT!!</i></b></td>
                </tr>


                
                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; text-transform: capitalize; font-size: larger; padding-top: 2rem;">9. APPLICANT DECLARATION</td>
                </tr>
                <tr>
                    <td class="py-2" colspan="6"> I <b>{{ $application->name }}</b> hereby affirm that to the best of my knowledge and belief, the information/documents given in this form are true and a complete record about me in all respects. </td>
                </tr>
                <br>
                <tr>
                    <td class="py-2 border-bottom" colspan="3"> Signature: </td>
                    <td class="py-2 border-bottom" colspan="3"> Date: {{ $application->submitted->format('l M dS Y') }}</td>
                </tr>

                
                
                <tr>
                    <td colspan="6" class="pb-2 bt-5" style="text-decoration: underline; font-size: larger; padding-top: 2rem;"><b>9. NB: Attach photocopies of:</b></td>
                </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>Birth Certificate</b></td> </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>National Identity Card</b></td> </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>Ordinary and Advanced Level slips/certificate</b></td> </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>Baccalaureate or Technical result slips</b></td> </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>Disability card</b></td> </tr>
                <tr> <td class="py-2" colspan=""></td> <td class="py-2" colspan="5"> - <b>Medical Report</b></td> </tr>



            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center text-capitalize">
                        <br>
                        <br>
                        <br>
                        @lang('text.printed_date'): {{ now()->format('M d Y') }}
                    </td>
                </tr>
            </tfoot>
        </table>      
    </div>
@endsection
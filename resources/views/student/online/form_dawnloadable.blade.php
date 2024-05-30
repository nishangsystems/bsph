@extends('student.printable')
@section('section')
    <div class="py-1">
        <table class="border border-light" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th colspan="3" class="text-capitalize text-center header font-weight-bold py-2 border-bottom border-dark">{{ __('text.inst_tapplication_form', ['degree'=>$degree->deg_name]) }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary"><b>@lang('text.personal_information')</b></th>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_name'):</span>
                            <span style="flex:auto; color:black;">{{ $application->name??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_gender'):</span>
                            <span style="flex:auto; color:black;">{{ $application->gender??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.date_of_birth'):</span>
                            <span style="flex:auto; color:black;">{{ $application->dob??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.place_of_birth'):</span>
                            <span style="flex:auto; color:black;">{{ $application->pob??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_nationality'):</span>
                            <span style="flex:auto; color:black;">{{ $application->nationality??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.region_of_origin'):</span>
                            <span style="flex:auto; color:black;">{{ $application->_region->region??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_division'):</span>
                            <span style="flex:auto; color:black;">{{ $application->_division->name??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_address'):</span>
                            <span style="flex:auto; color:black;">{{ $application->residence??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.phone_number'):</span>
                            <span style="flex:auto; color:black;">{{ $application->phone??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_email'):</span>
                            <span style="flex:auto; color:black;">{{ $application->email??auth('student')->user()->email??'' }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.marital_status'):</span>
                            <span style="flex:auto; color:black;">{{ $application->marital_status??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.special_needs'):</span>
                            <span style="flex:auto; color:black;">{{ $application->special_needs??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary"><b>@lang('text.additional_personal_details')</b></th>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.emergency_name_bilang'):</span>
                            <span style="flex:auto; color:black;">{{ $application->emergency_name??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.emergency_address_bilang'):</span>
                            <span style="flex:auto; color:black;">{{ $application->emergency_address??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.emergency_tel_bilang'):</span>
                            <span style="flex:auto; color:black;">{{ $application->emergency_tel??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary"><b>@lang('text.degree_slash_diploma_study_choice')</b></th>
                </tr>
                <tr>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.program_first_choice'):</span>
                            <span style="flex:auto; color:black;">{{ $program1->name??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.program_second_choice'):</span>
                            <span style="flex:auto; color:black;">{{ $program2->name??null }}</span>
                        </div>
                    </td>
                    <td class="border p-2">
                        <div style="display: flex; flex-wrap:wrap; word-break:break-all;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_level'):</span>
                            <span style="flex:auto; color:black;">{{ $application->level??null }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="p-0"><hr style="border-bottom: 6px double black; margin-block: 0.9rem; padding-block: 1.2rem; text-overflow:clip;" class="text-center"></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary"><b>@lang('text.education_qualification')</b></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary text-secondary"><b>@lang('text.ordinary_level_results')</b></th>
                </tr>
                <tr class="text-capitalize">
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.center_no'):</span>
                            <span style="flex:auto; color:black;">{{ $application->ol_center_number??null }}</span>
                        </div>
                    </th>
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.candidate_no'):</span>
                            <span style="flex:auto; color:black;">{{ $application->ol_candidate_number??null }}</span>
                        </div>
                    </th>
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_year'):</span>
                            <span style="flex:auto; color:black;">{{ $application->ol_year??null }}</span>
                        </div>
                    </th>
                </tr>
                <tr class="text-capitalize">
                    <th class="border" colspan="2">{{ trans_choice('text.word_subject', 1) }}</th>
                    <th class="border">@lang('text.word_grade')</th>
                </tr>
                @foreach (json_decode($application->ol_results)??[] as $key=>$result)
                    <tr>
                        <td class="border p-2" colspan="2">{{ $result->subject }}</td>
                        <td class="border p-2">{{ $result->grade }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-uppercase text-center heading py-2 border-top border-bottom border-secondary text-secondary"><b>@lang('text.advanced_level_results')</b></th>
                </tr>
                <tr class="text-capitalize">
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.center_no'):</span>
                            <span style="flex:auto; color:black;">{{ $application->al_center_number??null }}</span>
                        </div>
                    </th>
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.candidate_no'):</span>
                            <span style="flex:auto; color:black;">{{ $application->al_candidate_number??null }}</span>
                        </div>
                    </th>
                    <th class="border">
                        <div style="display: flex;">
                            <span style="flex:auto; color:gray; text-transform:capitalize">@lang('text.word_year'):</span>
                            <span style="flex:auto; color:black;">{{ $application->al_year??null }}</span>
                        </div>
                    </th>
                </tr>
                <tr class="text-capitalize">
                    <th class="border" colspan="2">{{ trans_choice('text.word_subject', 1) }}</th>
                    <th class="border">@lang('text.word_grade')</th>
                </tr>
                @foreach (json_decode($application->al_results)??[] as $key=>$result)
                    <tr>
                        <td class="border p-2" colspan="2">{{ $result->subject }}</td>
                        <td class="border p-2">{{ $result->grade }}</td>
                    </tr>
                @endforeach
                @if($application->previous_training != null)
                    <tr>
                        <th colspan="3" class="text-capitalize text-center heading py-2 border-top border-bottom border-secondary"><b>@lang('text.previous_higher_education_training')</b></th>
                    </tr>
                    <tr class="text-capitalize">
                        <th class="border">@lang('text.word_school')</th>
                        <th class="border">@lang('text.word_course')::@lang('text.word_year')</th>
                        <th class="border">@lang('text.word_certificate')</th>
                    </tr>
                    @foreach (json_decode($application->previous_training)??[] as $key=>$training)
                        <tr>
                            <td class="border p-2">{{ $training->school }}</td>
                            <td class="border p-2">{{ $training->course }}::{{ $training->year }}</td>
                            <td class="border p-2">{{ $training->certificate }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="3" class="p-0"><hr style="border-block: 6px double black; margin-block: 0.9rem; padding-block: 1.2rem; text-overflow:clip;" class="text-center"></td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center text-capitalize">
                        @lang('text.printed_date'): {{ now()->format('M d Y') }}
                    </td>
                </tr>
            </tfoot>
        </table>      
    </div>
@endsection
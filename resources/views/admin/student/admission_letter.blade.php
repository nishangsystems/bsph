@extends('admin.printable2')
@section('section')
    <div class="py-2">
        <span class="text-sm text-secondary text-capitalize">@lang('text.authorization_no'): {{ $auth_no??'----' }}</span>
        <hr class="border-bottom border-4 my-0 border-dark">
        <table style="table-layout: fixed;">
            <tr style="display: table-row;">
                <td class="border-right border-4 my-0 border-dark w-25">
                    <div>
                        <div class="row container-fluid">
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.word_chancellor')</b><br>
                                {{ $chancellor??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.pro_chancellor')</b><br>
                                {{ $p_chancellor??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.vice_chancellor')</b><br>
                                {{ $v_chancellor??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.DVC_academic_affairs_and_research')</b><br>
                                {{ $dvc1??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.DVC_administration_and_finanace')</b><br>
                                {{ $dvc2??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.DVC_cooperation_and_innovation')</b><br>
                                {{ $dvc3??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.word_registrar')</b><br>
                                {{ $registrar??'' }}
                            </div>
                        </div>
                    </div>
                </td>
                <td colspan="3" class="w-75">
                    <div>
                        <div class="d-flex my-1 py-1 justify-content-between">
                            <b>
                                <span class="text-capitalize">@lang('text.your_ref')</span>: _______________________ <br><br>
                                <span class="text-capitalize">@lang('text.our_ref')</span>:  <span style="">BUIB/AL/{{ $_program->prefix??'' }}/{{ $matric_sn??'' }}</span>
                            </b>
                            <b>
                                <span class="text-capitalize">@lang('text.word_date')</span>: <span style="text-decoration: underline;">{{ "  ".now()->format('d/m/Y')."  " }}</span>
                            </b>
                        </div>
                        <div class="my-1 py-1 text-capitalize">
                            <span>@lang('text.dear_titles') : <b>{{ $name??'' }}</b></span><br>
                            <span>@lang('text.matriculation_number') : <b>{{ $matric??'' }}</b></span>
                        </div>
                        <div class="my-1 py-1 text-uppercase">
                            <b>@lang('text.offer_of_admission')</b>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.admission_letter_text_block1', ['degree'=>$degree??'DEG', 'department'=>$fee['department']??'DEP', 'year'=>$year??'NO-YEAR', 'tution_fee'=>$fee['amount']??'FEE', 'first_installment'=>$fee['first_installment']??'1INST', 'reg_fee'=>$fee['registration']??'RG.FEE', 'fee_total'=>($fee['amount']+$fee['registration']??0), 'international'=>$fee['international_amount']])</span>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.the_tution_fee_amount_should_be_paid_at'):</span><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:2rem;">
                                <li><span class="text-capitalize">@lang('text.bank_name'):</span> <b class="text-uppercase">{{ $fee->bank_name??'----' }}</b></li>
                                <li><span class="text-capitalize">@lang('text.account_name'):</span> <b class="text-uppercase">{{ $fee->bank_account_name??'----' }}</b></li>
                                <li><span class="text-capitalize">@lang('text.account_number'):</span> <b class="text-uppercase">{{ $fee->bank_account_number??'----' }}</b></li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.at_registration_you_will_be_expected_to_do_the_following'):</span><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:2rem;">
                                <li>@lang('text.present_receipts_of_payment_of_registration_fees', ['bank_name'=>$fee->bank_name??'----'])</li>
                                <li>@lang('text.present_originals_of_certificates')</li>
                                <li>@lang('text.present_fee_receipts')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.offer_revoked_if'):</span><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:2rem;">
                                <li>@lang('text.you_cannot_produce_docs_on_time')</li>
                                <li>@lang('text.you_are_unable_to_satisfy_necessary_requirements')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.registration_commences_after_admission')</span>
                        </div>
                        <div class="my-1 py-1">
                            <b>@lang('text.start_of_lectures'): {{ $start_of_lectures??'' }}</b>
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="display: table-row;">
                <td class="border-right border-4 my-0 border-dark w-25"></td>
                <td colspan="3" class="w-75">
                    <div>
                        <div class="my-1 py-1">
                            <b>N.B:</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.admission_letter_NB1')</li>
                                <li>@lang('text.only_registered_students_will_be_allowed_in_class')</li>
                                <li>@lang('text.fee_paid_is_non_refundable')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.word_uniforms')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.see_school_for_design')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.word_shoe')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.shoe_specification1')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.school_needs')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.two_ream_of_papers_to_submit')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.sport_out_fit')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.white_tshirts')</li>
                                <li>@lang('text.tennis_shoe')</li>
                                <li>@lang('text.blue_shorts')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.practical_equipment')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.bp_therm')</li>
                                <li>@lang('text.surgical_sss')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <b class="text-uppercase" style="text-decoration:underline; ">@lang('text.book_list')</b><br>
                            <ul style="list-style-type: disc; margin-left:2rem; padding-left:4rem;">
                                <li>@lang('text.to_be_obtained_from_the_department')</li>
                            </ul>
                        </div>
                        <div class="my-1 py-1">
                            <span>@lang('text.admission_letter_summary_welcome_phrase')</span>
                        </div>
                        <div class="my-1 py-1">
                            <span class="text-capitalize">@lang('text.yours_sincerely')</span>,
                        </div>
                    </div>
                </td>
            </tr>
            <tr style="display: table-row;">
                <td class="border-right border-4 my-0 border-dark w-25"></td>
                <td class="w-25">
                    <div>
                        <div class="text-center my-1 py-1">
                            ______________ <br>
                            <b class="my-1 py-1 d-block">{{ $registrar??'' }}</b> <br>
                            <b class="text-capitalize">@lang('text.word_registrar')</b>
                        </div>
                    </div>
                </td>
                <td class="w-25"></td>
                <td class="w-25">
                    <div class="my-1 py-1">
                        <div class="position-relative">
                            <img src="{{ asset('assets/images/signature.png') }}" alt="" srcset="" style="height:16rem; width:20rem; position:absolute; bottom:-60%; left: -15%;">
                            <img src="{{ asset('assets/images/stamp.png') }}" alt="" srcset="" style="height:12rem; width:15rem;">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
@endsection
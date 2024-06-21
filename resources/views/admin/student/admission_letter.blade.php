@extends('admin.printable2')
@section('section')
    <div class="py-2">
        <span class="text-sm text-secondary text-capitalize">@lang('text.authorization_no'): {{ $auth_no??'----' }}</span>
        <hr class="border-bottom border-4 my-0 border-dark">
        <table style="table-layout: fixed">
            <tr style="text-align: left; align-content: start;">
                <td class="border-right border-4 margin-bottom-0 border-dark w-25 text-left">
                    <div class="">
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
                                {{ $dvc2??'' }}
                            </div>
                            <div class="my-2 py-2 col-sm-12 col-md-12 text-capitalize">
                                <b>@lang('text.DVC_administration_and_finanace')</b><br>
                                {{ $dvc1??'' }}
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
                        <table style="table-layout: fixed;">
                            <thead>
                                <th>
                                    <b>
                                        <span class="text-capitalize">@lang('text.your_ref')</span>: _________________ <br><br>
                                        <span class="text-capitalize">@lang('text.our_ref')</span>:  <span style="">BUIB/AL{{ $_year }}/{{ $_program->prefix??'' }}/{{ $matric_sn??'' }}</span>
                                    </b>
                                </th>
                                {{-- <th></th> --}}
                                <th class="d-flex justify-content-end text-right">
                                    <b>
                                        <span class="text-capitalize">@lang('text.word_date')</span>: <span style="text-decoration: underline;">{{ "  ".now()->format('d/m/Y')."  " }}</span>
                                    </b>
                                </th>
                            </thead>
                        </table>
                        <div class="my-1 py-1 text-capitalize">
                            <span>@lang('text.dear_titles') : <b>{{ $name??'' }}</b></span><br>
                            <span>@lang('text.matriculation_number') : <b>{{ $matric??'' }}</b></span>
                        </div>
                        <div class="my-1 py-1 text-uppercase">
                            <b>@lang('text.offer_of_admission')</b>
                        </div>
                        <div class="my-1 py-1">
                            <span> {!! 
                                    __(
                                        'text.admission_letter_text_block1', 
                                        [
                                            'degree'=>($degree??'DEG'), 
                                            'department'=>($fee['department']??'DEP'), 
                                            'year'=>($year??'NO-YEAR'), 
                                            'tution_fee'=>number_format($fee['amount']??0), 
                                            'first_installment'=>number_format($fee['first_installment']??0), 
                                            'reg_fee'=>number_format($fee['registration']??0), 
                                            'fee_total'=>number_format(($fee['amount']??0)+($fee['registration']??0)), 
                                            'international'=>number_format($fee['international_amount']??0)
                                        ]
                                    )
                                 !!}
                            </span>
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
                                <li>{!! __('text.present_receipts_of_payment_of_registration_fees', ['bank_name'=>$fee->bank_name??'----']) !!}</li>
                                <li>{!! __('text.present_originals_of_certificates') !!}</li>
                                <li>{!! __('text.present_fee_receipts') !!}</li>
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
                                <li>{!! __('text.admission_letter_NB1') !!}</li>
                                <li>@lang('text.only_registered_students_will_be_allowed_in_class')</li>
                                <li>@lang('text.fee_paid_is_non_refundable')</li>
                            </ul>
                        </div>
                        {!! $page2->content??'' !!}
                    </div>
                </td>
            </tr>
            <tr style="display: table-row;">
                <td class="border-right border-4 my-0 border-dark w-25"></td>
                <td class="w-25">
                    <div class="my-1 py-1">
                        <div class="position-relative">
                            <div id="sign_box">
                                <img src="{{ asset('assets/images/stamp.png') }}" alt="" srcset="" style="height:12rem; width:15rem;">
                            </div>
                            <img src="{{ asset('assets/images/signature.png') }}" alt="" srcset="" style="height:16rem; width:20rem; position:absolute; bottom:-60%; left: -15%;">
                        </div>
                    </div>
                </td>
                <td class="w-25"></td>
                <td class="w-25"></td>
            </tr>
        </table>
    </div>
@endsection
@section('style')
    <style>
        #sign_box{
            height:17rem; 
            width:20rem; 
            background-image: url("{{ asset('assets/images/signature.png') }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: left bottom;
            padding-left:4rem;
        }
    </style>
@endsection
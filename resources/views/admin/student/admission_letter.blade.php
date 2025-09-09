@extends('admin.printable2')
@section('style')
    <style>
        #page2{
            page-break-before: always;
            page-break-inside: avoid;
            page-break-after: auto;
        }

        #page2 table td, #page2 table th{
            padding-block: 0;
        }

        @media print {
            #page2{
                page-break-before: always;
                page-break-inside: avoid;
                page-break-after: auto;
            }

            #page2 table td, #page2 table th{
                padding-block: 0;
            }
        }

    </style>
@endsection
@section('section')
    <div class="p-2 container-fluid" style="padding-inline: 4.5rem !important;">
        <div style="text-align: center; text-transform: uppercase; font-weight: 600; font-size: large;">Provisional admission letter</div>
        <table style="table-layout: fixed;" cellpadding="5px;" cellspacing="0">
            <thead>
                <tr>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="">Ref: </th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="3"><b>{{ $auth_no }}</b> </th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="2">Date: <b>{{ $appl->admitted_at->format('M dS Y') }}</b></th>
                </tr>
                <tr>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="">Program of Study:</th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="3"><b>{{ $program??'' }}</b></th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="2">Duration: <b>{{ $filters->where('program', $_program->id)->first()['duration']??'#' }} years</b></th>
                </tr>
                <tr>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="">Accademic Year:</th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="3"><b>{{ $appl->year?->name??'' }}</b></th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="2"></th>
                </tr>
                <tr>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="5">Dear {{ $name??'' }} [{{ $matric??'' }}]</th>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan=""></th>
                </tr>
                <tr>
                    <th style="padding: 0.3rem auto; maring: 0;" colspan="6" style="text-align: center; font-weight: 600; font-size: large; text-transform: uppercase;"> admission into {{ $_program->name??'' }} </th>
                </tr>
            </thead>
        </table>
        <hr style="border: 2px solid gray;">
        <p>With reference to your application, to offer you admission into the BSPH to pursue a <span style="text-transform: lowercase;">({{ $filters->where('program', $_program->id)->first()['duration']??'#' }}) {{ \App\Helpers\Helpers::instance()->numToWord($filters->where('program', $_program->id)->first()['duration']??0) }}-year</span> <b style="text-transform: capitalize;"> {{ $_program->name }}</b></p>
        <p>This selection is based on available information that you have satisfied the Entry Requirements for the above-mentioned program of study. Should the information you have provided be found at any time to be false or should you be found to be deficient in the entry requirements during your study, you will be dismissed from the Institution.</p>
        <p>You are required to be of good character for the full duration of your program of study. You may be withdrawn from the Institution at any time for unsatisfactory academic work or gross misconduct, pursuant to the statutes of the Institution.</p>
        <p>The admission is subject to your ability to pay all fees in full promptly. You are required to pay  the 1st installment according to the fee structure attached on or  before the day of resumption of classes. The amount to be paid is detailed in the schedule of fees attached.</p>
        <p>The fees for subsequent academic years are subject to change (as the need arises). Should you default at any time during study you would be withdrawn. Note that Fees paid are NOT REFUNDABLE.  Your final un-conditional admission offer will be subject to a review Jury of the <b>{{ $filters->where('program', $_program->id)->first()['mentor']??'' }}</b></p>
        <p>You are expected to have the student’s handbook.</p>
        <p>Resumption date is {{ $start_of_lectures }}. </p>
        <p>Yours sincerely,</p>
        <p>Dr. Nkuoh Godlove <br> Academic Dean </p>
        <p>Baptist School of Public Health</p>

        <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 900; font-style: italic;">Nuturing Excellence, Exemplifying Professionalism</div>

        <div id="page2">
            <table cellspacing="0" style="table-layout: fixed; font-size: 1rem;" cellpadding="0">
                <tbody>
                    {{-- 9 columns in total --}}
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="3">@lang('text.academic_year')</th>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="6">{{ $appl->year?->name??'' }}</td>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="3">student’s name</th>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="6">{{ $appl->name??'' }}</td>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="3">@lang('text.word_matricule')#</th>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="6">{{ $appl->matric??'' }}</td>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="3">Program admitted into</th>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="6">{{ $program??'' }}</td>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 0px; text-transform: uppercase; padding-block: 1rem;" colspan="9">fee structure</th>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">@lang('text.sn')</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Item description</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">Price (@lang('text.currency_cfa'))</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">Total (Inc.) (@lang('text.currency_cfa'))</th>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;"></th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="4">breakdown of fees</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="4"></th>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">1</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Academic Fees / Tuition</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format($fee_structure['amount']??0) }}</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format($fee_structure['amount']??0) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;"></td>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">total</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format($fee_structure['amount']??0) }}</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format($fee_structure['amount']??0) }}</th>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;"></td>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: uppercase;" colspan="4">other fees</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2"></th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2"></th>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">1</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Sport Waer</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">2</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">T-Shirts</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">3</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Maintenance Fees</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">10,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">10,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">4</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Library fees</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">5</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Medical insurance</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">5,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">6</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Student Union Dues</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">2,000</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">2,000</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;">7</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Student ID Card</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">1,500</td>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">1,500</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;"></td>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">total</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">33,500</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">33,500</th>
                    </tr>
                    <tr>
                        <td style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;"></td>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="4">Grand total</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format(($fee_structure['amount']??0) + 33500) }}</th>
                        <th style="padding: 0.1rem auto; border: 1px solid gray; text-transform: capitalize;" colspan="2">{{ number_format(($fee_structure['amount']??0) + 33500) }}</th>
                    </tr>
                    <tr>
                        <th colspan="9">NB: Students who are opportune to lodge in the school hostel will be asked to pay a separate amount. <br><br>STATEMENT OF FEES <br> Dear student, Baptist School of Public Health is Pleased to issue you a fee statement as below:  </th>
                    </tr>
                    <tr>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">fee type</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">actual fee</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">Other payments</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">total fee</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">payment date</th>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">Admission processing fees</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">At the time of admission</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">Tuition Fees - Year 1</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">{{ number_format($fee_structure['amount']??0) }}</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">33,500</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">{{ number_format(($fee_structure['amount']??0) + 33500) }}</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">As per respective installments</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">1st installment</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">{{ number_format( $fee_structure['first_instalment']??0) }}</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">On or before 31st October of {{ $year + $instalments[0]['year']}}</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">2nd installment</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">{{ number_format( $fee_structure['second_instalment']??0) }}</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">28TH January {{ $year + $instalments[1]['year']}}</td>
                    </tr>
                    <tr>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">3rd installment</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">{{ number_format( $fee_structure['third_instalment']??0) }}</td>
                        <td style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">30TH March {{ $year + $instalments[2]['year']}}</td>
                    </tr>
                    <tr>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2">total</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="1">{{ number_format( ($fee_structure['amount']??0) + 33500) }}</th>
                        <th style="text-transform: uppercase; padding: 0.1rem auto; border: 1px solid gray;" colspan="2"></th>
                    </tr>
                    <tr>
                        <th style="padding: 0.1rem auto; border: 0;" colspan="9">
                            PAYMENT INTO UNION BANK OF CAMEROON (UBC) ACCOUNT#: 10023-00030-00313014774-68 ACCOUNT <br> NAME: BAPTIST SCHOOL OF PUBLIC HEALTH (BSPH) OR	 IN ANY CBC BURSARY INTO ACCOUNT # 705200/638
                        </th>
                    </tr>
                    <tr><td colspan="9" style="padding: 0.1rem auto; border: 0;"><br> NOTE:  FEES PAID IN IS NON-REFUNDABLE</td></tr>
                </tbody>
            </table>
            <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 900; font-style: italic;">Nuturing Excellence, Exemplifying Professionalism</div>
        </div>
    </div>
@endsection
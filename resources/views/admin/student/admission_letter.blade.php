@extends('admin.printable2')
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
        <p>The fees for subsequent academic years are subject to change (as the need arises). Should you default at any time during study you would be withdrawn. Note that Fees paid are NOT REFUNDABLE.  Your final un-conditional admission offer will be subject to a review Jury of the {{ $filters->where('program', $_program->id)->first()['mentor']??'' }}</p>
        <p>You are expected to have the student’s handbook.</p>
        <p>Resumption date is {{ $start_of_lectures }}. </p>
        <p>Yours sincerely,</p>
        <p>Dr. Nkuoh Godlove <br> Academic Dean </p>
        <p>Baptist School of Public Health</p>

        <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 800; font-style: italic;">Nuturing Excellence, Exemplifying Professionalism</div>
    </div>
@endsection
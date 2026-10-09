@extends('admin.printable2')

@section('style')
<style>
    /* @page {
        size: A4;
        margin: 12mm 14mm 20mm;
    }*/

    * {
        box-sizing: border-box;
    }

    .p-2.container-fluid {
        width: 100%;
        max-width: 100%;
        padding-left: 0;
        padding-right: 0;
    }

    .admission-document {
        position: relative;
        width: 100%;
        font-family: "Times New Roman", serif;
        font-size: 12pt;
        line-height: 1.55;
        color: #111;
        background: #fff;
    }

    /* Institutional watermark */
    .admission-watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 145mm;
        height: 145mm;
        transform: translate(-50%, -50%);
        opacity: .055;
        z-index: 0;
        pointer-events: none;
    }

    .admission-watermark img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .admission-content {
        position: relative;
        z-index: 1;
    }

    .admission-top-border {
        border-top: 3px double #8889a7;
        margin-bottom: 25px;
    }

    .service-note {
        color: #8589a7;
        font-style: italic;
        font-size: 11pt;
        margin-bottom: 15px;
    }

    .admission-title {
        text-align: center;
        font-size: 22pt;
        font-weight: normal;
        line-height: 1.3;
        margin: 15px 0 5px;
    }

    .admission-date {
        text-align: right;
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 11pt;
        margin-bottom: 8px;
    }

    .admission-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 10px;
        font-family: Arial, sans-serif;
        font-size: 11pt;
        font-weight: bold;
    }

    .admission-details .right {
        text-align: right;
    }

    .student-greeting {
        margin-top: 10px;
        font-family: Arial, sans-serif;
        font-size: 11pt;
        font-weight: bold;
    }

    .student-greeting .placeholder {
        color: red;
    }

    .admission-separator {
        border: 0;
        border-top: 5px solid #888;
        margin: 10px 0 25px;
    }

    .admission-body {
        font-size: 12pt;
        line-height: 1.65;
        text-align: justify;
    }

    .admission-body p {
        margin: 0 0 7px;
    }

    .admission-conditions {
        padding-left: 25px;
        margin: 5px 0 10px;
    }

    .admission-conditions li {
        padding-left: 7px;
        margin-bottom: 5px;
        text-align: justify;
    }

    /* Combined seal and signature */
    .registrar-block {
        display: flex;
        align-items: flex-start;
        margin-top: 18px;
        break-inside: avoid;
        page-break-inside: avoid;
    }

    .registrar-combined-image {
        display: block;
        width: 105mm;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        object-position: left top;
    }


    /* Page two content */
    #page2 {
        page-break-before: always;
        page-break-inside: auto;
        page-break-after: auto;
        position: relative;
        width: 100%;
        max-width: 100%;
        padding-bottom: 20mm;
        word-wrap: break-word;
    }

    .pstart{
        page-break-before: always;
        page-break-inside: auto;
        page-break-after: auto;
    }

    #page2 * {
        max-width: 100% !important;
    }

    #page2 table {
        width: 100% !important;
        table-layout: fixed;
    }

    #page2 table td,
    #page2 table th {
        padding-block: 0;
    }

    @media screen {
        .admission-document {
            /* max-width: 182mm; */
            margin: 0 auto;
            padding-bottom: 4mm;
        }

    }

    @media print {
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .p-2.container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .admission-document {
            width: 100%;
            margin: 0;
        }

        .admission-body p,
        .admission-conditions li {
            orphans: 3;
            widows: 3;
        }

        .registrar-block {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        #page2 {
            page-break-before: always;
            page-break-inside: auto;
        }

        #page2 table td,
        #page2 table th {
            padding-block: 0;
            word-wrap: break-word;
        }
    }
</style>
@endsection

@section('section')

<div class="p-2 container-fluid">


    {{-- FIRST PAGE: PROVISIONAL ADMISSION LETTER --}}
    <div class="admission-document">

        <div class="admission-watermark">
            <img src="{{ $logo }}" alt="">
        </div>

        <div class="admission-content">

            <div class="admission-top-border"></div>

            <div class="service-note">
                Service Note No.:
                {{ $auth_no ?: '...........................................................' }}
            </div>

            <h1 class="admission-title">
                PROVISIONAL ADMISSION LETTER
            </h1>

            <div class="admission-date">
                Date: {{ $appl->admitted_at->format('M dS Y') }}
            </div>

            <div class="admission-details">
                <div>
                    Programme of Study: {{ $program }}
                </div>

                <div></div>

                <div>
                    Academic Year: {{ $appl->year?->name??'' }}
                </div>

                <div class="right">
                    Duration: {{ $duration }} @lang('text.word_years')
                </div>
            </div>

            <div class="student-greeting">
                Dear
                <span class="placeholder">{{ $name }}</span>,
                <span class="placeholder">{{ $matric }}</span>
            </div>

            <hr class="admission-separator">

            <div class="admission-body">

                <p>
                    Congratulations! We are pleased to inform you of your
                    admission into the <strong>{{ $duration }}-year</strong>
                    {{ $_degree->deg_name }}, <strong>{{ $program }}</strong> at the School of
                    Public Health (BSPH), Cameroon Baptist University
                    Institute (CBUI), Mutengene, for the
                    {{ $appl->year?->name??'' }} academic year.
                </p>

                <p>
                    You have been selected following a review of your
                    academic credentials. Resumption date is
                    <strong>{{ $start_of_lectures }}</strong> at
                    <strong>7:00am prompt</strong>. This will begin with a
                    <strong>compulsory</strong> orientation, which is
                    crucial to your stay at BSPH.
                </p>

                <p>
                    Your acceptance to the school is
                    <strong>conditional</strong> upon fulfilling the
                    following:
                </p>

                <ol class="admission-conditions">
                    <li>
                        Payment of a non-refundable first installment fee
                        deposit of <strong>{{ \App\Helpers\Helpers::instance()->numToWord(intval($fee_structure['first_instalment'])) }} CFA
                        ({{ number_format($fee_structure['first_instalment']) }})</strong> on or before
                        <strong>November 15, {{ substr($appl->year?->name??'', 0, 4) }}</strong>. You may make
                        this payment as well as any other payments into
                        the following bank accounts: Union Bank of
                        Cameroon (UBC), Account number:
                        <strong>10023-00030-00313014774-68</strong>,
                        Account Name: Baptist School of Public Health
                        (BSPH), or at any CBC Bursary, into Account
                        <strong>705200/638</strong>. Attached is your fee
                        payment schedule that must be strictly respected.
                    </li>

                    <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 900; font-style: italic;">
                        <img src="{{ $footerLogosPath }}" alt="Institutional logos" style="width: 100%; height: auto; max-height: 11rem;">
                    </div>

                    <li class="pstart">
                        Submission of all original copies of your
                        academic certificates, transcripts/slips and
                        other relevant documents to the Registrar's
                        office for verification. Any case of falsification
                        will lead to withdrawal of this admission.
                    </li>

                    <li>
                        Completion of a medical examination by an
                        authorized Physician of the CBC Health Services.
                        A Medical Examination Form should be collected
                        from the school secretariat upon resumption.
                    </li>
                </ol>

                <p class="">
                    CBUI is a Christian Institution of higher learning
                    dedicated to academic excellence and godly character.
                    You may therefore be withdrawn from the school at
                    any time in case of unsatisfactory academic progress
                    or misconduct.
                </p>

                <p>
                    If you have any concerns about this offer, do not
                    hesitate to contact the School Administration.
                </p>

                <p>
                    On behalf of our Faculty, Staff and Students, we
                    heartily welcome you to the Cameroon Baptist
                    University Institute and we wish you great success
                    in your stay here.
                </p>

            </div>

            {{-- Single combined registrar image --}}
            <div class="registrar-block">
                <img
                    class="registrar-combined-image"
                    src="{{ $seal }}"
                    alt="Registrar's seal and signature"
                >
            </div>

        </div>
    </div>
    <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 900; font-style: italic;">
        <img src="{{ $footerLogosPath }}" alt="Institutional logos" style="width: 100%; height: auto; max-height: 11rem;">
    </div>

    {{-- SECOND PAGE: EXISTING DYNAMIC CONTENT --}}
    <div id="page2" class="pstart">
        {!! $page2->content ?? '' !!}
    </div>

    <div style="position: absolute; bottom: 0; top: auto; right: 0; font-size: large; font-weight: 900; font-style: italic;">
        <img src="{{ $footerLogosPath }}" alt="Institutional logos" style="width: 100%; height: auto; max-height: 11rem;">
    </div>

</div>
@endsection

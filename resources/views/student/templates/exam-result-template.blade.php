@extends('student.printable')
@section('section')
    <table>
        <thead>
            @php
                $program_name = $user->first()->name;
                $current_year_name = \App\Models\Batch::find($year)->name;
                $current_semester = $semester->id;
                $current_semester_name = $semester->name;
                $flag = true;
            @endphp
            <tr class="py-3 h4 my-0">
                <th colspan="9" class="text-center">
                    {{$semester->name .' '.$current_year_name. ' '.__('text.individual_results_slip') }}
                </th>
            </tr>
            <tr>
                <th colspan="9" class="px-0 py-0">
                    <table>
                        <tr class="border-top border-bottom">
                            <td>
                                <table>
                                    <thead style="font-weight: 700; font-size: large;">
                                        <tr>
                                            <td class="text-capitalize fw-bold h4 col-sm-4">{{__('text.word_name')}} :</td>
                                            <td class="col-sm-8 h4 text-uppercase fw-bolder">{{$user->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-capitalize fw-bold h4 col-sm-4">{{__('text.word_program')}} :</td>
                                            <td class="col-sm-8 h4 text-uppercase fw-bolder">{{$class->program->name}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-capitalize fw-bold h4 col-sm-4">{{__('text.word_matricule')}} :</td>
                                            <td class="col-sm-8 h4 text-uppercase fw-bolder">{{$user->matric}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-capitalize fw-bold h4 col-sm-4">{{__('text.word_level')}} :</td>
                                            <td class="col-sm-8 h4 text-uppercase fw-bolder">{{ $class->level->level}}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </td>
                            <td>
                                <div class=" px-0 py-0">
                                    <table >
                                        <!-- <thead class="text-primary">
                                            <th>Grd</th>
                                            <th colspan="2">Range</th>
                                            <th>Wt</th>
                                            <th>Rmk</th>
                                        </thead> -->
                                        @foreach($grading as $grd)
                                            <tr class="pb-1 pt-0" style="text-decoration: none; font-size:x-small">
                                                <td class="py-0">{{($grd->grade ?? '')}}</td>
                                                <td class="py-0">{{($grd->lower ?? '')}}</td>
                                                <td class="py-0">{{($grd->upper ?? '')}}</td>
                                                <td class="py-0">{{($grd->weight ?? '')}}</td>
                                                <td class="py-0">{{($grd->remark ?? '')}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr class="text-capitalize">
                <th class="text-center d-flex" >{{__('text.word_code')}}</th>
                <th class="text-center" >{{__('text.word_course')}}</th>
                <th class="text-center" >ST</th>
                <th class="text-center" >CV</th>
                <th class="text-center" >{{__('text.CA').' / '.$ca_total}}</th>
                <th class="text-center" >{{__('text.word_exams').' / '.$exam_total}}</th>
                <th class="text-center" >{{__('text.word_total') .' / '.($ca_total + $exam_total)}}</th>
                <th class="text-center" >{{__('text.word_grade')}}</th>
                <th class="text-center" >{{__('text.word_remarks')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $subject)
                <tr class="border-top border-bottom border-secondary border-dashed">
                    <td class="border-left border-right border-light">{{$subject['code']}}</td>
                    <td class="border-left border-right border-light">{{$subject['name']}}</td>
                    <td class="border-left border-right border-light">{{$subject['status']}}</td>
                    <td class="border-left border-right border-light">{{$subject['coef']}}</td>
                    <td class="border-left border-right border-light">{{$subject['ca_mark']}}</td>
                    <td class="border-left border-right border-light">{{$subject['exam_mark']}}</td>
                    <td class="border-left border-right border-light">{{$subject['total']}}</td>
                    <td class="border-left border-right border-light">{{$subject['grade']}}</td>
                    <td class="border-left border-right border-light">{{$subject['remark']}}</td>
                </tr>
            @endforeach
            <tr class="border border-secondary text-capitalize h4 fw-bolder">
                <td colspan="4" class="text-center">{{__('text.total_courses_attempted')}} : <span class="px-3">{{count($results)}}</span></td>
                <td colspan="5" class="text-center">{{__('text.total_courses_passed')}} : <span class="px-3">{{collect($results)->where('total', '>=', 50)->count()}}</span></td>
            </tr>
            <tr class="border border-secondary text-capitalize h4 fw-bolder" style="font-size: medium; font-weight: 500;">
                <td colspan="3" class="border-0">
                    <!-- <span class="d-flex">{{__('text.total_credits_attempted')}} : {{$gpa_data['sum_cv']}}</span>
                    <span class="d-flex">{{__('text.gpa_credits_attempted')}} : {{$gpa_data['gpa_cv']}}</span> -->
                </td>
                <td colspan="7" class="border-0">
                    <!-- <span class="d-flex">{{__('text.total_credits_earned')}} : {{$gpa_data['sum_cv_earned']}}</span>
                    <span class="d-flex">{{__('text.gpa_credits_earened')}} : {{$gpa_data['gpa_cv_earned']}}</span> -->
                    <span class="d-flex py-3">{{__('text.semester_gpa')}} : {{number_format($gpa_data['gpa'], 2)}}</span>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
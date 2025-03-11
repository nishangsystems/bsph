@extends('admin.layout')

@section('section')
    <div class="w-100 py-3">
        <form>
            <!-- @csrf -->
            <div class="">
                <div class="py-2 form-group row">
                    <label for="" class="text-secondary h6 fw-bold col-sm-3 text-capitalize">{{__('text.filter_statistics_by')}}</label>
                    <div class="col-sm-9">
                        <select name="filter" id="" class="form-control text-uppercase" required>
                            <option value=""></option>
                            <option value="degree" {{request('filter') == 'degree' ? 'selected' : ''}}>{{__('text.word_degree')}}</option>
                            <option value="program" {{request('filter') == 'program' ? 'selected' : ''}}>{{__('text.word_program')}}</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex flex justify-content-end">
                    <input type="submit" name="" id="" class=" btn btn-primary btn-sm" value="get statistics">
                </div>
            </div>
        </form>
        <div class="mt-5 pt-2">
            
            <table class="table">
                <thead class="text-capitalize border-bottom border-2 border-danger">
                    @php($count = 1)
                    <tr class="shadow-sm">
                        <th class="bg-primary text-white border-right" colspan="2">@lang('text.word_total')</th>
                        <th class="bg-primary text-white border-right" colspan="3">{{$forms->sum('_count')}}</th>
                        <th class="bg-primary text-white border-right"></th>
                        <th class="bg-primary text-white border-right">{{$forms->sum('total')}}</th>
                    </tr>
                    <tr>
                        <th class="bg-dark text-white">##</th>
                        @if (request('filter') == 'degree')
                            <th class="bg-info text-white">{{__('text.word_degree')}}</th>
                        @else
                            <th  class="bg-info text-white">{{__('text.word_program')}}</th>
                        @endif
                        <th class="bg-info text-white">{{__('text.word_count')}}</th>
                        <th class="bg-info text-white">{{__('text.word_males')}}</th>
                        <th class="bg-info text-white">{{__('text.word_females')}}</th>
                        <th class="bg-dark text-white">@lang('text.unit_cost')</th>
                        <th class="bg-dark text-white">@lang('text.total_paid')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forms ?? [] as $form)

                        <tr class="border-bottom border-dark shadow-sm" style="background-color: rgba(243, 243, 252, 0.4);">
                            <td class="bg-dark text-white">{{$count++}}</td>
                            <td class="">{{ request('filter') == 'degree' ? $form->degree : $form->program }}</td>
                            <td class="">{{ $form->_count??'' }}</td>
                            <td class="bg-dark text-white">{{ $form->male_count??'' }}</td>
                            <td class="bg-dark text-white">{{ $form->female_count??'' }}</td>
                            <td class="bg-dark text-white">{{ $form->amount??'' }}</td>
                            <td class="bg-dark text-white">{{ $form->total??'' }}</td>
                            {{-- <td class="">
                                <a href="#" class="btn btn-sm rounded text-capitalize btn-primary"><span class="mr-2 fa fa-download"></span>@lang('text.word_download')</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

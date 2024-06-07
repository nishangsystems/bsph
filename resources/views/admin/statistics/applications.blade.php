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
            
            <table class="table table-stripped">
                <thead class="bg-secondary text-black text-capitalize">
                    @php($count = 1)
                    <th>##</th>
                    @if (request('filter') == 'degree')
                        <th>{{__('text.word_degree')}}</th>
                    @else
                        <th>{{__('text.word_program')}}</th>
                    @endif
                    <th>{{__('text.word_total')}}</th>
                </thead>
                <tbody>
                    @foreach($forms ?? [] as $form)

                        <tr class="border-bottom border-dark" style="background-color: rgba(243, 243, 252, 0.4);">
                            <td class="border-left border-right">{{$count++}}</td>
                            <td class="border-left border-right">{{ request('filter') == 'degree' ? $form->degree : $form->program }}</td>
                            <td class="border-left border-right">{{ $form->_count??'' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

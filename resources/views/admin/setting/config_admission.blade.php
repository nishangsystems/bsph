@extends('admin.layout')
@section('section')
    <div class="py-3">
        <form enctype="multipart/form-data" method="post">
            @csrf
            <div class="row py-5">
                <div class="col-sm-12 col-md-4 col-lg-3 py-2 text-uppercase">
                    <span class="form-control text-danger" style="font-weight:800;">{{ \App\Models\Batch::find(\App\Helpers\Helpers::instance()->getCurrentAccademicYear())->name }}</span>
                    <label class="text-secondary text-capitalize">{{ __('text.word_year') }}</label>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 py-2">
                    <input class="form-control" name="start_date" required type="datetime-local" value="{{ $current_session != null ? $current_session->start_date : null }}">
                    <label class="text-secondary text-capitalize">{{ __('text.start_date') }}</label>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 py-2">
                    <input class="form-control" name="end_date" required type="datetime-local" value="{{ $current_session != null ? $current_session->end_date : null }}">
                    <label class="text-secondary text-capitalize">{{ __('text.end_date') }}</label>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 py-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-sm btn-primary text-uppercase">{{ __('text.word_update') }}</button>
                </div>
            </div>
        </form>
        <div class="py-3">
            <table class="table bg-light">
                <thead class="text-uppercase bg-light">
                    <th class="border-left border-right">{{ __('text.sn') }}</th>
                    <th class="border-left border-right">{{ __('text.word_year') }}</th>
                    <th class="border-left border-right">{{ __('text.start_date') }}</th>
                    <th class="border-left border-right">{{ __('text.end_date') }}</th>
                </thead>
                <tbody>
                    @php($k = 1)
                    @foreach ($sessions as $ssn)
                        <tr class="border-bottom">
                            <td class="border-left border-right">{{ $k++ }}</td>
                            <td class="border-left border-right">{{ $ssn->batch->name }}</td>
                            <td class="border-left border-right">{{ $ssn->start_date }}</td>
                            <td class="border-left border-right">{{ $ssn->end_date }}</td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
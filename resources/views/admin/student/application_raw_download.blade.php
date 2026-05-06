@extends('admin.layout')
@section('section')
    <div class="container-fluid">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <select name="year_id" required class="form-control" >
                        @foreach($years as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-capitalize">@lang('text.academic_year')</span>
                </div>
                <div class="col-sm-6">
                    <button type="submit" name="download" value="1" class="btn btn-sm btn-primary text-capitalize"><i class="fa fa-download"></i> @lang('text.word_download')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
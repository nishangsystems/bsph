@extends('admin.layout')
@section('section')
    <div class="py-3">
        <form method="post" action="{{ route('admin.applications._change.program', $application->id) }}">
            @csrf
            <input type="hidden" name="matric" value="{{ $matricule }}">
            <div class="col-sm-12 col-md-11 col-lg-9 mx-auto">
                <div class="row text-capitalize">
                    <div class="col-sm-8 col-md-5 col-lg-5">
                        <label class="text-secondary text-capitalize">{{ __('text.word_name') }}</label>
                        <div><label class="form-control">{{ $application->name }}</label></div>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-3">
                        <label class="text-secondary text-capitalize">{{ __('text.word_gender') }}</label>
                        <div><label class="form-control">{{ $application->gender }}</label></div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label class="text-secondary text-capitalize">{{ __('text.word_campus') }}</label>
                        <div><label class="form-control">{{ $campus->name }}</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <label class="text-secondary text-capitalize">{{ __('text.program_of_choice') }}</label>
                        <div><label class="form-control">{{ $program->name }}</label></div>
                    </div>
                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                    <input type="hidden" name="level" value="{{ $level }}">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <label class="text-secondary text-capitalize">{{ __('text.word_matricule') }}</label>
                        <div><label class="form-control">{{ $matricule }}</label></div>
                    </div>
                </div>
                <div class="d-flex justify-content-end py-2 text-capitalize">
                    <button class="btn btn-sm btn-primary" type="submit">{{ __('text.word_confirm') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
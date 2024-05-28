@extends('admin.layout')
@section('section')
    <div class="py-2">
        <form method="POST">
            <div class="border-top border-bottom border-dark py-3 bg-light container-fluid">
                <div class="m-4 rounded border p-3 bg-white">
                    <div class="my-2">
                        <span class="text-secondary title text-capitalize mb-1">@lang('text.word_program')</span>
                        <label class="form-control">{{ $program->name??'' }}</label>
                    </div>
                    <div class="my-2">
                        <span class="text-secondary title text-capitalize mb-1">@lang('text.word_content')</span>
                        <div class="text-editor"><div>
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary rounded" type="submit">@lang('text.word_save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
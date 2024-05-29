@extends('admin.layout')
@section('section')
    <div class="py-2">
        <form method="POST">
            @csrf
            <div class="border-top border-bottom border-dark py-3 bg-light container-fluid">
                <div class="m-4 rounded border p-3 bg-white">
                    <div class="my-2">
                        <span class="text-secondary title text-capitalize mb-1">@lang('text.word_program')</span>
                        <label class="form-control rounded">{{ $program->name??'' }}</label>
                    </div>
                    <div class="my-2">
                        <span class="text-secondary title text-capitalize mb-1">@lang('text.word_content')</span>
                        <textarea class="tinymce-editor form-control" name="content">
                            {!! $page2->content??'' !!}
                        </textarea><!-- End TinyMCE Editor -->

                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary rounded" type="submit">@lang('text.word_save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
@extends('admin.layout')
@section('section')
    <div class="py-2 container-fluid">
        <div class="card my-4">
            <div class="card-header text-center text-uppercase">
                <strong>@lang('text.word_matricule')</strong>
            </div>
            <div class="card-body">
                <form method="get">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control rounded" name="matric" id="" required>
                        </div>
                        <div class="col-md-3 d-flex justify-content-end">
                            <span><button class="btn btn-primary rounded btn-xs" type="submit">{{trans_choice('text.word_student', 1)}}</button></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
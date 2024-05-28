@extends('admin.layout')
@section('section')
    <div class="py-3">
        <form method="POST">
            @csrf
            <div class="alert-light py-2 border-top border-bottom border-dark d-flex">
                <div cass="d-flex"><span><input type="checkbox" class="input input-lg mx-2 checkbox" id="check_all_checkbox" onchange="checkAll(this)"></span>check all</div>
                <div class="text-center h4 text-capitalize col-md-9"><b>@lang('text.set_appliable_programs')</b></div>
            </div>
            <div class="container-fluid my-2">
                @php
                    $k = 1;
                @endphp
                @foreach ($programs as $program)
                    <div class="row py-2 border-bottom border-secondary {{ ($program->appliable??'') == 1 ? 'alert-info': '' }}">
                        <div class="col-sm-1">{{ $k++ }}</div>
                        <div class="col-sm-3"><input type="checkbox" name="programs[]" value="{{ $program->id??'' }}" class="checkbox input ap-item" {{ ($program->appliable??'') == 1 ? 'checked' : ''}}></div>
                        <div class="col-sm-8">{{ $program->name??'' }}</div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-end py-2">
                <button class="btn btn-primary btn-sm rounded text-capitalize">@lang('text.word_update')</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        let checkAll = function(element){
            console.log($(element).val());
            let obj = $('.ap-item');
            if($(element).is(':checked')){
                console.log('Checked!');
                for (let index = 0; index < obj.length; index++) {
                    const element = obj[index];
                    $(element).prop('checked', true);
                }
            }else{
                for (let index = 0; index < obj.length; index++) {
                    const element = obj[index];
                    $(element).prop('checked', false);
                }
            }
        }
    </script>
@endsection
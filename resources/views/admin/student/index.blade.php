@extends('admin.layout')

@section('section')
@php
    $year = request('year') ?? \App\Helpers\Helpers::instance()->getCurrentAccademicYear();
@endphp

<div class="col-sm-12">
    <div class="col-lg-12">
        <form method="get">
            <div class="input-group-merge d-flex rounded border border-dark my-3">
                <select class="form-control col-sm-10" name="year">
                    <option></option>
                    @foreach (\App\Models\Batch::all() as $batch)
                        <option value="{{$batch->id}}" {{$batch->id == $year ? 'selected' : ''}}>{{$batch->name}}</option>
                    @endforeach
                </select>
                <input type="submit" value="{{__('text.word_get')}}" class="btn btn-sm btn-dark text-capitalize col-sm-2 text-center">
            </div>
        </form>
    </div>
    <div class=" my-3">
        <input class="form-control" id="search_field" placeholder="search by name or matricule">
    </div>
    <div class="">
        <div class=" ">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-stripped" id="hidden-table-info">
                <thead>
                    <tr class="text-capitalize">
                        <th>#</th>
                        <th>{{__('text.word_name')}}</th>
                        <th>{{__('text.word_email')}}</th>
                        <th>{{__('text.word_phone')}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    
                </tbody>
            </table>
            <div class="d-flex justify-content-end">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#search_field').on('keyup', function() {
        let value = $(this).val();
        url = '{{ route("search_students") }}';
        // console.log(url);
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'key': value
            },
            success: function(response) {
                let html = '';
                let k = 1;
                console.log(response);
                response.forEach(element => {
                    // console.log(element);
                    html += `
                    <tr>
                        <td>${k++}</td>
                        <td>${element.name}</td>
                        <td>${element.email}</td>
                        <td>${element.phone}</td>
                        <td class="d-flex justify-content-end  align-items-start text-capitalize">
                            <a class="btn btn-sm btn-warning m-1" onclick="confirm('Are you sure you want to reset pasword for ${element.name}?') ? $('#id_${element.id}').submit() : null"><i class="fa fa-edit"> {{__('text.reset_password')}}</i></a>|
                            <form action="${element.password_reset}" method="post" id="id_${element.id}" class="hidden">@csrf</form>
                        </td>
                    </tr>
                    `.replace('__SID__', element.id).replace('__ACTIVE__', element.active);
                });
                $('#table_body').html(html);
            },
            error: function(e) {
                console.log(e)
            }
        })
    })

</script>
@endsection
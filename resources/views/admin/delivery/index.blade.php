@extends('menu/adminMenu')

@section('content')
<a align='left' href='delivery/create' type="button" class="btn btn-success">@lang('main.addDelivery')</a>
<h2 align='center'>@lang('main.delivery')</h2>
<div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">@lang('main.name')</th>
                            <th scope="col">@lang('main.update')</th>
                            <th scope="col">@lang('main.delete')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                            <tr class='js-delivery-{{$delivery->id}}'>
                                <th>{{$delivery->id}}</th>
                                <td>{{$delivery->name}}</td>

                                <td><a href='/admin/delivery/{{$delivery->id}}/edit' class='destroyAircrafts btn btn-secondary'>@lang('main.update')</ф></td>
                                <td><button data-id='{{$delivery->id}}' class='destroy btn btn-danger'>@lang('main.delete')</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(function(){
            $(document).on('click', '.destroy', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/admin/delivery/delete",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('.js-delivery-'+id).remove();
                });
            });
        });
    </script>

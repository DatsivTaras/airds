@extends('menu/adminMenu')

@section('content')
<h2 align='center'>Способи Доставки</h2>
<div align='right'>
    <a href='delivery/create'>Додати</a>
</div>
<div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>

                            <th scope="col">Назва</th>
                            <th scope="col">Редагувати</th>
                            <th scope="col">Видалити</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                            <tr class='js-delivery-{{$delivery->id}}'>
                                <th>{{$delivery->id}}</th>
                                <td>{{$delivery->name}}</td>

                                <td><a href='/admin/delivery/{{$delivery->id}}/edit' class='destroyAircrafts btn btn-secondary'>Редагувати</ф></td>
                                <td><button data-id='{{$delivery->id}}' class='destroy btn btn-danger'>Видалити</button></td>
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
                    method: 'delete',
                    url: "/admin/delivery/destroy",
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

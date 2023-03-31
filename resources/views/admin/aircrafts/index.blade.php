@extends('menu/adminMenu')

@section('content')
    <a align='center' href='/admin/aircrafts/create' type="button" class="btn btn-success">Додати Літак</a>
    <h1 align='center'>Літаки</h1>
    <div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Фото</th>
                            <th scope="col">Назва</th>
                            <th scope="col">1 клас</th>
                            <th scope="col">2 клас</th>
                            <th scope="col">Економ</th>
                            <th scope="col">Опис</th>
                            <th scope="col">Видалити</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aircrafts as $aircraft)
                            <tr class='js-aircrafts-{{$aircraft->id}}'>
                                <th>{{$aircraft->id}}</th>
                                <td><img  width="191" height="111" src="{{ Storage::url($aircraft->aircrafts_image) }}" alt=""></td>
                                <td>{{$aircraft->name}}</td>
                                <td>{{$aircraft->first_class}}</td>
                                <td>{{$aircraft->second_class}}</td>
                                <td>{{$aircraft->economy_class}}</td>
                                <td>{{$aircraft->description}}</td>
                                <td><a href='/admin/aircrafts/{{$aircraft->id}}/edit' class='destroyAircrafts btn btn-secondary' >Редагувати</ф></td>
                                <td><button data-id='{{$aircraft->id}}' class='destroyAircrafts btn btn-danger'>Видалити</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(function(){
            $(document).on('click', '.destroyAircrafts', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'delete',
                    url: "/admin/aircrafts/destroy",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    console.log(result['test']);
                    $('.js-aircrafts-'+id).remove();
                });
            });
        });
    </script>
@endsection


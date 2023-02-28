@extends('menu/adminMenu')

@section('content')
<a align='center' href='/admin/flights/create' type="button" class="btn btn-success">Створити рейс</a>
<h1 align='center'>Рейси</h1>

<div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Країна Відправки</th>
                            <th scope="col">Місто Відправки</th>
                            <th scope="col">Дата Відправки</th>
                            <th scope="col">Країна Прибуття</th>
                            <th scope="col">Місто Прибуття</th>
                            <th scope="col">Дата Прибуття</th>
                            <th scope="col">Літак</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                            <tr class='js-flights-{{$flight->id}}'>
                                <th>{{$flight->id}}</th>
                                <th>{{$flight->countryOfDispatch->name}}</th>
                                <th>{{$flight->citiOfDispatch->name}}</th>
                                <th>{{$flight->formatDateFlight($flight->dateOfDispatch)}}</th>
                                <th>{{$flight->countryOfArrival->name}}</th>
                                <th>{{$flight->citiOfArrival->name}}</th>
                                <th>{{$flight->formatDateFlight($flight->dateOfArrival)}}</th>
                                <th>{{$flight->aircrafts->name}}</th>
                                <td><a href='/admin/flights/{{$flight->id}}/edit'  class="btn btn-secondary" {{ strtotime($flight->formatDateFlight($flight->dateOfDispatch)) > strtotime($tomorrow) ? '' : 'hidden'}} >Редагувати</a></td>
                                <td><button  id='destroyflights ' data-id='{{$flight->id}}' class=" destroyflights  btn btn-danger" {{strtotime($flight->formatDateFlight($flight->dateOfDispatch)) > strtotime($tomorrow) || strtotime($flight->formatDateFlight($flight->dateOfDispatch)) < strtotime($week) ? '' : 'hidden'}}>Видалити</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- {{strtotime($flight->formatDateFlight($flight->dateOfDispatch))}}<br>
{{strtotime($tomorrow)}} -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(function(){

            $(document).on('click', '.destroyflights', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'delete',
                    url: "/admin/flights/destroy",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('.js-flights-'+id).remove();
                });
            });
        });
    </script>
@endsection





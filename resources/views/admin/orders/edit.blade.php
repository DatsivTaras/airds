@extends('menu/topMenu')

@section('content')
<h2 align='center'>Оформлення Замовлення</h2>

<div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <form class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Ім'я</label>
                        <input type="text" class="form-control" id="inputName">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Прізвище</label>
                        <input type="text" class="form-control" id="inputSurname">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Електронна адреса</label>
                        <input type="email" class="form-control" id="inputEmail">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleFormControlInput1" class="form-label">Номер Телефону</label>
                        <input type="tel" class="form-control" id="inputPhoneNumber">
                    </div>
                </form><br><br>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Країна Відправки</th>
                            <th scope="col">Місто Відправки</th>
                            <th scope="col">Дата Відправки</th>
                            <th scope="col">Країна Прибуття</th>
                            <th scope="col">Місто Прибуття</th>
                            <th scope="col">Дата Прибуття</th>
                            <th scope="col">Літак</th>
                            <th scope="col">класс</th>
                            <th scope="col">місце</th>
                            <th scope="col">ціна</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderFlight as $flight)
                            <tr>
                                <th>{{$flight->flight->countryOfDispatch->name}}</th>
                                <th>{{$flight->flight->citiOfDispatch->name}}</th>
                                <th>{{$flight->flight->formatDateFlight($flight->dateOfDispatch)}}</th>
                                <th>{{$flight->flight->countryOfArrival->name}}</th>
                                <th>{{$flight->flight->citiOfArrival->name}}</th>
                                <th>{{$flight->flight->formatDateFlight($flight->dateOfArrival)}}</th>
                                <th>{{$flight->flight->aircrafts->name}}</th>
                                <th>{{$flight->booking->class}}</th>
                                <th>{{$flight->booking->place}}</th>
                                <th>{{$flight->booking->class}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @foreach($deliveries as $delivery)
                    <div class="form-check">
                        <input  class="form-check-input" type="radio" name="exampleRadios" id="delivery" value="{{$delivery->id}}" checked>
                        <label class="form-check-label" for="exampleRadios1"><h5>{{$delivery->name}}</h5></label>
                    </div>
                @endforeach
                <br><div>
                   <b>Сума</b> : {{$order->sum($order)}}
                </div>
                <div align='center'>
                    <a data-id='{{$order->id}}'  class="processing btn btn-primary" >Оформити</a>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(function(){
            $(document).on('click', '.processing', function(){
                var id = $(this).data('id');
                var name = $('#inputName').val();
                var surname = $('#inputSurname').val();
                var email = $('#inputEmail').val();
                var phone = $('#inputPhoneNumber').val();
                var delivery_id = $('input[name="exampleRadios"]:checked').val();
                $.ajax({
                    method: 'post',
                    url: "/orderProcessing",
                    data:{
                        id: id,
                        name: name,
                        surname: surname,
                        email: email,
                        phone: phone,
                        delivery_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    window.location.replace("/profile/booking");
                });
            });
        });
    </script>


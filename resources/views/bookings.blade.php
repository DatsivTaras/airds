@extends('menu/topMenu')

@section('content')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Заброньовані рейси</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Закази</button>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class='container'>
            <h2 align='center'>Бронювання</h2>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    @foreach($notConfirmedOrders as $order)
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$order->id}}" aria-expanded="false" aria-controls="collapse{{$order->id}}">
                                   Замовлення №{{$order->id}}  Статус:{{$order->getStatus()}}
                                </button>
                                </h2>
                                <div id="collapse{{$order->id}}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <!-- <th scope="col">ID</th> -->
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
                                                        <th>{{$flight->booking->price}}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div align='left'>
                                           <b>Cума</b> : {{$order->sum($order)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class='container'>
                <h1 align='center'>Заброньовано</h1><br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">ID</th> -->
                                        <th scope="col">Країна Відправки</th>
                                        <th scope="col">Місто Відправки</th>
                                        <th scope="col">Дата Відправки</th>
                                        <th scope="col">Країна Прибуття</th>
                                        <th scope="col">Місто Прибуття</th>
                                        <th scope="col">Дата Прибуття</th>
                                        <th scope="col">Літак</th>
                                        <th scope="col">класс</th>
                                        <th scope="col">місце</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr onclick="document.location='/flight/view/{{$booking->flight->id}}'"  class='js-flights-{{$booking->flight->id}}'>
                                            <th>{{$booking->flight->countryOfDispatch->name}}</th>
                                            <th>{{$booking->flight->citiOfDispatch->name}}</th>
                                            <th>{{$booking->flight->formatDateFlight($booking->flight->dateOfDispatch)}}</th>
                                            <th>{{$booking->flight->countryOfArrival->name}}</th>
                                            <th>{{$booking->flight->citiOfArrival->name}}</th>
                                            <th>{{$booking->flight->formatDateFlight($booking->flight->dateOfArrival)}}</th>
                                            <th>{{$booking->flight->aircrafts->name}}</th>
                                            <th>{{$booking->class}}</th>
                                            <th>{{$booking->place}}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>
@endsection

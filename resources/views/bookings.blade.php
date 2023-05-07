@extends('menu/topMenu')

@section('content')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">@lang('main.bookingOrders')</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">@lang('main.orders')</button>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class='container'>
            <h2 align='center'>@lang('main.booking')</h2>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-12">
                    @foreach($notConfirmedOrders as $order)
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$order->id}}" aria-expanded="false" aria-controls="collapse{{$order->id}}">
                                @lang('main.order') №{{$order->id}}  @lang('main.status'):{{$order->getStatus()}}
                                </button>
                                </h2>
                                <div id="collapse{{$order->id}}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <!-- <th scope="col">ID</th> -->
                                                    <th scope="col">@lang('main.countryOfDispatch')</th>
                                                    <th scope="col">@lang('main.citiOfDispatch')</th>
                                                    <th scope="col">@lang('main.dateOfDispatch')</th>
                                                    <th scope="col">@lang('main.countryOfArrival')</th>
                                                    <th scope="col">@lang('main.citiOfArrival')</th>
                                                    <th scope="col">@lang('main.dateOfArrival')</th>
                                                    <th scope="col">@lang('main.aircraft')</th>
                                                    <th scope="col">@lang('main.class')</th>
                                                    <th scope="col">@lang('main.place')</th>
                                                    <th scope="col">@lang('main.price')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderFlight as $flight)
                                                    <tr>
                                                        <th>@lang('country.'.mb_strtolower($flight->flight->countryOfDispatch->name))</th>
                                                        <th>{{$flight->flight->citiOfDispatch->name}}</th>
                                                        <th>{{$flight->flight->formatDateFlight($flight->dateOfDispatch)}}</th>
                                                        <th>@lang('country.'.mb_strtolower($flight->flight->countryOfDispatch->name))</th>
                                                        <th>{{$flight->flight->citiOfArrival->name}}</th>                                                        <th>{{$flight->flight->formatDateFlight($flight->dateOfArrival)}}</th>
                                                        <th>{{$flight->flight->aircrafts->name}}</th>
                                                        <th>{{$flight->booking->class}}</th>
                                                        <th>{{$flight->booking->place}}</th>
                                                        <th>{{$flight->booking->price}}</th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div align='left'>
                                            <b>@lang('main.sum')</b> : {{$order->sum()}}
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
        <section class="py-5">
                                    @foreach($bookings as $booking)
                                        <div class="container px-4 px-lg-5 mt-5">
                                            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 ">
                                                <div class="col mb-5">
                                                    <div class="card h-100">
                                                        <!-- Product image-->
                                                        <img class="card-img-top" src="{{ Storage::url($booking->flight->aircrafts->aircrafts_image) }}" alt="..." />
                                                        <!-- Product details-->
                                                        <div class="card-body p-4">
                                                            <div class="text-center">
                                                                <!-- Product name-->
                                                                <h5 class="fw-bolder">

                                                                    <th>@lang('country.'.mb_strtolower($booking->flight->countryOfDispatch->name))</th>
                                                                    <th>@lang('country.'.mb_strtolower($booking->flight->countryOfArrival->name))</th>
                                                                    <!-- Product price-->
                                                                {{$booking->flight->formatDateFlight($booking->flight->dateOfDispatch)}} - {{$booking->flight->formatDateFlight($booking->flight->dateOfArrival)}}
                                                            </div>
                                                            <div class="text-center">
                                                                @lang('main.class'):{{$booking->class}} @lang('main.place'):{{$booking->place}}
                                                            </div>
                                                        </div>
                                                        <!-- Product actions-->
                                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                                            <div class="text-center"><a class='btn btn-primary mb-3' href='/flight/view/{{$booking->flight->id}}' >@lang('main.view')</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </section>
        </div>

        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>
@endsection

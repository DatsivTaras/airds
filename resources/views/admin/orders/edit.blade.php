@extends('menu/topMenu')

@section('content')
<h1 align='center'>Оформлення замовлення</h1><br><br>
<html lang="en">
  <body class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          @foreach($order->orderFlight as $flight)
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$flight->flight->countryOfDispatch->name}}-{{$flight->flight->countryOfArrival->name}}</h6>
                        <small class="text-muted">{{$flight->flight->formatDateFlight($flight->dateOfDispatch)}}</small>
                    </div>
                    <span class="text-muted">${{$flight->booking->price}}</span>
                </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between">
              <span>Разом</span>
              <strong>${{$order->sum($order)}}</strong>
            </li>
          </ul>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Контактні дані</h4>
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Ім'я</label>
                <input name='name' type="text" class="form-control" id="inputName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Прізвище</label>
                <input name='surname' type="text" class="form-control" id="inputSurname" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
                <label for="email">Email <span class="text-muted"></span></label>
                <input name='email' type="email" class="form-control" id="inputEmail" placeholder="you@example.com">
                <div class="invalid-feedback">
                    Please enter a valid email address for shipping updates.
                </div>
            </div>

            <div class="mb-3">
              <label for="nomber">Номер Телефону <span class="text-muted"></span></label>
              <input name='phone' type="text" class="form-control" id="inputPhoneNumber" placeholder="">
            </div>
            <h4 class="mb-3">Спосіб доставки</h4>

            <div class="d-block my-3">
                @foreach($deliveries as $delivery)
                    <div class="form-check">
                        <input name ="delivery_id" class="form-check-input" type="radio" id="delivery" value="{{$delivery->id}}" >
                        <label class="form-check-label" for="exampleRadios1"><h6>{{$delivery->name}}</h6></label>
                    </div>
                @endforeach
            </div>
            <hr class="mb-4">
            <a data-id='{{$order->id}}' class="processing btn btn-primary btn-lg btn-block" >Оформити Замовлення</a>
          </form>
        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 Company Name</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>
  </body>
</html>

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
                var delivery_id = $('input[name="delivery_id"]:checked').val();
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


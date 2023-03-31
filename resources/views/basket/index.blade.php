@extends('menu/topMenu')

@section('content')

<button id='mybtn' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      @if ($order && $order->orderFlight()->exists())
    <h2 align='center'>Кошик</h2>
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
                <div align='center'>
                    <a data-id='{{$order->id}}'  class="booking btn btn-primary" >Забронювати</a>
                </div>
            </div>
        </div>
    </div>
@else
<h2 align='center'>Кошик порожній</h2>
@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
     $(function(){
        $(document).on('click', '#mybtn', function(){
            $('#exampleModalLong').modal('show')

        });
        $(document).on('click', '.close', function(){
            $('#exampleModalLong').modal('hide')
        });


        $(document).on('click', '.booking', function(){
            var id = $(this).data('id');
            $.ajax({
                method: 'post',
                url: "/booking/add",
                data:{
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {
              alert('df');
            });
        });
    });
    </script>
</script>

@extends('menu/topMenu')

@section('content')

<div class='container'>
    <h2 align='center'>Рейс</h2>
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
                        <tr class='js-flights-{{$flight->id}}'>
                            <th>{{$flight->id}}</th>
                            <th>{{$flight->countryOfDispatch->name}}</th>
                            <th>{{$flight->citiOfDispatch->name}}</th>
                            <th>{{$flight->formatDateFlight($flight->dateOfDispatch)}}</th>
                            <th>{{$flight->countryOfArrival->name}}</th>
                            <th>{{$flight->citiOfArrival->name}}</th>
                            <th>{{$flight->formatDateFlight($flight->dateOfArrival)}}</th>
                            <th>{{$flight->aircrafts->name}}</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
                Клас<br>
                {{ Form::open(['route' => ['basket.addBasket', $flight->id], 'method' => 'post']) }}
                    <div class="col-auto">
                        {{ Form::select('classes', $classes ,'',  ['class' => ' form-select','id'=>'classes']) }}
                    </div><br>
                Місце<br>
                    <div class="col-auto">
                        {{ Form::select('places', ['1' => ''] ,'', ['class' => 'form-select', 'id'=>'places']) }}
                    </div>
                    <br><button class="btn btn-primary"  data_id='{{$flight->id}}' id='booking' role="button">В корзину</button>
                {{ Form::close() }}

            </div>


        </div>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
        $(document).ready(function (){
            $("#places").attr('disabled','disabled')

        });

            // $(document).on('click', '#bookiаng', function(){
            //     var id = $(this).val();
            //     $.ajax({
            //         method: 'post',
            //         url: "/basket/addBasket{{$flight->id}}",
            //         data:{
            //             id: id,
            //             "_token": "{{ csrf_token() }}"
            //         },
            //         dataType: 'json',
            //     }).done(function(result) {
            //         $("#booking").attr('disabled','disabled')
            //         $("#booking").text("Відмінити ");
            //         alert('f');
            //     });
            // });
            $(document).ready(function (){
                $('#classes').change(function (){
                    var id = $(this).val();
                    var  flightId = "{{$flight->id}}";
                    var arr = [];
                    $.ajax({
                    method: 'post',
                    url: "/admin/flights/place-of-classes",
                    data:{
                        id: id,
                        flightId: flightId,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    if(result==''){
                        $("#places").attr('disabled','disabled')
                    } else{
                        $("#places").attr('disabled',false)
                    }
                    result.forEach(function(item){
                        arr[item['id']] = '<option  value ="'+item['place']+'">'+item['place']+'</option>'
                    })
                    $('#places').html(arr)
                });


                });
            });



    </script>
</script>

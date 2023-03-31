@extends('menu/topMenu')

@section('content')
<h1 align='center'>Рейси</h1>
    <div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-12">
                {{ Form::open(['class' => 'row g-3', 'method' => 'get']) }}
                    <div class="col-auto">
                        {{ Form::select('filteringCountryOfDispatch', $countries ,'',  ['class' => ' form-select','id'=>'filteringCountryOfDispatch']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::select('filteringCityOfDispatch', $citiesOfDispatch ,'', ['class' => 'form-select', 'id'=>'filteringCityOfDispatch']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::select('filteringCountryOfArrival', $countries ,'',  ['class' => ' form-select','id'=>'filteringCountryOfArrival']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::select('filteringCityOfArrival', $citiesOfDispatch ,'', ['class' => 'form-select', 'id'=>'filteringCityOfArrival']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::datetimelocal('filteringDateOfDispatch', '' , ['class' => 'form-control']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::datetimelocal('filteringDateOfArrival', '' , ['class' => 'form-control']) }}
                    </div>
                    <div class="col-auto">
                        {{ Form::submit(('Пошук'),['class' => 'btn btn-primary'])}}
                    </div>
                {{ Form::close() }}
                <table class="table table-hover"">
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
                                <th><a class='btn btn-primary mb-3' href='/flight/view/{{$flight->id}}' >Переглянути</a></th>
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
        $(document).ready(function (){
            $("#filteringCityOfDispatch").attr('disabled','disabled')

            $('#filteringCountryOfDispatch').change(function (){
                var id = $(this).val();
                $.ajax({
                    method: 'post',
                    url: "/admin/flights/citi-of-flights",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    if(result==''){
                        $("#filteringCityOfDispatch").attr('disabled','disabled')
                    } else{
                        $("#filteringCityOfDispatch").attr('disabled',false)
                    }
                    $('#filteringCityOfDispatch').html(result)
                    console.log('d');
                });
            });

            $('#filteringCountryOfArrival').change(function (){
                var id = $(this).val();
                $.ajax({
                    method: 'post',
                    url: "/admin/flights/citi-of-flights",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    if(result==''){
                        $("#filteringCityOfArrival").attr('disabled','disabled')
                    } else{
                        $("#filteringCityOfArrival").attr('disabled',false)
                    }
                    $('#filteringCityOfArrival').html(result)
                    console.log('d');
                });
            });

        });
    </script>

</script>

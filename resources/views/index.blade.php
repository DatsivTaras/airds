@extends('menu/topMenu')

@section('content')

<!-- 1Для чого потрібен метод констрикт i destruct
2 паблік статік фуншин
3 коли потрібно наслідувати
4для чого метолди public i private i protected
5 this i self
6 Інкапсуляція поліморфізм
7 Редагування цінт рейсу як змінити і в букінгах
8 -->

        <h1 align='center'>@lang('main.flight')</h1>
        <div class='container'>
            <br><br><div class="row">
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
                            {{ Form::submit(__('main.search'),['class' => 'btn btn-primary'])}}
                        </div>
                        {{ Form::close() }}
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-2">
                @foreach($flights as $flight)
                        <div class="col">
                            <div class="card h-130">
                                <img src="{{ Storage::url($flight->flightMainImage->image) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                <div class="text-center">
                                    <h5 class="card-title">@lang('country.'.mb_strtolower($flight->countryOfDispatch->name))   -  @lang('country.'.mb_strtolower($flight->countryOfArrival->name))</h5>
                                    <p class="card-text">{{$flight->formatDateFlight($flight->dateOfDispatch)}} - {{$flight->formatDateFlight($flight->dateOfArrival)}}</p>
                                </div>
                                    <div class="text-center"><a class='btn btn-primary mb-3' href='/flight/view/{{$flight->id}}' >@lang('main.view')</a></div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            <br>





        <br><br><br><br><br><br>@widget('PopularFlights')
    </div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
        $(document).ready(function (){
            $("#filteringCityOfDispatch").attr('disabled','disabled')

            $('#filteringCountryOfDispatch').change(function (){
                var id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: "/flights/citi-of-flights",
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
                    method: 'get',
                    url: "/flights/citi-of-flights",
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

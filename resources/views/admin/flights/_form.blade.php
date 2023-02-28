<!-- 1.ВИберіть країну перше в списку
1.ВИберіть країну обовязковим полем
2.місто має бути обовязковим
2.дата обовязкова
2.дата немає бути меншою за завтра
2.http://airds.club.ua/admin/flights якшо в рейса дата відправки менша за завтра тоді кнопки редагувати немає бути за тиждень видалити
2.помвняти формат дати
2.добавити всі міста і країни в бд
2. -->
кнопка редагувати лише тоді коли дата більша за завтра обо зав
кноп вид має бути коли дата більша за завтра або від дати видправкт пройшов тиждень
1 клас не більше 10
2 клас не менш 10
3 клас не менш 10і не більше 50
при ін видавати помилку


    @if(!$flight->id)
        {{ Form::open(['route' => ['admin.flights.store', $flight->id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => ['admin.flights.update', $flight->id], 'method' => 'put']) }}
    @endif
        <div class="mb-3">
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::select('countryOfDispatch_id', $countries , $flight->countryOfDispatch_id , ['class' => ' form-select','id'=>'countryOfDispatch']) }}
            @error('countryOfDispatch_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('citiOfDispatch_id', $citiesOfDispatch , $flight->citiOfDispatch_id , ['class' => 'form-select', 'id'=>'citiOfDispatch']) }}
            @error('citiOfDispatch_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Дата Відправки1', ['class' => 'form-label']) }}
            {{ Form::datetimelocal('dateOfDispatch', $flight->dateOfDispatch	, ['class' => 'form-control', 'min' => now()->format('Y-m-d H:i:s') ]) }}
            @error('dateOfDispatch')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::select('countryOfArrival_id', $countries , $flight->countryOfArrival_id , ['class' => ' form-select','id'=>'countryOfDispatch','id'=>'countryOfArrival']) }}
            @error('countryOfArrival_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('citiOfArrival_id', $citiesOfArrival , $flight->citiOfArrival_id , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}
            @error('citiOfArrival_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::dateTimelocal('dateOfArrival', $flight->dateOfArrival	, ['class' => 'form-control', 'min' => now()->format('Y-m-d H:i:s') ]) }}
            @error('dateOfArrival')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('aircraft_id', $aircrafts , $flight->aircraft_id , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}
            @error('aircraft_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        </div>
        <input type='date' min='2023-02-28' max='2023-03-01'></input>
        <div align='center'>
            {{ Form::submit(!$flight->id ? __('Створити') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
        $(document).ready(function (){
            if("{{!$flight->id}}"){
                $("#citiOfDispatch").attr('disabled','disabled')
                $("#citiOfArrival").attr('disabled','disabled')
            }
            $('#countryOfDispatch').change(function (){
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
                        $("#citiOfDispatch").attr('disabled','disabled')
                    } else{
                        $("#citiOfDispatch").attr('disabled',false)
                    }
                    $('#citiOfDispatch').html(result)
                });
            });

            $('#countryOfArrival').change(function (){
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
                        $("#citiOfArrival").attr('disabled','disabled')
                    } else{
                        $("#citiOfArrival").attr('disabled',false)
                    }
                    $('#citiOfArrival').html(result)
                });
            });
        });
    </script>

</script>

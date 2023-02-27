
    @if(!$flight->id)
        {{ Form::open(['route' => ['admin.flights.store', $flight->id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => ['admin.flights.update', $flight->id], 'method' => 'put']) }}
    @endif
        <div class="mb-3">
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::select('countryOfDispatch_id', $countries , $flight->countryOfDispatch_id , ['class' => ' form-select','id'=>'countryOfDispatch']) }}

            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('citiOfDispatch_id', $citiesOfDispatch , $flight->citiOfDispatch_id , ['class' => 'form-select', 'id'=>'citiOfDispatch']) }}

            {{ Form::label('text', 'Дата Відправки', ['class' => 'form-label']) }}
            {{ Form::dateTimelocal('dateOfDispatch', $flight->dateOfDispatch	, ['class' => 'form-control']) }}

            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::select('countryOfArrival_id', $countries , $flight->countryOfArrival_id , ['class' => ' form-select','id'=>'countryOfDispatch','id'=>'countryOfArrival']) }}

            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('citiOfArrival_id', $citiesOfArrival , $flight->citiOfArrival_id , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}

            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::dateTimelocal('dateOfArrival', $flight->dateOfArrival	, ['class' => 'form-control']) }}

            {{ Form::label('text', 'Місто Відправки', ['class' => 'form-label']) }}
            {{ Form::select('aircraft_id', $aircrafts , $flight->aircraft_id , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}
        </div>

        <div align='center'>
            {{ Form::submit(!$flight->id ? __('Створити') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
        $(document).ready(function (){
            // $("#citiOfDispatch").attr('disabled','disabled')
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
                   $('#citiOfArrival').html(result)
                });
            });

        });
    </script>

</script>

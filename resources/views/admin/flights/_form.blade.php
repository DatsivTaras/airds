<head>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Ajax Autocomplete Dynamic Search with select2</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script></head>


    @if(!$flight->id)
        {{ Form::open(['route' => ['admin.flights.store', $flight->id], 'method' => 'post', 'class' => 'row g-3']) }}
    @else
        {{ Form::open(['route' => ['admin.flights.update', $flight->id], 'method' => 'put','class' => 'row g-3' ]) }}
    @endif
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                 <div class="card-body">
                    {{ Form::label('text', __('main.countryOfDispatch'), ['class' => ' form-label']) }}
                    {{ Form::select('countryOfDispatch_id', $countries , $flight->countryOfDispatch_id , ['class' => 'countryOfDispatch form-select','id'=>'countryOfDispatch']) }}
                    @error('countryOfDispatch_id')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                    {{ Form::label('text',  __('main.citiOfDispatch'), ['class' => 'form-label']) }}
                    {{ Form::select('citiOfDispatch_id', $citiesOfDispatch , $flight->citiOfDispatch_id , ['class' => 'citiOfDispatch form-select', 'id'=>'citiOfDispatch']) }}

                    @error('citiOfDispatch_id')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                    {{ Form::label('text',  __('main.dateOfDispatch'), ['class' => 'form-label']) }}
                    {{ Form::datetimelocal('dateOfDispatch', $flight->dateOfDispatch	, ['class' => 'form-control', 'min' => now()->format('Y-m-d H:i') ]) }}
                    @error('dateOfDispatch')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    {{ Form::label('text',  __('main.countryOfArrival'), ['class' => 'form-label']) }}
                    {{ Form::select('countryOfArrival_id', $countries , $flight->countryOfArrival_id , ['class' => 'countryOfArrival form-select','id'=>'countryOfArrival']) }}
                    @error('countryOfArrival_id')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                    {{ Form::label('text',  __('main.citiOfArrival'), ['class' => 'form-label']) }}
                    {{ Form::select('citiOfArrival_id', $citiesOfArrival , $flight->citiOfArrival_id , ['class' => 'citiOfArrival form-select', 'id'=>'citiOfArrival']) }}
                    @error('citiOfArrival_id')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                    {{ Form::label('text',  __('main.dateOfArrival'), ['class' => 'form-label']) }}
                    {{ Form::dateTimelocal('dateOfArrival', $flight->dateOfArrival	, ['class' => 'form-control', 'min' => now()->format('Y-m-d H:i') ]) }}
                    @error('dateOfArrival')
                    <h7 style='color:red'>{{$message}}</h7><br>
                    @enderror
                </div>
            </div>
        </div>
    </div>
        <div class="form-group col-md-6">
            {{ Form::label('text',  __('main.aircraft'), ['class' => 'form-label']) }}
            {{ Form::select('aircraft_id', $aircrafts , $flight->aircraft_id , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}
            @error('aircraft_id')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('text', __('main.price') .' '. __('main.oneClass'), ['class' => 'form-label']) }}
            {{ Form::number('price_first_class', $flight->price_first_class , ['class' => 'form-control'] ) }}
            @error('first_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('text',  __('main.price') .' '. __('main.twoClass'), ['class' => 'form-label']) }}
            {{ Form::number('price_second_class', $flight->price_second_class , ['class' => 'form-control']) }}
            @error('second_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        </div>
        <div class="form-group col-md-2">
            {{ Form::label('text',  __('main.price') .' '. __('main.economy'), ['class' => 'form-label']) }}
            {{ Form::number('price_economy_class', $flight->price_economy_class , ['class' => 'form-control']) }}
            @error('economy_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        </div>

        <div align='center'>
            {{ Form::submit(!$flight->id ? __('main.create') : __('main.update'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}

<script type="text/javascript">

        $('.countryOfDispatch').select2({
            placeholder: "{{__('main.selectCountry')}}",
            ajax: {
                url: '/admin/flights/country-of-flights',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }

                        })

                    };
                },
                cache: true
            }
        });
        $('.citiOfDispatch').select2({
            placeholder: "{{__('main.selectSiti')}}",
            ajax: {
                data: function (data) {
                    return {
                        id: $("#countryOfDispatch").val(),
                        q: data.term
                    }
                },
                url: '/admin/flights/citi-of-flights',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                            alert('d');
                        })
                    };
                },
                cache: true
            }
        });
        $('.countryOfArrival').select2({
            placeholder: "{{__('main.selectCountry')}}",
            ajax: {
                url: '/admin/flights/country-of-flights',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.citiOfArrival').select2({
            placeholder: "{{__('main.selectSiti')}}",
            ajax: {
                data: function (data) {
                    return {
                        id: $("#countryOfArrival").val(),
                        q: data.term
                    }
                },
                url: '/admin/flights/citi-of-flights',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                },
                cache: true
            }
        });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        if("{{!$flight->id}}"){
            // $("#citiOfDispatch").attr('disabled','disabled')
            // $("#citiOfArrival").attr('disabled','disabled')
        }


    });
</script>

@extends('menu/adminMenu')

@section('content')
<a align='center' href='/admin/flights/create' type="button" class="btn btn-success">@lang('main.createFlight')</a>
<h1 align='center'>@lang('main.flight')</h1>

<div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">@lang('main.countryOfDispatch')</th>
                            <th scope="col">@lang('main.citiOfDispatch')</th>
                            <th scope="col">@lang('main.dateOfDispatch')</th>
                            <th scope="col">@lang('main.countryOfArrival')</th>
                            <th scope="col">@lang('main.citiOfArrival')</th>
                            <th scope="col">@lang('main.dateOfArrival')</th>
                            <th scope="col">@lang('main.aircraft')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                            <tr class='js-flights-{{$flight->id}}'>
                                <th>{{$flight->id}}</th>
                                <th>@lang('country.'.mb_strtolower($flight->countryOfDispatch->name))</th>
                                <th>{{$flight->citiOfDispatch->name}}</th>
                                <th>{{$flight->formatDateFlight($flight->dateOfDispatch)}}</th>
                                <th>@lang('country.'.mb_strtolower($flight->countryOfDispatch->name))</th>
                                <th>{{$flight->citiOfArrival->name}}</th>
                                <th>{{$flight->formatDateFlight($flight->dateOfArrival)}}</th>
                                <th>{{$flight->aircrafts->name}}</th>
                                <td><a href='/admin/flights/{{$flight->id}}/edit'  class="btn btn-secondary" {{strtotime($flight->formatDateFlight($flight->dateOfDispatch)) > strtotime($tomorrow) ? '' : 'hidden'}}>@lang('main.update')</a></td>
                                <td><button  id='destroyflights ' data-id='{{$flight->id}}' class=" destroyflights  btn btn-danger" {{strtotime($flight->formatDateFlight($flight->dateOfDispatch)) > strtotime($tomorrow) || strtotime($flight->formatDateFlight($flight->dateOfDispatch)) < strtotime($week) ? '' : 'hidden'}}>@lang('main.delete')</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
       $(function(){
            $(document).on('click', '.destroyflights', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/admin/flights/delete",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('.js-flights-'+id).remove();
                });
            });
        });
    </script>
@endsection





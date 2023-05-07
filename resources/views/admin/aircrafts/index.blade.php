@extends('menu/adminMenu')

@section('content')
    <a align='center' href='/admin/aircrafts/create' type="button" class="btn btn-success">@lang('main.addAircraft')</a>
    <h1 align='center'>@lang('main.aircraft')</h1>
    <div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">@lang('main.photo')</th>
                            <th scope="col">@lang('main.name')</th>
                            <th scope="col">1 @lang('main.class')</th>
                            <th scope="col">2 @lang('main.class')</th>
                            <th scope="col">2 @lang('main.economy')</th>
                            <th scope="col">2 @lang('main.description')</th>
                            <th scope="col">@lang('main.update')</th>
                            <th scope="col">@lang('main.delete')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aircrafts as $aircraft)
                            <tr class='js-aircrafts-{{$aircraft->id}}'>
                                <th>{{$aircraft->id}}</th>
                                <td><img  width="191" height="111" src="{{ Storage::url($aircraft->aircraftMainImage->image) }}" alt=""></td>
                                <td>{{$aircraft->name}}</td>
                                <td>{{$aircraft->first_class}}</td>
                                <td>{{$aircraft->second_class}}</td>
                                <td>{{$aircraft->economy_class}}</td>
                                <td>{{$aircraft->description}}</td>
                                <td><a href='/admin/aircrafts/{{$aircraft->id}}/edit' class='destroyAircrafts btn btn-secondary' >@lang('main.update')</ф></td>
                                <td><button data-id='{{$aircraft->id}}' class='destroyAircrafts btn btn-danger'>@lang('main.delete')</button></td>
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
            $(document).on('click', '.destroyAircrafts', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/admin/aircrafts/delete",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('.js-aircrafts-'+id).remove();
                    console.log('f');
                });
            });
        });
    </script>
@endsection


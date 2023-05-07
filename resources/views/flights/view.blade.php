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
                            <th scope="col">@lang('main.citiOfDispatch')</th>
                            <th scope="col">@lang('main.dateOfDispatch')</th>
                            <th scope="col">@lang('main.countryOfArrival')</th>
                            <th scope="col">@lang('main.citiOfArrival')</th>
                            <th scope="col">@lang('main.dateOfArrival')</th>
                            <th scope="col">@lang('main.aircraft')</th>
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
        </div><br><br><br><br><br><br><br><br><br><br><br><br>

        <h3 align='center'>Коментарі</h3><br>
        <div class="p-3 mb-2 bg-secondary text-white">Додати коментар
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control" id="textComment" rows="3"></textarea>
            </div>

            <div align='right' class="mb-3">
                <button id='sendComment' data-id='{{$flight->id}}' class='btn btn-primary'>Надіслати</button>
                <button id='cancel' class='btn btn-danger'>Скасувати</button>
            </div>
        </div>
        <div id='comments'></div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
        $(document).ready(function (){

            $("#places").attr('disabled','disabled')
            var id = $('#sendComment').data('id');
            var user_id = '{{auth()->id()}}';
            $.ajax({
                    method: 'post',
                    url: "/flight/allComments",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {


                    var comment = '';
                    result['allCommentsd'].forEach(function(item){
                        comment += '<div id = comment'+item['id']+' class="rounded text-white shadow-none p-3 w-50 mb-2 bg-'+(user_id == item['user_id'] ? 'primary': 'secondary' )+'">'+item['user_name']+ ' : '+ item['text']+' '+item['created_at']+(user_id == item['user_id'] ? '<a data-id ='+item['id']+' id = delete-comment> Видалити</a>': ' ' )+'</div>';
                    })



                    $('#comments').html(comment)
                });
            });
            $(document).on('click', '#cancel', function(){
                $('#textComment').val('');

            });

            $(document).on('click', '#delete-comment', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/flight/delete-comment",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('#comment'+id).remove();
                });
            });

            $(document).on('click', '#sendComment', function(){
                var flight_id = $(this).data('id');
                var text = $('#textComment').val();
                $.ajax({
                    method: 'post',
                    url: "/flight/sendingComment",
                    data:{
                        flight_id: flight_id,
                        text: text,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    $('#comments').prepend('<div id = comment'+result['comment']['id']+' class="rounded text-white shadow-none p-3 w-50 mb-2 bg-primary">'+ result['comment']['user_name']+' : '+result['comment']['text']+' '+result['comment']['created_at']+'<a data-id ='+result['comment']['id']+' id = delete-comment> Видалити</a></div>');

                    $('#textComment').val('');
                });
            });
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

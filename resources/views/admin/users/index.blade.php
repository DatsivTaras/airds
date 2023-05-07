@extends('menu/adminMenu')

@section('content')
    <h1 align='center'>@lang('main.users')</h1><br><br>
    <div class='container'>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">@lang('main.name')</th>
                            <th scope="col">@lang('main.email')</th>
                            <th scope="col">@lang('main.name')</th>
                            <th scope="col">@lang('main.restrictionDate')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th>{{$user->id}}</th>
                                <th>{{$user->name}}</th>
                                <th>{{$user->email}}</th>
                                <th>{{$user->getStatus()}}</th>
                                <th>{{$user->created_at}}</th>
                                <th id='statuses'>
                                    @if($user->status == 2 || $user->status == 1)
                                        <button data-id='{{$user->id}}' id='deleted' class='btn btn-danger'>@lang('main.delete')</button>
                                    @else
                                        <button data-id='{{$user->id}}' id='recovery' class='btn btn-success'>@lang('main.restore')</button>
                                    @endif
                                </th>
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
     $(function(){
        $(document).on('click', '#recovery', function(){
            var id = $(this).data('id');
            $.ajax({
                method: 'post',
                url: "/admin/recovery",
                data:{
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {
                $('#statuses').html('<button data-id='+id+' id=deleted class="btn btn-danger">Видалити</button>')
            });
        });
        $(document).on('click', '#deleted', function(){
            var id = $(this).data('id');
            $.ajax({
                method: 'delete',
                url: "/admin/users/destroy",
                data:{
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {
                $('#statuses').html('<button data-id='+id+' id=recovery class="btn btn-danger">Відновити</button>')
            });
        });
    });
    </script>

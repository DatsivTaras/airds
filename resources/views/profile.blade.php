@extends('menu/topMenu')

@section('content')

    <!-- <h1 align='center'>Профайл</h1> -->

    <div class="main">
        <h2 align='center'>@lang('main.profile')</h2><br>
        <a class="btn btn-secondary" href='/profile/booking'>@lang('main.my_booking')</a><br>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <div align='right'>
                    <a href='profile/{{$user->id}}/edit' class='btn btn-primary' >@lang('main.update')</a>
                </div>
                <table id='table'>
                    <tbody>
                        <tr>
                            <td >Name : </td>
                            <td id='name'>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <td>Surname : </td>
                            <td>{{$user->surname}}</td>
                        </tr>
                        <tr>
                            <td>Phone : </td>
                            <td>{{$user->phone_nomber}}</td>
                        </tr>
                        <tr>
                            <td>Email : </td>
                            <td>{{$user->email}}</td>
                        </tr>
                    </tbody>
                </table>
                <div align='right'>
                    <a href='password/changePassword/edit'>@lang('main.changePassword')</a>
                </div>
            </div>
        </div><br><br><br>
        @role(['User'])
            <div align='right'>
                <button id='deleteProfile' class="btn btn-danger">Видалити профіль</button>
        @endrole
    </div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
     $(function(){
        $(document).on('click', '#deleteProfile', function(){
            $.ajax({
                method: 'get',
                url: "/profile/delete",
                data:{
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {
                window.location.replace('/');
            });
        });
     });
</script>

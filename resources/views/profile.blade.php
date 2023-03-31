@extends('menu/topMenu')

@section('content')

    <!-- <h1 align='center'>Профайл</h1> -->

    <div class="main">
        <h2 align='center'>Профайл</h2><br>
        <a class="btn btn-secondary" href='/profile/booking'>Мої бронювання </a><br>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <div align='right'>
                    <a href='profile/{{$user->id}}/edit' class='btn btn-primary' >Редагувати</a>
                </div>
                <table id='table'>
                    <tbody>
                        <tr>
                            <td >Name : </td>
                            <td id='name'>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <td>Email : </td>
                            <td>{{$user->email}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><br><br><br>
        <div align='right'>
            <button id='deleteProfile' class="btn btn-danger">Видалити профіль</button>
        </div>
    </div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
     $(function(){
        $(document).on('click', '#deleteProfile', function(){
            $.ajax({
                method: 'delete',
                url: "/profile/destroy",
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

@extends('menu/adminMenu')

@section('content')
<div class='container'>
    <h3 align='center'>Створити Рейс</h3>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            @include('/admin/flights/_form')
        </div>
    </div>
</div>
@endsection








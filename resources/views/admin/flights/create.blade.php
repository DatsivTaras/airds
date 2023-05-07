@extends('menu/adminMenu')

@section('content')
<div class='container'>
    <h3 align='center'>@lang('main.createFlight')</h3>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-9">
        <br><br><br>@include('/admin/flights/_form')
        </div>
    </div>
</div>
@endsection








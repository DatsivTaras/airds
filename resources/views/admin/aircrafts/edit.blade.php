@extends('menu/adminMenu')

@section('content')
<h3 align='center'>@lang('main.updateAircraft')</h3>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            @include('/admin/aircrafts/_form')
        </div>
    </div>
</div>
@endsection

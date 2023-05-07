@extends('menu/topMenu')

@section('content')
<h3 align='center'>@lang('main.updateProfile')</h3>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            @include('/profile/_form')
        </div>
    </div>
</div>
@endsection

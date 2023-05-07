@extends('menu/topMenu')

@section('content')
<h3 align='center'>@lang('main.updatePassword')</h3>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            @include('/password/_formpassword')
        </div>
    </div>
</div>
@endsection

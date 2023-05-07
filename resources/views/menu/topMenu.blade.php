<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- <link href="{{ asset('css/main.css') }}" rel="stylesheet"> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Airds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">

                    <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Config::get('languages')[App::getLocale()] }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">{{$language}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else

                                <button id='mybtn' class="btn btn-outline-light" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    @lang('main.cart')
                                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{countsProducts() ? countsProducts() : '0'}}</span>
                                </button>
                                    Кошик
                                </button>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">@lang('main.profile')</a>
                                    @role(['Admin'])
                                        <a href='/admin' class="dropdown-item">@lang('main.adminka')</a>
                                    @endrole

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade bd-example-modal-lg" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div id='cart' class="modal-content">
                <div  class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                    </button>
                </div>
                <div id ='model' class="modal-body"></div>
                <div id ='sum' class="modal-footer"></div>
                <div id ='orderButton' class="modal-footer"></div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
     $(function(){
        function getCartProducts(){
            var arr = [];
            $.ajax({
                method: 'post',
                url: "/basket",
                data:{
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {

                result['ordersFlight'].forEach(function(item){
                    arr [item['id']] = [
                        '<div id=booking'+item['id']+' class="card rounded-3 mb-4">'+
                            '<div class="card-body p-4">'+
                               '<div class="row d-flex justify-content-between align-items-center">'+
                                    '<div class="col-md-5 col-lg-5 col-xl-5">'+
                                        '<a class="lead fw-normal mb-2">'+item['title']+'</a>'+
                                        '<p><span class="text-muted">'+item['time']+'</p>'+
                                    '</div>'+
                                    '<div class="col-md-3 col-lg-3 col-xl-2 d-flex"></div>'+
                                    '<div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">'+
                                        '<h5 class="mb-0">₴ '+item['price']+'</h5>'+
                                    '</div>'+
                                    '<div class="col-md-1 col-lg-1 col-xl-1 text-end">'+
                                        '<a  data-id ='+item['id']+' id = deleteBooking class="text-danger"><h2>&times;</h2>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    ];
                })
                $('#orderButton').html('<a href=/orderProcessing/edit/'+result['order_id']+'>{{__("main.toOrder")}}</a>')
                $('#sum').html('<p><big>{{__("main.sum")}}</big></p> : '+result['sum'])
                $('#model').html(arr)
                $('#exampleModalLong').modal('show')

                if(result['ordersFlight'].length == 0){
                    $('#cart').html('<div class="modal-header">Коршик Порожній<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button></div>');
                }
            });
        }
        $(document).on('click', '#mybtn', function(){
            getCartProducts()
        });

            $(document).on('click', '#deleteBooking', function(){
                var id = $(this).data('id');
                $.ajax({
                    method: 'get',
                    url: "/basket/delete",
                    data:{
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                }).done(function(result) {
                    getCartProducts()
                });
            });
        $(document).on('click', '.close', function(){
            $('#exampleModalLong').modal('hide')
        });

        $(document).on('click', '.booking', function(){
            var id = $(this).data('id');
            $.ajax({
                method: 'post',
                url: "/booking/add",
                data:{
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
            }).done(function(result) {

            });
        });
    });
    </script>
</script>
@yield('content')



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Airds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">

        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
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
                                <button id='mybtn' type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Кошик
                                </button>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">{{ __('Профайл') }}</a>
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
                    arr [item['id']] = ['<div id=booking'+item['id']+' ><a href='+item['link']+'><h3>'+item['title']+'</a>Ціна - '+item['price']+'<button data-id ='+item['id']+' id = deleteBooking>&times;</button></h3><b>'+item['time']+'</b></div>'];

                })
                $('#orderButton').html('<a href=/orderProcessing/edit/'+result['order_id']+'>Оформити Замовлення</a>')
                $('#sum').text('Сума:'+result['sum'])
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
                    method: 'delete',
                    url: "/basket/destroy",
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
              alert('df');
            });
        });
    });
    </script>
</script>

<!-- +   добавити поля
+   user info
+   спосіб доставки
+   вивести поля
+   добавити поля в зам овленні
+   видалити профіль
+   три статуси (новий, активний, видалений)
+   Можливість активувати акаунт користувача
+   функціонал верифікації емейлу


-   Редагкувати профайл ____Набрати -->
-
@yield('content')



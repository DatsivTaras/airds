<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link href="{{ asset('css/main.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/admin">Airds</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul ul class="navbar-nav">
            <a class="nav-link" href='/admin/flights' id="navbarDarkDropdownMenuLink"   >
                @lang('main.flight')
            </a>
            <a class="nav-link" href="/admin/aircrafts" id="navbarDarkDropdownMenuLink"  aria-expanded="false">
                @lang('main.aircrafts')
            </a>
            <a class="nav-link" href="/admin/orders" id="navbarDarkDropdownMenuLink"  aria-expanded="false">
                @lang('main.orders')
            </a>
            <a class="nav-link" href="/admin/delivery" id="navbarDarkDropdownMenuLink"  aria-expanded="false">
                @lang('main.delivery')
            </a>
            <a class="nav-link" href="/admin/users" id="navbarDarkDropdownMenuLink"  aria-expanded="false">
                @lang('main.users')
            </a>
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
      </ul>
    </div>
  </div>
</nav>
@yield('content')

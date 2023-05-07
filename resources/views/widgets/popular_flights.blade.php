 @if(count($users))
    <h3  align='center'>Популярні Країни</h3>
    <div class="row row-cols-1 row-cols-md-4 g-6">
        @foreach($users as $user)
            <div class="col">
                <div class="card h-130">
                    <img src="https://bytur.by/wp-content/uploads/2022/10/cover_original-1024x603.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">@lang('country.'.mb_strtolower($user->name))</h5>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

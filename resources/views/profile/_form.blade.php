
    {{ Form::open(['route' => ['profile.update', $user->id], 'method' => 'put', 'enctype' => 'multipart/form-data','class' => '']) }}
     <div class="row g-3">
        <div class="form-group col-md-6">
            {{ Form::label('text', __('main.name'), ['class' => 'form-label']) }}
            {{ Form::text('name', $user->name , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('text', __('main.surname'), ['class' => 'form-label']) }}
            {{ Form::text('surname', $user->surname , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('text', __('main.phone'), ['class' => 'form-label']) }}
            {{ Form::text('phone_nomber', $user->phone_nomber , ['class' => ' form-control','id'=>'delivery']) }}
        </div>

        <div align='center'>
            {{ Form::submit(!$user->id ? __('main.create') : __('main.update'), ['class' => 'btn btn-primary'])}}
        </div>
</div>
    {{ Form::close() }}




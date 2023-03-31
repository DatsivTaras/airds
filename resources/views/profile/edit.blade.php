@extends('menu/topMenu')

@section('content')
    <h2 align='center'>Редагувати профайл</h2><br>
    {{ Form::open(['route' => ['profile.update', $user->id], 'method' => 'put', 'enctype' => 'multipart/form-data','class' => 'row g-3']) }}
        <div class="form-group col-md-6">
            {{ Form::label('text', "Ім'я", ['class' => 'form-label']) }}
            {{ Form::text('name', $user->name , ['class' => ' form-control','id'=>'delivery']) }}
        </div>

        <div align='center'>
            {{ Form::submit(!$user->id ? __('Створити') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}
@endsection




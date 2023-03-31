
@if(!$deliveries->id)
        {{ Form::open(['route' => ['admin.delivery.store', $deliveries->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    @else
        {{ Form::open(['route' => ['admin.delivery.update', $deliveries->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) }}
    @endif
        <div class="mb-3">
            {{ Form::label('text', 'Спосіб Доставки', ['class' => 'form-label']) }}
            {{ Form::text('name', $deliveries->name , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        <div align='center'>
            {{ Form::submit(!$deliveries->id ? __('Створити') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}


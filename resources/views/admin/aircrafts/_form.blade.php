
    @if(!$aircraft->id)
        {{ Form::open(['route' => ['admin.aircrafts.store', $aircraft->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    @else
        {{ Form::open(['route' => ['admin.aircrafts.update', $aircraft->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) }}
    @endif
        <div class="mb-3">
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::text('name', $aircraft->name , ['class' => ' form-control','id'=>'countryOfDispatch']) }}
            @error('name')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::file('aircrafts_image',  ['class' => ' form-control']) }}
            @error('aircrafts_image')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Країна Відправки', ['class' => 'form-label']) }}
            {{ Form::textarea('description', $aircraft->description , ['class' => ' form-control','id'=>'countryOfDispatch']) }}
            @error('description')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', '1 клас', ['class' => 'form-label']) }}
            {{ Form::number('first_class', $aircraft->first_class , ['max' => '10']) }}
            @error('first_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', '2 клас', ['class' => 'form-label']) }}
            {{ Form::number('second_class', $aircraft->second_class ,['min' => '10']) }}
            @error('second_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text', 'Економ', ['class' => 'form-label']) }}
            {{ Form::number('economy_class', $aircraft->economy_class , ['min' => '10', 'max' => '50'] ) }}
            @error('economy_class')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror


      </div>

        <div align='center'>
            {{ Form::submit(!$aircraft->id ? __('Створити') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}



    {{ Form::open(['route' => ['password.changePassword'], 'method' => 'post', 'enctype' => 'multipart/form-data','class' => 'row g-3']) }}
        <div class="form-group col-md-12">
            {{ Form::label('text', __('main.currentPassword'), ['class' => 'form-label']) }}
            {{ Form::text('current_password', '' , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        @error('current_password')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
        <div class="form-group col-md-6">
            {{ Form::label('text',__('main.newPassword'), ['class' => 'form-label']) }}
            {{ Form::text('password','' , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('text', __('main.repeatPassword'), ['class' => 'form-label']) }}
            {{ Form::text('password_confirmation', '' , ['class' => ' form-control','id'=>'delivery']) }}
        </div>
        @error('password')
            <h7 style='color:red'>{{$message}}</h7><br>
        @enderror
        <div align='center'>
            {{ Form::submit(__('main.change'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}


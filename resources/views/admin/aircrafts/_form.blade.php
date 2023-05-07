
    @if(!$aircraft->id)
        {{ Form::open(['route' => ['admin.aircrafts.store', $aircraft->id], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'row g-2']) }}
    @else
        {{ Form::open(['route' => ['admin.aircrafts.update', $aircraft->id], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'row g-2']) }}
    @endif
            {{ Form::label('text', __('main.name'), ['class' => 'form-label']) }}
            {{ Form::text('name', $aircraft->name , ['class' => ' form-control','id'=>'countryOfDispatch']) }}
            @error('name')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            <br><div id='preview'></div>
            {{ Form::label('text',  __('main.photo'), ['class' => 'form-label']) }}
            {{ Form::file('aircrafts_image[]',  [ 'id'=>'imageair' ,'class' => 'form-control', 'onchange'=> "getImagePreview(event)", "multiple" => "multiple"]) }}
            <div id='previewImage' class="row g-3"></div>
            @error('aircrafts_image')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            {{ Form::label('text',  __('main.description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', $aircraft->description , ['class' => ' form-control','id'=>'countryOfDispatch']) }}
            @error('description')
            <h7 style='color:red'>{{$message}}</h7><br>
            @enderror
            <div class="form-group col-md-4">
                {{ Form::label('text',   __('main.oneClass'), ['class' => 'form-label']) }}
                {{ Form::number('first_class', $aircraft->first_class ,  ['class' => 'form-select']) }}
                @error('first_class')
                <h7 style='color:red'>{{$message}}</h7><br>
                @enderror
            </div>
            <div class="form-group col-md-4">
                {{ Form::label('text',   __('main.twoClass'), ['class' => 'form-label']) }}
                {{ Form::number('second_class', $aircraft->second_class , ['class' => 'form-select', 'id'=>'citiOfArrival']) }}
                @error('second_class')
                <h7 style='color:red'>{{$message}}</h7><br>
                @enderror
            </div>
            <div class="form-group col-md-4">
                {{ Form::label('text', __('main.threeClass'), ['class' => 'form-label']) }}
                {{ Form::number('economy_class', $aircraft->economy_class ,  ['class' => 'form-select', 'id'=>'citiOfArrival'] ) }}
                @error('economy_class')
                <h7 style='color:red'>{{$message}}</h7><br>
                @enderror<br>
            </div>
        </div>
        <div align='center'>
            {{ Form::submit(!$aircraft->id ? __('main.create') : __('Редагувати'), ['class' => 'btn btn-primary'])}}
        </div>
    {{ Form::close() }}


<script>

    const input = document.getElementById("imageair")
    const output = document.getElementById("previewImage")

    let imagesArray = []

    input.addEventListener("change", () => {
        const files = input.files
        for (let i = 0; i < files.length; i++) {
            imagesArray.push(files[i])
        }
        displayImages()
    })
    function displayImages() {
        let images = ""
        imagesArray.forEach((image, index) => {
            images += ` <div  class="imgs form-group col-md-6">
                            <img width=220 height=130 src="${URL.createObjectURL(image)}" alt="image">
                            <span onclick="deleteImage(${index})">&times;</span>
                        </div>`
        })
        output.innerHTML = images
    }
    function deleteImage(index) {
        imagesArray.splice(index, 1)
        displayImages()
    }
    </script>



@extends('layouts.admin')

@section('content')
    <h1>Редагування Тому</h1>
    <form action="{{ route('admin.toms.update', $tom->id) }}" method="POST" enctype="multipart/form-data" id="tom-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Назва</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $tom->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Ціна</label>
            <input id="price" name="price" class="form-control" type="number" required value="{{ $tom->price }}"></input>
        </div>
        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" id="images" name="images[]" class="form-control" multiple>
            <div id="preview" class="mt-3">
                @if($images)
                    @foreach($images as $image)
                        <img src="{{ asset($image->url) }}" style="max-width: 100px; margin-right: 10px; margin-bottom: 10px;">
                    @endforeach
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
            if (!file.type.startsWith('image/')) {
                alert('Only image files are allowed.');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                img.style.marginRight = '10px';
                img.style.marginBottom = '10px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection

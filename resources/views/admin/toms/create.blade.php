@extends('layouts.admin')

@section('content')
    <h1>Create Tom</h1>
    <form action="{{ route('admin.toms.store') }}" method="POST" enctype="multipart/form-data" id="tom-form">
        @csrf
        <div class="form-group">
            <label for="name">Назва</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Ціна</label>
            <input id="price" name="price" class="form-control" type="number" required></input>
        </div>
        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" id="images" name="images[]" class="form-control" multiple>
            <div id="preview" class="mt-3"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
    <style>
        #preview img {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
    
<script>
    document.getElementById('images').addEventListener('change', function(event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        Array.from(event.target.files).forEach(file => {
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

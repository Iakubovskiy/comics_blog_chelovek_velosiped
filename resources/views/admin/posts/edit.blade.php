@extends('layouts.admin')

@section('content')
    <h1>Edit Post</h1>
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="post-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ $post->Description }}</textarea>
        </div>
        <div class="form-group">
            <label for="tom_id">Tom ID</label>
            <input type="number" id="tom_id" name="tom_id" class="form-control" value="{{ $post->tom_id }}" required>
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

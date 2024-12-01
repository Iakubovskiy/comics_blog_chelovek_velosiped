@extends('layouts.app')

@section('title', 'Глави - ' . $tom->name)
@vite(['resources/css/posts_styles.css'])
@section('content')
<div class="container mt-6">
    <h1 class="text-2xl font-bold mb-4">Глави тому "{{ $tom->name }}"</h1>
    
    <form action="{{ route('posts.index', $tom->id) }}" method="GET" class="mb-6">
        <div class="input-group">
            <input type="text" name="search" 
                   value="{{ request('search') }}"
                   placeholder="Пошук за назвою..."
                   class="form-control">
            <button type="submit" 
                    class="btn btn-teal">
                Шукати
            </button>
        </div>
    </form>
    
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                @if($post->images)
                    <img src="{{ $post->images->where('pivot.photo_number', 1)->first()->url }}" 
                         alt="{{ $post->title }}" 
                         class="card-img-top">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" 
                         alt="Зображення відсутнє" 
                         class="card-img-top">
                @endif
                
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    @if($post->Description)
                    <p class="card-text">{{ Str::limit($post->Description, 100) }}</p>
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-teal">Читати</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

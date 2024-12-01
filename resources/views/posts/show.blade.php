@extends('layouts.app')

@section('title', $post->title)
@vite(['resources/css/post_details_styles.css'])
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6">{{ $post->title }}</h1>
        
        @if($post->Description)
        <div class="prose mb-8">
            {{ $post->Description }}
        </div>
        @endif
        
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($post->images->sortBy('pivot.photo_number') as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ $image->url }}" 
                         alt="Сторінка {{ $image->pivot->photo_number }}"
                         class="d-block w-100 img-carousel" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{ $image->url }}">
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="mt-6 flex justify-between">
            @if($previousPost = $post->tom->post->where('id', '<', $post->id)->sortByDesc('id')->first())
            <a href="{{ route('posts.show', $previousPost->id) }}" 
               class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                ← Попередня глава
            </a>
            @endif
            
            @if($nextPost = $post->tom->post->where('id', '>', $post->id)->sortBy('id')->first())
            <a href="{{ route('posts.show', $nextPost->id) }}" 
               class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Наступна глава →
            </a>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">
      <div class="modal-body">
        <div id="carouselModal" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach($post->images->sortBy('pivot.photo_number') as $image)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
              <img src="{{ $image->url }}" 
                   alt="Сторінка {{ $image->pivot->photo_number }}"
                   class="d-block w-100 img-carousel-modal">
            </div>
            @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselModal" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselModal" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
      </div>
    </div>
  </div>
</div>
<script>
    const modalImage = document.getElementById('modalImage');
    const imageElements = document.querySelectorAll('.img-carousel');

    imageElements.forEach((img) => {
        img.addEventListener('click', (event) => {
            const src = event.target.getAttribute('data-src');
            modalImage.setAttribute('src', src);
        });
    });
</script>
@endsection

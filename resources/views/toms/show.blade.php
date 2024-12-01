@extends('layouts.app')

@section('title', $tom->name)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold mb-6">{{ $tom->name }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <!-- Головне фото -->
            <img src="{{ $tom->photos->where('pivot.photo_number', 1)->first()->url ?? asset('images/placeholder.jpg') }}" 
                 alt="{{ $tom->name }}" 
                 class="w-full rounded-lg mb-4">
            
            <!-- Галерея інших фото -->
            <div class="grid grid-cols-4 gap-2">
                @foreach($tom->photos->sortBy('pivot.photo_number') as $photo)
                    <img src="{{ $photo->url }}" 
                         alt="Фото {{ $photo->pivot->photo_number }}"
                         class="w-full aspect-square object-cover rounded cursor-pointer hover:opacity-75"
                         onclick="document.querySelector('.main-image').src = this.src">
                @endforeach
            </div>
        </div>
        
        <div>
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-teal-600 mb-2">{{ $tom->price }} грн</h2>
                @auth
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="tom_id" value="{{ $tom->id }}">
                    <div class="flex space-x-2">
                        <input type="number" name="quantity" value="1" min="1"
                               class="w-20 rounded border-gray-300">
                        <button type="submit" 
                                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                            Додати в кошик
                        </button>
                    </div>
                </form>
                @endauth
                
                <a href="{{ route('posts.index', $tom->id) }}" 
                   class="inline-block bg-teal-500 text-white px-6 py-2 rounded hover:bg-teal-600">
                    Читати глави
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
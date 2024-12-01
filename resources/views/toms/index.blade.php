@extends('layouts.app')
@section('title', 'Томи коміксу')
@vite(['resources/css/toms_styles.css'])
@section('content')
<div class="mb-4">
    <form action="{{ route('toms.index') }}" method="GET" class="d-flex justify-content-center">
        <input type="text" name="search" class="form-control w-50" placeholder="Пошук за назвою..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary ml-2">Пошук</button>
    </form>
</div>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($toms as $tom)
    <div class="col">
        <div class="card shadow-sm border-0">
            <img src="{{ $tom->photos->where('pivot.photo_number', 1)->first()->url ?? asset('images/placeholder.jpg') }}" 
                 alt="{{ $tom->name }}" 
                 class="card-img-top" style="height: 250px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title text-center text-primary">{{ $tom->name }}</h5>
                <p class="card-text text-center text-muted">{{ $tom->Description ?? 'Без опису' }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="text-lg font-bold text-teal-600">{{ $tom->price }} грн</span>
                    <div class="d-flex gap-3 align-items-center">
                        
                        @auth
                        <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-2">
                            <a href="{{ route('posts.index', $tom->id) }}" class="btn btn-outline-primary primary-custom">Читати</a>
                            @csrf
                            <input type="hidden" name="tom_id" value="{{ $tom->id }}">
                            <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-success success-custom">Замовити</button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@extends('layouts.app')

@section('title', 'Кошик')
@vite(['resources/css/cart_styles.css'])
@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold mb-6">Кошик</h1>
    
    @if($items->count() > 0)
    <div class="space-y-4">
        @foreach($items as $item)
        <div class="d-flex justify-content-between align-items-center border-bottom pb-4 item-container">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ $item->photos->where('pivot.photo_number', 1)->first()->url ?? asset('images/placeholder.jpg') }}"
                     alt="{{ $item->name }}"
                     class="w-100px h-100px object-cover rounded">
                <div>
                    <h3 class="font-weight-bold">{{ $item->name }}</h3>
                    <p class="text-muted">{{ $item->price }} грн</p>
                </div>
            </div>
            
            <div class="d-flex gap-3 align-items-center">
                <form action="{{ route('cart.update') }}" method="POST" class="d-flex gap-2 align-items-center">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tom_id" value="{{ $item->id }}">
                    <input type="number" name="quantity" 
                           value="{{ $item->pivot->quantity }}" 
                           min="1"
                           class="form-control w-50">
                    <button type="submit" 
                            class="btn btn-teal">Оновити</button>
                </form>
                
                <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="tom_id" value="{{ $item->id }}">
                    <button type="submit" 
                            class="btn btn-outline-danger">
                        Видалити
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="text-xl">
                <span class="font-weight-bold">Загальна сума:</span>
                <span class="text-teal-600 font-weight-bold">{{ $total }} грн</span>
            </div>
            
            <div class="d-flex gap-3 item-container">
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-outline-danger">
                        Очистити кошик
                    </button>
                </form>
                
                <form action="{{ route('orders.store') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" 
                            class="btn btn-success" style="background-color: #3cbc3c!important; border-color: #3cbc3c!important;">
                        Оформити замовлення
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-muted mb-4">Ваш кошик порожній</p>
        <a href="{{ route('toms.index') }}" 
           class="btn btn-teal">
            Перейти до каталогу
        </a>
    </div>
    @endif
</div>
@endsection

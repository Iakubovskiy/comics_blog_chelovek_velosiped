@extends('layouts.app')

@section('title', 'Деталі замовлення')
@vite(['resources/css/order_details_styles.css'])
@section('content')
<div class="container bg-white rounded-lg shadow-lg p-5">
    <h1 class="text-3xl font-weight-bold mb-4">Замовлення #{{ $order->id }}</h1>

    <div class="mb-4">
        <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p><strong>Статус:</strong> {{ $order->status }}</p>
        <p><strong>Загальна сума:</strong> {{ $order->toms->sum(fn($item) => $item->pivot->quantity * $item->price) }} грн</p>
    </div>

    <div class="list-group">
        @foreach($order->toms as $tom)
        <div class="list-group-item d-flex justify-content-between align-items-center border-bottom pb-4">
            <div class="d-flex align-items-center">
                <img src="{{ $tom->photos->where('pivot.photo_number', 1)->first()->url ?? asset('images/placeholder.jpg') }}" 
                     alt="{{ $tom->name }}" 
                     class="w-20 h-20 object-cover rounded">
                <div class="ml-3">
                    <h3 class="font-weight-bold">{{ $tom->name }}</h3>
                    <p class="text-muted">Ціна: {{ $tom->price }} грн</p>
                    <p class="text-muted">Кількість: {{ $tom->pivot->quantity }}</p>
                </div>
            </div>
            <div>
                <p class="text-teal-600 font-weight-bold">
                    Вартість: {{ $tom->pivot->quantity * $tom->price }} грн
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

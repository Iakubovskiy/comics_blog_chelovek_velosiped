@extends('layouts.app')

@section('title', 'Мої замовлення')
@vite(['resources/css/order_styles.css'])
@section('content')
<div class="container bg-white rounded-lg shadow-lg p-5">
    <h1 class="text-3xl font-weight-bold mb-4">Мої замовлення</h1>

    @if($orders->isEmpty())
        <p class="text-muted">У вас ще немає замовлень.</p>
    @else
        <div class="list-group">
            @foreach($orders as $order)
                <div class="list-group-item d-flex justify-content-between align-items-center border-bottom pb-4">
                    <div>
                        <p><strong>Замовлення #{{ $order->id }}</strong></p>
                        <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Статус:</strong> {{ $order->status }}</p>
                    </div>
                    <div>
                        <p><strong>Загальна сума:</strong> 
                            {{ $order->toms->sum(fn($item) => $item->pivot->quantity * $item->price) }} грн
                        </p>
                        <a href="{{ route('orders.show', $order->id) }}" 
                           class="text-teal-600 hover:text-teal-800">
                            Переглянути деталі
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Редагування замовлення #{{ $order->number }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Статус</label>
            <select id="status" name="status" class="form-control">
                @foreach (\App\Models\Order::getStatuses() as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Товари</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Назва</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody id="order-items">
                @foreach ($order->toms as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            <input type="number" name="items[{{ $item->id }}][quantity]" class="form-control" value="{{ $item->pivot->quantity }}">
                        </td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-id="{{ $item->id }}">Видалити</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group">
            <label for="add-tom">Додати товар</label>
            <select id="add-tom" class="form-control">
                <option value="">-- Виберіть товар --</option>
                @foreach ($toms as $tom)
                    <option value="{{ $tom->id }}">{{ $tom->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Зберегти</button>
    </form>
</div>

<script>
    document.getElementById('add-tom').addEventListener('change', function () {
        const tomId = this.value;
        const tomName = this.options[this.selectedIndex].text;

        if (tomId) {
            const row = `
                <tr>
                    <td>${tomName}</td>
                    <td><input type="number" name="items[${tomId}][quantity]" class="form-control" value="1"></td>
                    <td>--</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-item" data-id="${tomId}">Видалити</button></td>
                </tr>
            `;
            document.getElementById('order-items').insertAdjacentHTML('beforeend', row);
            this.value = 

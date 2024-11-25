@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Замовлення</h1>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="number">Номер замовлення</label>
                <input type="text" id="number" name="number" class="form-control" value="{{ request('number') }}">
            </div>
            <div class="col-md-4">
                <label for="created_at_from">Дата створення (від)</label>
                <input type="date" id="created_at_from" name="created_at_from" class="form-control" value="{{ request('created_at_from') }}">
            </div>
            <div class="col-md-4">
                <label for="created_at_to">Дата створення (до)</label>
                <input type="date" id="created_at_to" name="created_at_to" class="form-control" value="{{ request('created_at_to') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Фільтрувати</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Дата створення</th>
                <th>Статус</th>
                <th>Загальна сума</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->number }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Замовлень немає</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

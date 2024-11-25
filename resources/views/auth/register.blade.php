@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Реєстрація</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">Ім'я</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="login">Логін</label>
            <input type="text" name="login" class="form-control" value="{{ old('login') }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="c_password">Підтвердження паролю</label>
            <input type="password" name="c_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Зареєструватися</button>
    </form>
</div>
@endsection

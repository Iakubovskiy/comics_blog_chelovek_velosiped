@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати роль</h1>

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Назва ролі</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Оновити</button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Додати нову главу</h1>

        <form action="{{ route('admin.chapters.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Назва</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tom_id">Том</label>
                <select class="form-control" id="tom_id" name="tom_id" required>
                    @foreach ($toms as $tom)
                        <option value="{{ $tom->id }}">{{ $tom->name }}</option>
                    @endforeach
                </select>
                @error('tom_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Створити</button>
            <a href="{{ route('admin.chapters.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>
    </div>
@endsection

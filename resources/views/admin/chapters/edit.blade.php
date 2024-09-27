@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редагувати главу: {{ $chapter->name }}</h1>

        <form action="{{ route('admin.chapters.update', $chapter) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Назва</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $chapter->name }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tom_id">Том</label>
                <select class="form-control" id="tom_id" name="tom_id" required>
                    @foreach ($toms as $tom)
                        <option value="{{ $tom->id }}" {{ $chapter->tom_id == $tom->id ? 'selected' : '' }}>
                            {{ $tom->name }}
                        </option>
                    @endforeach
                </select>
                @error('tom_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Оновити</button>
            <a href="{{ route('admin.chapters.index') }}" class="btn btn-secondary">Скасувати</a>
        </form>
    </div>
@endsection

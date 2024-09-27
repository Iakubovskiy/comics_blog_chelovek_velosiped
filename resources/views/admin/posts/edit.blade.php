@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px; margin: 0 auto;">
        <div class="card">
            <div class="card-header">
                <h2>Редагування посту "{{ $post->title }}"</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="title">Назва посту</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="Description">Опис</label>
                        <textarea class="form-control" id="Description" name="Description" rows="3">{{ old('Description', $post->Description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="tom_id">Том</label>
                        <select class="form-control" id="tom_id" name="tom_id" required>
                            <option value="">Виберіть том</option>
                            @foreach ($toms as $tom)
                                <option value="{{ $tom->id }}" {{ $tom->id == $post->tom_id ? 'selected' : '' }}>{{ $tom->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="chapter_id">Глава</label>
                        <select class="form-control" id="chapter_id" name="chapter_id" required>
                            <option value="">Виберіть главу</option>
                            @foreach ($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ $chapter->id == $post->chapter_id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning">Зберегти зміни</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Назад</a>
                </form>
            </div>
        </div>
    </div>
@endsection

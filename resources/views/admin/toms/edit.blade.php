@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Редагування Тома: {{ $tom->name }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.toms.update', $tom) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Ім'я Тома</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $tom->name }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-warning">Зберегти зміни</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад
                        </button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.toms.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection

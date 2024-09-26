@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 500px; margin: 0 auto; padding-bottom: 50px;">
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.8);">
            <div class="card-header" style="background-color: #d6d6d6;">
                <h2>Додавання нового типу підписки</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscriptionTypes.store') }}" method="POST">
                    @csrf
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
                        <label for="type">Назва типу підписки</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Ціна</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="features">Особливості</label>
                        <textarea class="form-control" id="features" name="features">{{ old('features') }}</textarea>
                        @error('features')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Додати тип підписки</button>
                        <button type="button" class="btn btn-outline-primary mx-3" id="back-button">
                            <i class="fas fa-arrow-left"></i> Назад
                        </button>
                    </div>

                    <script>
                        document.getElementById('back-button').addEventListener('click', function() {
                            window.location.href = "{{ route('admin.subscriptionTypes.index') }}";
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection

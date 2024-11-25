@extends('layouts.admin')

@section('content')
    <h1>Posts</h1>
    <a href="{{ route('admin.toms.create') }}" class="btn btn-primary">Створити новий том</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($toms as $tom)
                <tr>
                    <td>{{ $tom->name }}</td>
                    <td>{{ $tom->price }}</td>
                    <td>
                        <a href="{{ route('admin.toms.edit', $tom->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.toms.destroy', $tom->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

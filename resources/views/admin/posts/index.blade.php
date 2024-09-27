@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Пости</h1>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Додати новий пост
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою" value="{{ request('query') }}">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Постів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 605px; overflow-y: auto;">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th>Назва</th>
                    <th>Том</th>
                    <th>Глава</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="posts-table-body">
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->tom->name }}</td>
                        <td>{{ $post->chapter->name }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $post->title }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('posts-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchPosts(searchInput.value));

            function fetchPosts(query) {
                fetch(`{{ route('admin.posts.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.posts);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(posts) {
                tableBody.innerHTML = '';
                if (posts.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    posts.forEach(post => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${post.title}</td>
                        <td>${post.tom.name}</td>
                        <td>${post.chapter.name}</td>
                        <td>
                            <a href="{{ url('admin/posts') }}/${post.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin/posts') }}/${post.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${post.title}')">
                                @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
`;
                        tableBody.appendChild(row);
                    });
                }
            }
        });
    </script>
@endsection

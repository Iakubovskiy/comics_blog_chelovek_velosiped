@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Глави</h1>
            <a href="{{ route('admin.chapters.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Додати нову главу
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
            Глав не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 605px; overflow-y: auto;">
            <table class="table table-bordered">
                <thead class="thead-light">
                <tr>
                    <th>Назва</th>
                    <th>Том</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="chapters-table-body">
                @foreach ($chapters as $chapter)
                    <tr>
                        <td>{{ $chapter->name }}</td>
                        <td>{{ $chapter->tom->name }}</td>
                        <td>
                            <a href="{{ route('admin.chapters.edit', $chapter) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.chapters.destroy', $chapter) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $chapter->name }}')">
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
            const tableBody = document.getElementById('chapters-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchChapters(searchInput.value));

            function fetchChapters(query) {
                fetch(`{{ route('admin.chapters.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.chapters);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(chapters) {
                tableBody.innerHTML = '';
                if (chapters.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    chapters.forEach(chapter => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${chapter.name}</td>
                        <td>${chapter.tom.name}</td>
                        <td>
                            <a href="{{ url('admin/chapters') }}/${chapter.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin/chapters') }}/${chapter.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${chapter.name}')">
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

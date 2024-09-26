@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Томи</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.toms.create') }}" class="btn btn-success" style="width: 260px; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати нового Тома
                </a>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою" value="{{ request('query') }}">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Томів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 605px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th>Ім'я</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="toms-table-body">
                @foreach ($toms as $tom)
                    <tr>
                        <td>{{ $tom->name }}</td>
                        <td>
                            <a href="{{ route('admin.toms.edit', $tom) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.toms.destroy', $tom) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $tom->name }}')">
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
            const tableBody = document.getElementById('toms-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchToms(searchInput.value));

            function fetchToms(query) {
                fetch(`{{ route('admin.toms.filter') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.toms);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(toms) {
                tableBody.innerHTML = '';
                if (toms.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    toms.forEach(tom => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${tom.name}</td>
                        <td>
                            <a href="{{ url('admin/toms') }}/${tom.id}/edit" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin/toms') }}/${tom.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${tom.name}')">
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

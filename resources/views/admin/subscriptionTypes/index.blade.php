@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Типи підписок</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.subscriptionTypes.create') }}" class="btn btn-success" style="width: 260px; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати новий тип підписки
                </a>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за назвою">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Користувачів не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 605px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th>Тип</th>
                    <th>Ціна</th>
                    <th>Фічі</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="subscriptionTypes-table-body">
                @foreach ($subscriptionTypes as $subscriptionType)
                    <tr>
                        <td>{{ $subscriptionType->type }}</td>
                        <td>{{ $subscriptionType->price }}</td>
                        <td>{{ $subscriptionType->features }}</td>
                        <td>
                            <a href="{{ route('admin.subscriptionTypes.edit', $subscriptionType) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.subscriptionTypes.destroy', $subscriptionType) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $subscriptionType->type }}')">
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
            const roleFilter = document.getElementById('role-filter');
            const resetButton = document.getElementById('reset-filter');
            const tableBody = document.getElementById('subscriptionTypes-table-body');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => fetchSubscriptionTypes(searchInput.value, roleFilter.value));
            roleFilter.addEventListener('change', () => fetchSubscriptionTypes(searchInput.value, roleFilter.value));
            resetButton.addEventListener('click', () => {
                searchInput.value = '';
                roleFilter.value = '';
                fetchSubscriptionTypes('', '');
            });

            function fetchSubscriptionTypes(query, role) {
                fetch(`{{ route('admin.subscriptionTypes.filter') }}?query=${encodeURIComponent(query)}&role=${encodeURIComponent(role)}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data.subscriptionTypes);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function updateTable(subscriptionTypes) {
                tableBody.innerHTML = '';
                if (subscriptionTypes.length === 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                    subscriptionTypes.forEach(subscriptionType => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${subscriptionType.type}</td>
                        <td>${subscriptionType.price}</td>
                        <td>${subscriptionType.features}</td>

                    `;
                        tableBody.appendChild(row);
                    });
                }
            }
        });
    </script>

@endsection

@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Користувачі</h1>
            <a href="" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Повернутися на головну
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 d-flex align-items-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success" style="width: 260px; white-space: nowrap;">
                    <i class="fas fa-plus"></i> Додати нового користувача
                </a>
            </div>

            <div class="col-md-4">
                <label for="role-filter" class="form-label" style="margin-left: 200px; width: 250px;">Фільтр за типом користувача</label>
                <div class="input-group" style="width: 250px; margin-left: 200px;">
                    <span class="input-group-text">
                        <i class="fas fa-filter"></i>
                    </span>
                    <select id="role-filter" class="form-control">
                        <option value="">Усі користувачі</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <button id="reset-filter" class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="input-group" style="width: 300px; margin-left: auto;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук за логіном">
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
                    <th>Логін</th>
                    <th>ПІБ</th>
                    <th>Електронна пошта</th>
                    <th>Телефон</th>
                    <th>Роль</th>
                    <th>Підписка</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody id="user-table-body">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            @if ($user->subscription)
                                {{ optional($user->subscription->subscriptionType)->type ?? 'Немає підписки' }}
                            @else
                                Немає підписки
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete('{{ $user->login }}')">
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
        document.getElementById('search').addEventListener('input', function() {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('role-filter').addEventListener('change', function() {
            const query = document.getElementById('search').value;
            const role = document.getElementById('role-filter').value;
            fetchUsers(query, role);
        });

        document.getElementById('reset-filter').addEventListener('click', function() {
            document.getElementById('search').value = '';
            document.getElementById('role-filter').value = '';
            fetchUsers('', '');
        });

        function fetchUsers(query, role) {
            fetch(`{{ route('admin.users.filter') }}?query=${encodeURIComponent(query)}&role=${encodeURIComponent(role)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('user-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.users.length === 0) {
                        noResults.style.display = 'block';
                    } else {
                        noResults.style.display = 'none';
                        data.users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${user.login}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.role.name}</td>

                                <td>{{ $user->subscription ?? 'Немає підписки' }}</td>
                                <td>
                                    <a href="/admin/users/${user.id}/edit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/users/${user.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${user.login}')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>`;
                            tableBody.appendChild(row);
                        });
                    }
                });
        }

        function confirmDelete(login) {
            return confirm(`Ви точно бажаєте видалити користувача з логіном "${login}"?`);
        }
    </script>
@endsection

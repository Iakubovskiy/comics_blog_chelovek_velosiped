@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Адмін Панель</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg">Користувачі</a>
                    <a href="{{ route('admin.subscriptionTypes.index') }}" class="btn btn-secondary btn-lg">Типи Підписок</a>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-success btn-lg">Ролі</a>
                    <a href="{{ route('admin.toms.index') }}" class="btn btn-danger btn-lg">Томи</a>
                    <a href="{{ route('admin.chapters.index') }}" class="btn btn-warning btn-lg">Глави</a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-info btn-lg">Пости</a>
                </div>
            </div>
        </div>
    </div>
@endsection

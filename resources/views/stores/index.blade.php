@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Список магазинов</div>
                <br>
                <div class="row justify-content-center">
                    <a role="button" href="{{ URL::to("/stores/create") }}" class="btn btn-primary">Добавить новую запись</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Улица</th>
                            <th scope="col">Город</th>
                            <th scope="col">Ценники</th>
                            <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                            <tr>
                            <th scope="row">{{ $store->id }}</th>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->street }}</td>
                            <td>{{ $store->city }}</td>
                            <td>{{ $store->numprice_on_object }}</td>
                            <td>
                                <a role="button" href="{{ URL::to("/stores/view/{$store->id}") }}" class="btn btn-primary">Посмотреть</a>
                                <a role="button" href="{{ URL::to("/stores/change/{$store->id}") }}" class="btn btn-primary">Изменить</a>
                                <a role="button" href="{{ URL::to("/stores/remove/{$store->id}") }}" class="btn btn-primary">Удалить</a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

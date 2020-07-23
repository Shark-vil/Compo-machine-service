@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Список тикетов</div>
                <br>
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
                            @foreach ($tickets as $ticket)
                            <tr>
                            <th scope="row">{{ $ticket['id'] }}</th>
                            <td>{{ $ticket['name'] }}</td>
                            <td>{{ $ticket['street'] }}</td>
                            <td>{{ $ticket['city'] }}</td>
                            <td>{{ $ticket['numprice_on_object'] }}</td>
                            <td>
                                <a role="button" href="{{ URL::to("/tickets/{$ticket['id']}") }}" class="btn btn-primary">Посмотреть</a>
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

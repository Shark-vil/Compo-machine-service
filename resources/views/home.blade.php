@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Мониторинг</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">@</th>
                            <th scope="col">#</th>
                            <th scope="col">Магазин</th>
                            <th scope="col">Улица</th>
                            <th scope="col">Город</th>
                            <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $key => $store)
                            <tr>
                            <td><img src=""/></td>
                            <td scope="row">{{ $store->id }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->street }}</td>
                            <td>{{ $store->city }}</td>
                            <td>
                                @if (!in_array($store->id, $tickets_open))
                                    <!--
                                    <form method="POST" action="{{ URL::to("/tickets/store/{$store->id}") }}">
                                        <button type="submit" class="btn btn-primary">Открыть тикет</button>
                                    </form>
                                    -->
                                   
                                    <a role="button" href="{{ URL::to("/tickets/open/{$store->id}") }}" class="btn btn-primary">Открыть тикет</a>       
                                @else
                                    <a role="button" href="{{ URL::to("/tickets/{$tickets_ids[$key]}") }}" class="btn btn-primary">Открыть переписку</a>
                                @endif
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

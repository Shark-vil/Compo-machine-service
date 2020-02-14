@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Список магазинов</div>
                <div class="card-body">
                    <h3>Магазин:</h3>
                    <p>{{ $data->content->name }}</p>
                    <h3>Город:</h3>
                    <p>{{ $data->content->city }}</p>
                    <h3>Улица:</h3>
                    <p>{{ $data->content->street }}</p>
                    <h3>Количество ценников:</h3>
                    <p>{{ $data->content->numprice_on_object }}</p>
                    <h3>Дополнительная информация:</h3>
                    <div class="md-form">
                        <textarea readonly class="md-textarea form-control" rows="3">{{ $data->content->additional_information }}</textarea>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a role="button" href="{{ URL::to("/stores") }}" 
                                class="btn btn-primary">Назад</a>
                        </div>
                        <div>
                            <a role="button" href="{{ URL::to("/stores/change/{$data->content->id}") }}" 
                                class="btn btn-primary">Изменить</a>
                            <a role="button" href="{{ URL::to("/stores/remove/{$data->content->id}") }}" 
                                class="btn btn-primary">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

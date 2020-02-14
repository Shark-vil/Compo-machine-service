@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Добавление магазина</div>

                @if ( isset( $data ) && isset( $data->error ) )
                    <div class="container">
                        <br>
                        <div class="row justify-content-center">
                            <h1>Ошибка!</h1>
                        </div>
                        <div class="row justify-content-center">
                            {{ $data->error->description }}
                        </div>
                    </div>
                @endif

                <div class="card-body">
                    {!! Form::open( ['url' => "stores/change/{$data->content->id}", 'method' => 'POST' ] ) !!}
                        <div class="form-group">
                            {{ Form::label( 'title', 'Название' ) }}
                            {{ Form::text( 'name', "{$data->content->name}", [ 'class' => 'form-control', 'placeholder' => 'Введите название магазина' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Улица' ) }}
                            {{ Form::text( 'street', "{$data->content->street}", [ 'class' => 'form-control', 'placeholder' => 'Введите название улицы' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Город' ) }}
                            {{ Form::text( 'city', "{$data->content->city}", [ 'class' => 'form-control', 'placeholder' => 'Введите название города' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Количество ценников' ) }}
                            {{ Form::number( 'numprice_on_object', "{$data->content->numprice_on_object}", [ 'class' => 'form-control', 'placeholder' => 'Укажите количество ценников на объекте' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Дополнительная информация' ) }}
                            {{ Form::textarea( 'additional_information', "{$data->content->additional_information}", [ 'class' => 'form-control', 'placeholder' => 'Можете указать дополнительную информацию' ] ) }}
                            <br>
                            <!-- {{ Form::submit('Добавить') }} -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a role="button" href="{{ URL::to("/stores") }}" 
                                        class="btn btn-primary">Назад</a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Обновить</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create</div>

                <div class="card-body">
                    {!! Form::open( ['url' => 'api/stores/store', 'method' => 'POST' ] ) !!}
                        <div class="form-group">
                            {{ Form::label( 'title', 'Название' ) }}
                            {{ Form::text( 'name', '', [ 'class' => 'form-control', 'placeholder' => 'Введите название магазина' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Улица' ) }}
                            {{ Form::text( 'street', '', [ 'class' => 'form-control', 'placeholder' => 'Введите название улицы' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Город' ) }}
                            {{ Form::text( 'city', '', [ 'class' => 'form-control', 'placeholder' => 'Введите название города' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Количество ценников' ) }}
                            {{ Form::number( 'numprice_on_object', '', [ 'class' => 'form-control', 'placeholder' => 'Укажите количество ценников на объекте' ] ) }}
                            <br>
                            {{ Form::label( 'title', 'Дополнительная информация' ) }}
                            {{ Form::textarea( 'additional_information', '', [ 'class' => 'form-control', 'placeholder' => 'Можете указать дополнительную информацию' ] ) }}
                            <br>
                            {{ Form::submit('Отправить') }}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

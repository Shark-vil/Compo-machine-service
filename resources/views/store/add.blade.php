@extends('app')

@section('content')

    <h1>Create</h1>
    {!! Form::open( ['action' => 'StoreController@show', 'method' => 'POST' ] ) !!}
        <div class="form-group">
            {{ Form::label( 'title', 'Title' ) }}
            {{ Form::text( 'title', '', [ 'class' => 'form-control', 'placeholder' => 'Title' ] ) }}
        </div>
    {!! Form::close() !!}

@endsection
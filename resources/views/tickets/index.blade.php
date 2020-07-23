@extends('layouts.chat')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Переписка</div>
                <div id="chatBlock" class="card-body scroll"></div>
                @if ( $status )
                    <div class="card-body">
                        <div id="chatFrom" class="form-group">
                            <label>Сообщение</label>
                            <textarea class="form-control" id="messageBox" rows="3"></textarea>
                            <br>
                            <button id="closeTicketBtn" class="btn btn-primary float-left">Закрыть тикет</button>
                            <button id="messageSemdBtn" class="btn btn-primary float-right">Отправить</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

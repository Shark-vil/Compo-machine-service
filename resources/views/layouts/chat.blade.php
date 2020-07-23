<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            @if ( !is_null( Auth::user() ) )
                <div class="container">
                    <div class="row">
                    <div class="col-xs-12 col-sm-6 offset-sm-3 col-md-6 offset-md-3">
                        
                        <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Мониторинг</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/stores">Магазины</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/tickets">Тикеты</a>
                        </li>
                        </ul>
                        
                    </div>
                    </div>
                </div>
              @endif

            @yield('content')
        </main>
    </div>
</body>
<!-- <script src="{{ asset('js/chat_desing.js') }}"></script>-->
<!--<script src="{{ asset('js/chat_logic.js') }}"></script>-->
<script>
    $( document ).ready(function() {
        const messages = document.getElementById('chatBlock');
        function scrollToBottom() {
            messages.scrollTop = messages.scrollHeight;
        }

        function sendMessage()
        {
            $.ajax({
                type: "POST",
                url: "{{ URL::to("/messages/store") }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("#messageBox").val(),
                    ticket_id: {{ $ticket->id }},
                },
                async: true,
                success: function (data) {
                    $("#messageBox").val('')
                    scrollToBottom();
                    console.log( data );
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }

        /* прикрепить событие submit к форме */
        $("#messageSemdBtn").click(function() {
            sendMessage();
        });

        $("#closeTicketBtn").click(function() {
            let isConfim = confirm("Вы уверены что хотите закрыть тикет? После закрытия продолжить переписку бкдет невозможно.");
            if ( isConfim ) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to("/tickets/close/$ticket->id") }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    async: true,
                    success: function (data) {
                        $("#chatFrom").remove();
                        console.log( data );
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);
                    },
                });
            }
        });

        function readMessages()
        {
            $.ajax({
                type: "GET",
                url: "{{ URL::to("/messages/show/$ticket->id") }}",
                async: true,
                success: function (data) {
                    if ( data.content.ticket_status == false ) {
                        if ( $("#chatFrom").length != 0 ) {
                            $("#chatFrom").remove();
                        }
                    }
                    
                    if ( data.success == true ) {  
                        for (id in data.content.messages) {
                            var value = data.content.messages[id];
                            if ( $("#user_message_" + value.id).length == 0 ) {
                                if ( value.user_id == {{ Auth::id() }} ) {
                                    $( "#chatBlock" ).append(`<div id="user_message_${value.id}" class="container darker sender chatbox">
                                        <h5 class="right">${value.user_name}</h5>
                                        <div>${value.message}</div>
                                        <span class="time-right">${value.date_time}</span>
                                    </div>`);
                                } else {
                                    $( "#chatBlock" ).append(`<div id="user_message_${value.id}" class="container chatbox">
                                        <h5>${value.user_name}</h5>
                                        <p>${value.message}</p>
                                        <span class="time-right">${value.date_time}</span>
                                    </div>`);
                                }

                                scrollToBottom();
                            }
                        }
                    }
                    setTimeout(readMessages, 500);
                },
                error: function (data, textStatus, errorThrown) {
                    setTimeout(readMessages, 1000);
                },
            });
        }

        readMessages();
    });
</script>
</html>

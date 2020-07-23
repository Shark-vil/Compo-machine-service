$( document ).ready(function() {
    /* прикрепить событие submit к форме */
    $("#chatFrom").submit(function(event) {
        /* отключение стандартной отправки формы */
        event.preventDefault();

        /* собираем данные с элементов страницы: */
        var $form = $( this ),
            _message = $form.find( 'textarea[name="message"]' ).val(),
            url = $form.attr( 'action' );

        alert(_message);
        alert(url);

        /* отправляем данные методом POST */
        //var posting = $.post( url, { message: _message } );

        /* результат помещаем в div */
        /*
        posting.done(function( data ) {
            var content = $( data ).find( '#content' );
            $( "#result" ).empty().append( content );
        });
        */
    });
});
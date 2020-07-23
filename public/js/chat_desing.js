$( document ).ready(function() {
    const messages = document.getElementById('chatbox');

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    scrollToBottom();
});
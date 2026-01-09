document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('message-form');
    const messageList = document.getElementById('message-list');
    const teacherClassId = new URLSearchParams(window.location.search).get('id');
    let lastMessageId = 0;

    // Find the last message id on the page
    const existingMessages = messageList.querySelectorAll('.message-item');
    if (existingMessages.length > 0) {
        lastMessageId = existingMessages[existingMessages.length - 1].dataset.messageId;
    }

    // Function to append a new message to the list
    function appendMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.className = 'message-item';
        messageElement.dataset.messageId = message.message_id;

        messageElement.innerHTML = `
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">
                    <strong>${DOMPurify.sanitize(message.sender_name)}</strong> sent on ${message.message_date_formatted}
                </div>
                <div>
                    <a href="chatroom_teacher.php?id=${teacherClassId}&delete_message_id=${message.message_id}" 
                       onclick="return confirm('Delete for everyone');"
                       class="btn btn-danger btn-small" title="Delete message" style="margin-left: 10px;">
                        <i class="icon-trash"></i>
                    </a>
                </div>
            </div>
            <div class="block-content collapse in">
                <p>${DOMPurify.sanitize(message.message_content)}</p>
                ${message.media_html}
            </div>
        `;
        messageList.appendChild(messageElement);
        messageList.scrollTop = messageList.scrollHeight;
    }

    // Form submission is handled in the main PHP file
    // This prevents double submission issues

    // Function to fetch new messages
    function fetchMessages() {
        fetch(`get_messages_teacher.php?id=${teacherClassId}&last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(messages => {
                if (messages.length > 0) {
                    messages.forEach(message => {
                        const existingMessage = messageList.querySelector(`[data-message-id="${message.message_id}"]`);
                        if (!existingMessage) {
                            appendMessage(message);
                            lastMessageId = message.message_id;
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Periodically fetch new messages
    setInterval(fetchMessages, 3000);

    // Initial scroll to bottom
    messageList.scrollTop = messageList.scrollHeight;
}); 
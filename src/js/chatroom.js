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
        messageElement.className = 'message-item' + (message.is_own_message ? ' own-message' : '');
        messageElement.dataset.messageId = message.message_id;

        let mediaHtml = '';
        for (let i = 1; i <= 3; i++) {
            const media_type = message[`media_type_${i}`];
            const media_path = message[`media_path_${i}`];
            if (media_type && media_path) {
                if (media_type === 'image') {
                    mediaHtml += `<div style="margin-top:10px; margin-bottom:10px;"><img src="${media_path}" style="max-width:300px; max-height:300px;"></div>`;
                } else if (media_type === 'video') {
                    mediaHtml += `<div style="margin-top:10px; margin-bottom:10px;"><video controls style="max-width:300px; max-height:300px;"><source src="${media_path}" type="video/mp4"></video></div>`;
                } else if (media_type === 'document') {
                    mediaHtml += `<div style="margin-top:10px; margin-bottom:10px;"><p><a href="${media_path}" target="_blank" download>${media_path.split('/').pop()}</a></p></div>`;
                } else if (media_type === 'link') {
                    mediaHtml += `<div style="margin-top:10px; margin-bottom:10px;"><p><a href="${media_path}" target="_blank">${media_path}</a></p></div>`;
                }
            }
        }

        messageElement.innerHTML = `
            <div class="message-content">
                <strong>${message.sender_name}:</strong>
                ${DOMPurify.sanitize(message.message_content)}
                ${mediaHtml}
                <span class="message-date">${new Date(message.message_date).toLocaleTimeString()}</span>
            </div>
        `;
        messageList.appendChild(messageElement);
        messageList.scrollTop = messageList.scrollHeight;
    }

    // Handle form submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(messageForm);

        fetch('chatroom_student.php?id=' + teacherClassId, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                messageForm.reset();
                // Fetch the new messages immediately after posting
                fetchMessages(); 
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Function to fetch new messages
    function fetchMessages() {
        fetch(`get_messages.php?id=${teacherClassId}&last_message_id=${lastMessageId}`)
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

    // Delegate click for delete buttons
    messageList.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-danger') && e.target.classList.contains('btn-mini')) {
            e.preventDefault();
            if (!confirm('Delete for everyone?')) return;
            const messageDiv = e.target.closest('.message-item');
            const messageId = messageDiv ? messageDiv.dataset.messageId : null;
            if (!messageId) return;
            const formData = new FormData();
            formData.append('ajax_delete_message', '1');
            formData.append('message_id', messageId);
            fetch('chatroom_student.php?id=' + teacherClassId, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageDiv.remove();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error: ' + error));
        }
    });
}); 
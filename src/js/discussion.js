document.addEventListener('DOMContentLoaded', function() {
    const newPostForm = document.getElementById('new-post-form');
    const discussionPosts = document.getElementById('discussion-posts');
    const teacherClassId = new URLSearchParams(window.location.search).get('id');
    
    let lastPostId = 0;
    let lastReplyId = 0;

    // Find the latest post and reply IDs on the page
    const existingPosts = discussionPosts.querySelectorAll('.discussion-post');
    if (existingPosts.length > 0) {
        lastPostId = Math.max(...Array.from(existingPosts).map(post => parseInt(post.dataset.postId)));
    }

    const existingReplies = discussionPosts.querySelectorAll('.discussion-reply');
    if (existingReplies.length > 0) {
        lastReplyId = Math.max(...Array.from(existingReplies).map(reply => parseInt(reply.dataset.replyId)));
    }

    // Function to append a new post to the discussion
    function appendPost(post) {
        const postElement = document.createElement('div');
        postElement.className = 'block discussion-post';
        postElement.id = 'post' + post.discussion_post_id;
        postElement.dataset.postId = post.discussion_post_id;

        postElement.innerHTML = `
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">
                    <strong>${DOMPurify.sanitize(post.poster_name)}</strong> posted on ${post.post_date_formatted}
                </div>
            </div>
            <div class="block-content collapse in">
                <p>${DOMPurify.sanitize(post.post_content)}</p>
                ${post.media_html}
                <hr>
                <!-- Replies -->
                <div class="replies-container" id="replies-${post.discussion_post_id}">
                    <em>No replies yet.</em>
                </div>

                <!-- Reply Form -->
                <form class="reply-form" method="post" action="" enctype="multipart/form-data" style="margin-top: 10px;" data-post-id="${post.discussion_post_id}">
                    <input type="hidden" name="new_reply" value="1">
                    <input type="hidden" name="post_id" value="${post.discussion_post_id}">
                    <input type="hidden" name="ajax_request" value="1">
                    <textarea name="reply_content" rows="2" class="span12" placeholder="Write your reply here..." required></textarea>
                    <br>
                    <label>Attach files (jpg, jpeg, png, gif, mp4, pdf, docx, pptx):</label><br>
                    <input type="file" name="reply_media_1" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx"><br>
                    <input type="file" name="reply_media_2" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx"><br>
                    <input type="file" name="reply_media_3" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx"><br>

                    <label>Or attach links</label><br>
                    <input type="url" name="reply_link_1" class="span12" placeholder="https://example.com"><br>
                    <input type="url" name="reply_link_2" class="span12" placeholder="https://example.com"><br>
                    <input type="url" name="reply_link_3" class="span12" placeholder="https://example.com"><br>

                    <button type="submit" class="btn btn-success btn-small">Reply</button>
                </form>
            </div>
        `;

        // Insert at the top of the discussion posts
        discussionPosts.insertBefore(postElement, discussionPosts.firstChild);
        
        // Add event listener to the new reply form
        const newReplyForm = postElement.querySelector('.reply-form');
        newReplyForm.addEventListener('submit', handleReplySubmit);
        
        lastPostId = post.discussion_post_id;
    }

    // Function to append a new reply to a post
    function appendReply(reply) {
        const repliesContainer = document.getElementById('replies-' + reply.discussion_post_id);
        if (!repliesContainer) return;

        // Remove "No replies yet" message if it exists
        const noRepliesMessage = repliesContainer.querySelector('em');
        if (noRepliesMessage && noRepliesMessage.textContent === 'No replies yet.') {
            noRepliesMessage.remove();
        }

        const replyElement = document.createElement('div');
        replyElement.className = 'discussion-reply';
        replyElement.dataset.replyId = reply.discussion_reply_id;
        replyElement.style.cssText = 'border-bottom: 1px solid #ddd; margin-bottom: 5px; padding-bottom: 5px; position:relative;';

        replyElement.innerHTML = `
            <strong>${DOMPurify.sanitize(reply.replier_name)}</strong> replied on ${reply.reply_date_formatted}
            <br>
            <p>${DOMPurify.sanitize(reply.reply_content)}</p>
            ${reply.media_html}
        `;

        repliesContainer.appendChild(replyElement);
        lastReplyId = reply.discussion_reply_id;
    }

    // Handle new post form submission
    function handlePostSubmit(e) {
        e.preventDefault();

        const formData = new FormData(newPostForm);

        fetch('discussion_student.php?id=' + teacherClassId, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                newPostForm.reset();
                // Hide extra file/link inputs and show + buttons again
                const file2 = document.getElementById('post_media_2');
                const file3 = document.getElementById('post_media_3');
                const fileBtn = document.getElementById('add-file-btn');
                if (file2) file2.style.display = 'none';
                if (file3) file3.style.display = 'none';
                if (fileBtn) fileBtn.style.display = '';
                const link2 = document.getElementById('post_link_2');
                const link3 = document.getElementById('post_link_3');
                const linkBtn = document.getElementById('add-link-btn');
                if (link2) link2.style.display = 'none';
                if (link3) link3.style.display = 'none';
                if (linkBtn) linkBtn.style.display = '';
                // Manually clear file inputs (for browsers where .reset() doesn't work)
                const file1 = document.getElementById('post_media_1');
                if (file1) file1.value = '';
                if (file2) file2.value = '';
                if (file3) file3.value = '';
                // Manually clear textarea and link inputs for robustness
                const textarea = newPostForm.querySelector('textarea[name="post_content"]');
                if (textarea) textarea.value = '';
                const link1 = document.getElementById('post_link_1');
                if (link1) link1.value = '';
                if (link2) link2.value = '';
                if (link3) link3.value = '';
                // Fetch new posts immediately after posting
                fetchDiscussionData();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Handle reply form submission
    function handleReplySubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);

        fetch('discussion_student.php?id=' + teacherClassId, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                e.target.reset();
                // Fetch new replies immediately after posting
                fetchDiscussionData();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to fetch new discussion data
    function fetchDiscussionData() {
        fetch(`get_discussion_data.php?id=${teacherClassId}&last_post_id=${lastPostId}&last_reply_id=${lastReplyId}`)
            .then(response => response.json())
            .then(data => {
                // Add new posts
                if (data.new_posts && data.new_posts.length > 0) {
                    data.new_posts.forEach(post => {
                        const existingPost = document.querySelector(`[data-post-id="${post.discussion_post_id}"]`);
                        if (!existingPost) {
                            appendPost(post);
                        }
                    });
                }

                // Add new replies
                if (data.new_replies && data.new_replies.length > 0) {
                    data.new_replies.forEach(reply => {
                        const existingReply = document.querySelector(`[data-reply-id="${reply.discussion_reply_id}"]`);
                        if (!existingReply) {
                            appendReply(reply);
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching discussion data:', error));
    }

    // Add event listeners
    newPostForm.addEventListener('submit', handlePostSubmit);

    // Add event listeners to existing reply forms
    const existingReplyForms = document.querySelectorAll('.reply-form');
    existingReplyForms.forEach(form => {
        form.addEventListener('submit', handleReplySubmit);
    });

    // Periodically fetch new discussion data
    setInterval(fetchDiscussionData, 5000); // Check every 5 seconds
}); 
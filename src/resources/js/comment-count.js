document.addEventListener('DOMContentLoaded', function () {
    const commentForms = document.querySelectorAll('form');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    commentForms.forEach(commentForm => {
        const itemId = commentForm.getAttribute('data-item-id');
        if (!itemId) {
            console.error('Item IDが取得できませんでした');
            return;
        }

        const commentInput = commentForm.querySelector('.comment-input');
        const commentsList = document.querySelector('#comments-section .comments-list');
        let errorMessageElement = commentForm.querySelector('.error-message');
        let successMessageElement = commentForm.querySelector('.success-message');

        if (!errorMessageElement) {
            errorMessageElement = document.createElement('p');
            errorMessageElement.classList.add('error-message');
            commentForm.querySelector('button[type="submit"]').insertAdjacentElement('beforebegin', errorMessageElement);
        }
        if (!successMessageElement) {
            successMessageElement = document.createElement('p');
            successMessageElement.classList.add('success-message');
            commentForm.querySelector('button[type="submit"]').insertAdjacentElement('beforebegin', successMessageElement);
        }

        commentForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const commentValue = commentInput.value.trim();
            if (!commentValue) {
                errorMessageElement.textContent = 'コメントを入力してください';
                errorMessageElement.classList.add('show');
                return;
            }

            fetch(`/items/${itemId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ comment: commentValue })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                const successMessageElement = document.querySelector('.success-message');
                if (successMessageElement) {
                    successMessageElement.textContent = 'コメントを送信しました';
                    successMessageElement.classList.add('show');
                }

                    const commentCountElement = document.getElementById(`comment-count-${itemId}`);
                    if (commentCountElement) {
                        commentCountElement.textContent = data.comment_count;
                    }

                    addCommentToList(data.comment, data.profileImageUrl || null, data.userName || '名前');

                    commentInput.value = '';
                    errorMessageElement.textContent = '';
                } else {
                    errorMessageElement.textContent = data.message || 'コメント送信に失敗しました';
                    errorMessageElement.classList.add('show');
                }
            })
            .catch(error => {
                errorMessageElement.textContent = 'コメント送信に失敗しました';
                errorMessageElement.classList.add('show');
            });
        });

        function addCommentToList(comment, profileImageUrl, userName) {
            const commentItem = document.createElement('div');
            commentItem.classList.add('comment-item');
            const authorDiv = document.createElement('div');
            authorDiv.classList.add('comment-author', 'flex', 'align-items-center');

            if (profileImageUrl) {
                const img = document.createElement('img');
                img.classList.add('comment-author__image');
                img.src = profileImageUrl;
                img.alt = `${userName}'s profile image`;
                authorDiv.appendChild(img);
            } else {
                const iconDiv = document.createElement('div');
                iconDiv.classList.add('comment-author__icon', 'flex', 'align-items-center', 'center');
                const icon = document.createElement('i');
                icon.classList.add('fa', 'fa-camera');
                iconDiv.appendChild(icon);
                authorDiv.appendChild(iconDiv);
            }

            const strong = document.createElement('strong');
            strong.textContent = userName;
            authorDiv.appendChild(strong);

            const commentText = document.createElement('p');
            commentText.classList.add('comment-text');
            commentText.textContent = comment;

            commentItem.appendChild(authorDiv);
            commentItem.appendChild(commentText);

            commentsList.append(commentItem);

            commentsList.scrollTop = commentsList.scrollHeight;
        }
    });
});

function isAuthenticated() {
    return fetch('/check-auth')
        .then(response => response.json())
        .then(data => data.authenticated);
}

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.fa-star');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ログインしているかをチェック
    isAuthenticated().then(authenticated => {
        if (authenticated) {
            stars.forEach(star => {
                const itemId = star.getAttribute('data-item-id');

                // ページロード時に「いいね」の状態とカウントを取得
                fetch(`/items/${itemId}/like-status`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // アイテムの「いいね」状態に応じて星アイコンを変更
                    if (data.is_liked) {
                        star.classList.add('fa-solid');
                        star.classList.remove('fa-regular');
                    } else {
                        star.classList.add('fa-regular');
                        star.classList.remove('fa-solid');
                    }

                    // いいね数を更新
                    const likeCount = document.getElementById('like-count-' + itemId);
                    if (likeCount) {
                        likeCount.textContent = data.likes_count !== undefined ? data.likes_count : 0; // 0でも表示
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        } else {
            console.log('ログインしていないため、いいねの状態を取得できません');
        }
    });

    // いいねをトグルするイベントを追加
    stars.forEach(star => {
        star.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');

            fetch(`/items/${itemId}/toggle-like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(response => response.json())
            .then(data => {
                // アイコンをトグル（状態に応じて）
                if (data.is_liked) {
                    this.classList.add('fa-solid');
                    this.classList.remove('fa-regular');
                } else {
                    this.classList.add('fa-regular');
                    this.classList.remove('fa-solid');
                }

                // いいね数を更新
                const likeCount = document.getElementById('like-count-' + itemId);
                if (likeCount) {
                    likeCount.textContent = data.likes_count !== undefined ? data.likes_count : 0;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

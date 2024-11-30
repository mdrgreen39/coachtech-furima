function isAuthenticated() {
    return fetch('/check-auth')
        .then(response => response.json())
        .then(data => data.authenticated);
}

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.fa-star');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    isAuthenticated().then(authenticated => {
        if (authenticated) {
            stars.forEach(star => {
                const itemId = star.getAttribute('data-item-id');

                fetch(`/items/${itemId}/like-status`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.is_liked) {
                        star.classList.add('fa-solid');
                        star.classList.remove('fa-regular');
                    } else {
                        star.classList.add('fa-regular');
                        star.classList.remove('fa-solid');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        } else {
            console.log('ログインしていないため、いいねの状態を取得できません');
        }
    });
});


function isAuthenticated() {
    return fetch('/check-auth')
        .then(response => response.json())
        .then(data => data.authenticated);
}

document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.rating-star i');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');

            isAuthenticated().then(authenticated => {
                if (authenticated) {
                    toggleLike(itemId, this);
                } else {
                    window.location.href = '/login';
                }
            });
        });
    });

    function toggleLike(itemId, starElement) {
        fetch(`/items/${itemId}/toggle-like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                item_id: itemId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'liked') {
                starElement.classList.add('liked');
            } else {
                starElement.classList.remove('liked');
            }
            const countElement = document.getElementById('like-count-' + itemId);
            countElement.textContent = data.likes_count;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

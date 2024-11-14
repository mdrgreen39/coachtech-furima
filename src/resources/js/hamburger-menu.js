document.addEventListener('DOMContentLoaded', function() {
    const target = document.getElementById("hamburger");

    if (target) {
        target.addEventListener('click', () => {
            target.classList.toggle('active');
            const menu = document.getElementById("menu");
            if (menu) {
                menu.classList.toggle('active');
            }
        });
    }
});

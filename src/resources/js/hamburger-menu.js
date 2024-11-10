const target = document.getElementById("hamburger");
target.addEventListener('click', () => {
    target.classList.toggle('active');
    const menu = document.getElementById("menu");
    menu.classList.toggle('active');
});
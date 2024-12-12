document.addEventListener("DOMContentLoaded", function() {
    var flashMessage = document.querySelector('.flash-message'); // クラスで要素取得
    if (flashMessage) {
        setTimeout(function() {
            flashMessage.style.display = 'none'; // 3秒後に非表示
        }, 3000);
    }
});

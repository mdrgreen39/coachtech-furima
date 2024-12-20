document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('item-sell-image');
    const preview = document.getElementById('item-image-preview');

    // もしimageInputやpreviewが存在する場合のみ処理を行う
    if (imageInput && preview) {
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // プレビューを表示
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

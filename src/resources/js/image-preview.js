// 共通のプレビューリセット関数
function resetPreview(page) {
    var imagePreview = document.getElementById(page + '-image-preview');
    var cameraIcon = document.querySelector('.' + page + '-profile__image--icon');

    // imagePreviewが存在する場合のみ処理
    if (imagePreview) {
        imagePreview.style.display = 'none'; // プレビュー画像を非表示
        imagePreview.src = ''; // プレビュー画像をリセット
    }

    // cameraIconが存在する場合のみ処理
    if (cameraIcon) {
        cameraIcon.style.display = 'flex'; // カメラアイコンを表示
    }
}

// マイページ用の処理
if (document.getElementById('mypage-image-preview')) {
    var imagePreview = document.getElementById('mypage-image-preview');
    var cameraIcon = document.querySelector('.mypage-profile__image--icon');

    // 画像が選択されている場合はプレビューを表示する処理
    if (imagePreview) {
        imagePreview.style.display = 'block';  // 画像を表示
        if (cameraIcon) {
            cameraIcon.style.display = 'none';    // カメラアイコンを非表示にする
        }
    }
}

// 画像がアップロードされない場合、画像をリセットする
function resetPreviewForMypage() {
    resetPreview('mypage');  // マイページ用のリセット関数
}

// プロフィール編集画面用の処理
if (document.getElementById('image-preview')) {
    var imageInput = document.getElementById('image');
    imageInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('image-preview');
                var cameraIcon = document.querySelector('.profile-upload__image--icon');

                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                cameraIcon.style.display = 'none';
            };
            reader.onerror = function() {
                console.error("画像の読み込みに失敗しました");
                resetPreview('profile-upload'); // プロフィール編集画面用のリセット
            };
            reader.readAsDataURL(file);
        } else {
            resetPreview('profile-upload');
        }
    });
}

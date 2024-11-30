document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('search-form');
    const resultsDiv = document.getElementById('search-results');
    const productList = document.getElementById('items-list');
    const tabsWrapper = document.querySelector('.item-tabs-wrapper'); // タブ
    const profileImageDiv = document.getElementById('profile-upload-image'); // プロフィール画像
    const detailWrapper = document.querySelector('.item-detail'); // 商品詳細

    if (!searchForm || !resultsDiv) {
        console.warn('検索フォームまたは結果表示要素が見つかりません。スクリプトを終了します。');
        return;
    }

    // タブやページに応じたエンドポイントを動的に設定
    const searchEndpoint = window.location.pathname.includes('mypage')
        ? '/mypage/recommend-items.json'
        : window.location.pathname.includes('items') && window.location.pathname.includes('show')
            ? `/items/${itemId}/detail.json`  // 商品詳細ページ用のエンドポイント
            : '/recommend-items.json';

    // 商品詳細の処理（検索結果がない場合もあるので、resetSearchと合わせて処理します）
    const resetSearch = () => {
        resultsDiv.innerHTML = '';
        resultsDiv.style.display = 'none';

        if (productList) productList.style.display = 'grid';
        if (tabsWrapper) tabsWrapper.style.display = 'flex';
        if (profileImageDiv) profileImageDiv.style.display = 'flex';
        if (detailWrapper) detailWrapper.style.display = 'flex';

        // 検索後は元のアイテムを表示
        fetch(searchEndpoint)
            .then(response => response.json())
            .then(data => {
                if (productList) {
                    productList.innerHTML = '';
                    const parentItemDiv = document.createElement('div');
                    parentItemDiv.classList.add('item');

                    data.forEach(item => {
                        const imageUrl = item.image ? `/storage/${item.image}` : '/path/to/default-image.jpg';
                        const itemCard = document.createElement('div');
                        itemCard.classList.add('item-card');
                        itemCard.innerHTML = `
                            <a href="/items/${item.id}">
                                <img src="${imageUrl}" alt="${item.name}" class="item-card__image">
                            </a>
                        `;
                        parentItemDiv.appendChild(itemCard);
                    });

                    productList.appendChild(parentItemDiv);
                }
            })
            .catch(error => {
                console.error('リストの取得中にエラーが発生しました:', error);
            });
    };

    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const keyword = document.querySelector('input[name="keyword"]').value.trim();
        if (!keyword) return;

        // 要素が存在する場合のみ非表示
        if (productList) productList.style.display = 'none';
        if (tabsWrapper) tabsWrapper.style.display = 'none';
        if (profileImageDiv) profileImageDiv.style.display = 'none';
        if (detailWrapper) detailWrapper.style.display = 'none';

        fetch(`/search.json?keyword=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(data => {
                resultsDiv.innerHTML = '';

                if (data.length > 0) {
                    const parentItemDiv = document.createElement('div');
                    parentItemDiv.classList.add('item');

                    data.forEach(item => {
                        const itemCard = document.createElement('div');
                        itemCard.classList.add('item-card');
                        itemCard.innerHTML = `
                            <a href="/items/${item.id}">
                                <img src="${item.image_url}" alt="${item.name}" class="item-card__image">
                            </a>
                        `;
                        parentItemDiv.appendChild(itemCard);
                    });

                    resultsDiv.appendChild(parentItemDiv);
                } else {
                    resultsDiv.innerHTML = '検索結果がありません。';
                }

                resultsDiv.style.display = 'block';
            })
            .catch(error => {
                console.error('検索結果の取得中にエラーが発生しました:', error);
            });
    });

    // 検索ボックスが空の場合にリセット
    const keywordInput = document.querySelector('input[name="keyword"]');
    if (keywordInput) {
        keywordInput.addEventListener('input', function () {
            if (!keywordInput.value.trim()) {
                resetSearch();
            }
        });
    }
});

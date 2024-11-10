document.getElementById('search-form').addEventListener('submit', function (e) {
    e.preventDefault();

    var keyword = document.querySelector('input[name="keyword"]').value;

    fetch('/search?keyword=' + encodeURIComponent(keyword))
        .then(response => response.json())
        .then(data => {
            const resultsDiv = document.getElementById('search-results');
            const productList = document.getElementById('item-list');

            resultsDiv.innerHTML = '';

            if (data.length > 0) {
                data.forEach(imageUrl => {
                    resultsDiv.innerHTML += `
                        <div class="item">
                            <img src="${imageUrl}" alt="商品画像">
                        </div>
                    `;
                });

                productList.style.display = 'none';
                resultsDiv.style.display = 'block';
            } else {
                resultsDiv.innerHTML = '検索結果がありません。';
                resultsDiv.style.display = 'block';
                productList.style.display = 'block';
            }
        });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('search-form');
    const resultsDiv = document.getElementById('search-results');
    const productList = document.getElementById('items-list');

    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var keyword = document.querySelector('input[name="keyword"]').value;

            if (keyword.trim() === '') {
                return;
            }

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

                        productList.style.display = 'none';
                        resultsDiv.style.display = 'block';
                    } else {
                        resultsDiv.innerHTML = '検索結果がありません。';
                        resultsDiv.style.display = 'block';

                        productList.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    }

    const resetSearch = () => {
        resultsDiv.innerHTML = '';
        resultsDiv.style.display = 'none';
        productList.style.display = 'grid';

        fetch('/all-items.json')
            .then(response => response.json())
            .then(data => {
                productList.innerHTML = '';
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

                productList.appendChild(parentItemDiv);
            })
            .catch(error => {
                console.error('Error fetching all items:', error);
            });
    };

    const keywordInput = document.querySelector('input[name="keyword"]');
    if (keywordInput) {
        keywordInput.addEventListener('input', function () {
            if (keywordInput.value === '') {
                resetSearch();
            }
        });
    }
});

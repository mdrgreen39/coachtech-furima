document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.item-link');
    const itemsList = document.getElementById('items-list');
    let activeTab = 'recommend';

    if (!tabs.length || !itemsList) return;

    document.querySelector(`[data-tab="recommend"]`).classList.add('active');

    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();

            const selectedTab = tab.dataset.tab;
            const basePath = window.location.pathname;

            if (activeTab === selectedTab) {
                return;  // 同じタブが選択された場合は何もしない
            }

            // 新たに選択されたタブに切り替える
            activeTab = selectedTab;
            tabs.forEach(t => t.classList.remove('active'));  // 全てのタブから 'active' クラスを削除
            tab.classList.add('active');  // クリックされたタブに 'active' クラスを追加

            // タブの内容を取得して表示する
            fetch(`${basePath}?tab=${selectedTab}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    itemsList.innerHTML = data.items_html;  // 商品リストを更新
                })
                .catch(error => console.error('Error:', error));
        });
    });
});

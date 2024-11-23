document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.item-link'); // タブのリンクを取得
    const itemsList = document.getElementById('items-list'); // アイテムリストを取得
    let activeTab = null; // 現在選択されているタブを追跡

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault(); // ページ遷移を防ぐ

            const selectedTab = tab.dataset.tab; // クリックされたタブを取得

            if (activeTab === selectedTab) {
                // 同じタブが押された場合、タブを解除して全商品を表示
                activeTab = null; // アクティブなタブをリセット
                tabs.forEach(t => t.classList.remove('active')); // すべてのタブからactiveクラスを外す

                // 全商品を取得するリクエストを送信
                fetch(`${window.location.pathname}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' } // AJAXリクエストであることを明示
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json(); // JSONとしてパース
                })
                .then(data => {
                    itemsList.innerHTML = data.items_html; // HTMLを全商品に更新
                })
                .catch(error => console.error('Error:', error));

            } else {
                // 新しいタブが押された場合、タブを選択
                activeTab = selectedTab; // アクティブなタブを更新
                tabs.forEach(t => t.classList.remove('active')); // すべてのタブからactiveクラスを外す
                tab.classList.add('active'); // クリックされたタブにactiveクラスを追加

                // タブに対応する商品のリクエストを送信
                fetch(`${window.location.pathname}?tab=${selectedTab}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' } // AJAXリクエストであることを明示
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json(); // JSONとしてパース
                })
                .then(data => {
                    itemsList.innerHTML = data.items_html; // HTMLを更新
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

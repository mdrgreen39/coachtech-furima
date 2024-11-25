document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.item-link');
    const itemsList = document.getElementById('items-list');
    let activeTab = null;

    tabs.forEach(tab => {
        tab.addEventListener('click', function(event) {
            event.preventDefault();

            const selectedTab = tab.dataset.tab;

            if (activeTab === selectedTab) {
                activeTab = null;
                tabs.forEach(t => t.classList.remove('active'));

                fetch(`${window.location.pathname}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    itemsList.innerHTML = data.items_html;
                })
                .catch(error => console.error('Error:', error));

            } else {
                activeTab = selectedTab;
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                fetch(`${window.location.pathname}?tab=${selectedTab}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    itemsList.innerHTML = data.items_html;
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

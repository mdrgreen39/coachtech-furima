document.addEventListener('DOMContentLoaded', function () {
    // 支払い方法の選択に基づいて表示を更新
    document.querySelectorAll('.payment-method').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            document.getElementById('selected-payment-summary').textContent = selectedMethod;
        });
    });
});

<div>
    @forelse($products as $product)
    <div class="item-card">
        <img class="item-card__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
    </div>
    @empty
    <p class="result-massage">商品が見つかりません</p>
    @endforelse
</div>
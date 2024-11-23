<div class="item flex">
    @forelse($items as $item)
    <div class="item-card">
        <img class="item-card__image" src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}">
    </div>
    @empty
    <p class="result-massage">商品が見つかりません</p>
    @endforelse
</div>
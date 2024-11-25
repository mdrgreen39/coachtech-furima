<div class="item-wrapper">
    @if($items->isEmpty())
    <p class="result-message">商品が見つかりません</p>
    @else
    <div class="item">
        @foreach($items as $item)
        <div class="item-card">
            <a href="{{ route('item.detail', $item) }}">
                <img class="item-card__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-sell.css') }}
">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <div class="item-sell-container">
            <h2 class="item-sell__heading">商品の出品</h2>
            <div class="item-sell">
                <form class="item-sell__form" action="{{ route('items.store') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="item-sell__image-container">
                        <p class="item-sell__image-title">商品の画像</p>
                        <div class="item-sell__image-box flex align-items-center center">
                            <img id="item-image-preview" class="item-sell__image-preview" src="" alt="商品の画像プレビュー" style="display: none;">
                            <label for="item-sell-image" class="item-sell__image-label">
                                <input type="file" id="item-sell-image" name="image" accept="image/*" class="item-sell__image-input">
                                画像を選択する
                            </label>
                        </div>
                        @if ($errors->has('image'))
                        <p class="error-message">{{ $errors->first('image') }}</p>
                        @endif
                    </div>

                    <div class="item-sell__section">
                        <h3 class="item-sell__section-title">商品の詳細</h3>
                        <div class="item-sell__field-group">
                            <div class="item-sell__field">
                                <label for="category" class="item-sell__label">カテゴリー</label>
                                <!-- チェックボックスでカテゴリー選択 -->
                                @foreach ($categories as $category)
                                <div class="category-option">
                                    <label for="category_{{ $category->id }}">
                                        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                                            @if (in_array($category->id, old('categories', []))) checked @endif>
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @if ($errors->has('categories'))
                            <p class="error-message">{{ $errors->first('categories') }}</p>
                            @endif
                            <div class="item-sell__field">
                                <label for="condition" class="item-sell__label flex align-items-center">商品の状態</label>
                                <select name="condition" id="condition" class="item-sell__input">
                                    @foreach ($conditions as $condition)
                                    <option value="{{ $condition->id }}" @if (old('condition')==$condition->id) selected @endif>
                                        {{ $condition->condition }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('condition'))
                            <p class="error-message">{{ $errors->first('condition') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="item-sell__section">
                        <h3 class="item-sell__section-title">商品名と説明</h3>
                        <div class="item-sell__field-group">
                            <div class="item-sell__field">
                                <label for="category" class="item-sell__label">商品名</label>
                                <input type="text" name="name" id="name" class="item-sell__input" value="{{ old('name') }}">
                                </input>
                                @if ($errors->has('name'))
                                <p class="error-message">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div class="item-sell__field">
                                <label for="description" class="item-sell__label  flex align-items-center">商品の説明</label>
                                <textarea name="description" id="description" rows="5" class="description-input" required>{{ old('description') }}</textarea>
                            </div>
                            @if ($errors->has('description'))
                            <p class="error-message">{{ $errors->first('description') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="item-sell__section">
                        <h3 class="item-sell__section-title">販売価格</h3>
                        <div class="item-sell__field-group">
                            <div class="item-sell__field">
                                <label for="price" class="item-sell__label">販売価格</label>
                                <div class="price-input-container flex align-items-center">
                                    <span class="currency-symbol">¥</span>
                                    <input type="text" name="price" id="price" class="item-sell__input" value="{{ old('price') }}">
                                </div>
                            </div>
                            @if ($errors->has('price'))
                            <p class="error-message">{{ $errors->first('price') }}</p>
                            @endif
                        </div>
                    </div>

                    <button class="item-sell__btn btn" type="submit">出品する</button>
                </form>
            </div>
        </div>
    </div>
    <div id="search-results" style="display:none;">

    </div>


</div>
@endsection
@extends('layouts.app')

@section('css')


<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">

<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <form class="purchase-form" action="{{ route('items.storePurchase', $item->id) }}" method="post">
            @csrf
            <div class="purchase-container flex">
                <div class="purchase-content flex">
                    <!-- 商品情報 -->
                    <div class="purchase-item flex">
                        <div class="purchase-item__image-container">
                            <img class="purchase-item__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
                        </div>
                        <div class="purchase-item__info flex center">
                            <h1 class="purchase-item__name">{{ $item->name }}</h1>
                            <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
                        </div>
                    </div>

                    <!-- 支払い方法 -->
                    <div class=" purchase-payment flex">
                        <div class="purchase-payment__header">
                            <span>支払い方法</span>
                            <div class="purchase-payment__methods">
                                <label><input type="radio" name="payment_method" value="コンビニ" class="payment-method"> コンビニ</label>
                                <label><input type="radio" name="payment_method" value="銀行振込" class="payment-method"> 銀行振込</label>
                                <label><input type="radio" name="payment_method" value="クレジットカード" class="payment-method"> クレジットカード</label>
                            </div>
                            @if ($errors->has('payment_method'))
                            <div class="error-message">{{ $errors->first('payment_method') }}</div>
                            @endif
                        </div>

                        <!-- 配送先 -->
                        <div class="purchase-shipping">
                            <div class="purchase-shipping__header flex align-items-center">
                                <span>配送先</span>
                                <a href="{{ route('address.edit', $item->id) }}" class="purchase-shipping__change-link">変更する</a>
                            </div>
                            <div class="purchase-shipping__details">
                                <p><span>郵便番号:</span> {{ optional($user->profile)->postcode ?? '未登録' }}</p>
                                <p><span>住所:</span> {{ optional($user->profile)->address ?? '未登録' }}</p>
                                <p><span>建物:</span> {{ optional($user->profile)->building ?? '未登録' }}</p>
                            </div>
                            @if ($errors->has('address'))
                            <div class="error-message">{{ $errors->first('address') }}</div>
                            @endif
                            @if ($errors->has('postcode'))
                            <div class="error-message">{{ $errors->first('postcode') }}</div>
                            @endif
                            @if ($errors->has('name'))
                            <div class="error-message">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- 購入情報 -->
                <div class="purchase-summary flex">
                    <div class="purchase-summary__details">
                        <ul>
                            <li>
                                <span>商品代金</span>
                                <span>¥{{ number_format($item->price) }}</span>
                            </li>
                            <li>
                                <span>支払い金額</span>
                                <span>¥{{ number_format($item->price) }}</span>
                            </li>
                            <li>
                                <span>支払い方法</span>
                                <span id="selected-payment-summary">選択されていません</span>
                            </li>
                        </ul>
                    </div>
                    <button class="purchase-summary__buy-button btn">購入する</button>
                </div>
            </div>
        </form>


    </div>
    <div id="search-results" style="display:none;">

    </div>

</div>
@endsection
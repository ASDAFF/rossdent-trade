<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<a href="/personal/cart/" class="menu__cart">
    <div class="cart-item">
        <div class="cart-item__cart">
            <div class="cart-item__circle"><?=$arResult['NUM_PRODUCTS']?></div>
        </div>
        <div class="cart-item__text-box">
            <div class="cart-item__white-text">Ваша корзина</div>
            <div class="cart-item__green-text"><?=$arResult['TOTAL_PRICE']?></div>
        </div>
    </div>
</a>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
function anouncetext($str, $word_limit)
{
preg_match("/.{".$word_limit."}[^.!;?]*[.!;?]/si", $str.". ", $matches);
$str=$matches[0];
echo $str;
}
?>

<section class="news">
    <div class="box">
        <div class="news__title">
                <span class="news__title-text">
                    Новости и публикации
                </span>
            <div class="news-slider__arrows">
                <div class="news-slider__prev">
                    <img class="news-slider__arrow-img" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png">
                </div>
                <div class="news-slider__next">
                    <img class="news-slider__arrow-img" src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/img/arrow.png">
                </div>
            </div>
            <div class="news__all">
                <a href="/news/" class="btn-green-border">Все публикации</a>
            </div>
        </div>
    </div>
    <div class="swiper-container news-slider">
        <div class="swiper-wrapper">
            <?foreach($arResult['ITEMS'] as $arItem):?>
            <a class="swiper-slide news-slider__slide" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <div class="news-slider__img-wrapper">
                  <div class="news-slider__img" style="background-image:url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')">
                  </div>
                  <span class="news-slider__filter"></span>
                  <?switch($arItem['PROPERTIES']['NEWS_TYPE']['VALUE_ENUM_ID']) {
                      case 1:
                          echo "<div class='action'>Акция</div>";
                          break;
                      case 2:
                          echo "<div class='discount'>Скидка</div>";
                          break;
                  }?>
                </div>
                <div class="news-slider__text-box">
                    <div class="news-slider__title">
                        <?$obParser = new CTextParser;?>
                        <?=$obParser->html_cut($arItem['NAME'], 38)?>
                    </div>
                    <div class="news-slider__text">
                        <?=TruncateText($arItem['PREVIEW_TEXT'], 80)?>
                    </div>
                </div>
            </a>
            <?endforeach?>
        </div>

    </div>
</section>

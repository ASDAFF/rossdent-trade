// For debug
var dbg;

// Default Settings

var DEFAULT_COPYRIGHT_BOTTOM = -95,
    DEFAULT_CLUB_MARGIN_TOP = 184;


// function return GET param
$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    }
    else {
        return results[1] || '';
    }
}


// Banner slider in index page
var indsw = new Swiper('.index-slider', {
    speed: 500,
    autoplay: 5000,
    autoplayDisableOnInteraction: true,
    loop: true,
    pagination: '.index-slider__pagination',
    nextButton: '.index-slider__next',
    prevButton: '.index-slider__prev',
    paginationClickable: true
});

// Product imgs slider
new Swiper('.swiper-product-img-inner', {
    pagination: '.swiper-pagination',
    nextButton: '.index-slider__next',
    prevButton: '.index-slider__prev',
    spaceBetween: 30,
    paginationClickable: true
});

// Product recomendation
new Swiper('.swiper-product-recomend', {
    nextButton: '.swiper-product-recomend__next',
    prevButton: '.swiper-product-recomend__prev',
    spaceBetween: 40,
    slidesPerView: 3,
    loop: true,
    speed: 500,
    autoplay: 5000,
    autoplayDisableOnInteraction: true,
    breakpoints: {
        600: {
            slidesPerView: 1
        },
        900: {
            slidesPerView: 2
        }
    }
});

// autostop banner slider in index page on hover
$(".index-slider").hover(function () {
    indsw.stopAutoplay();
}, function () {
    indsw.startAutoplay();
})

// News slider in index page
new Swiper('.news-slider', {
    nextButton: '.news-slider__next',
    prevButton: '.news-slider__prev',
    slidesPerView: 4,
    spaceBetween: 1,
    breakpoints: {
        500: {
            slidesPerView: 1
        },
        840: {
            slidesPerView: 2
        },
        1400: {
            slidesPerView: 3
        }
    }
});

// Slider orders in personal page
new Swiper('.orders-slider', {
    nextButton: '.orders-slider__next',
    prevButton: '.orders-slider__prev',
    spaceBetween: 20,
    slidesPerColumn: 3,
    breakpoints: {
        1400: {
            slidesPerColumn: 1
        }
    }
});

// slide menu
(function () {
    var h = document.querySelector('.hamburger'),
        m = document.querySelector('.menu'),
        mb = document.querySelector('.menu__back'),
        hammer = new Hammer(m);

    hammer.on('swipeleft', function () {
        m.classList.toggle('menu--open');
        $(mb).css('height', '0');
    });

    h.addEventListener('click', function (e) {
        e.preventDefault();
        m.classList.toggle('menu--open');
        $(mb).css('height', '100%');
    });
    $(m).mouseleave(function () {
        m.classList.remove('menu--open');
        $(mb).css('height', '0');
    });
    mb.addEventListener('click', function (e) {
        m.classList.toggle('menu--open');
        $(mb).css('height', '0');
    });
})();

// Обработчики нажатий для пунктов меню
(function () {
    // Находим все уровни меню
    var layer1 = document.querySelectorAll('.catalog-menu__layer-1');
    var layers = document.querySelectorAll('.catalog-menu__layer');
    var layersContainer = $('.catalog-menu');
    var layersAct = [];

    // Обработчики нажатий для пунктов меню второго, трутьего и последующих уровней
    Array.prototype.forEach.call(layers, function (value, key) {
        value.addEventListener('click', function (e) {
            e.preventDefault();

            var href = e.target.getAttribute('href');

            // Если нажат основной раздел, то скрываем активные разделы и убираем активность с пункта меню
            if (this.classList.contains('catalog-menu__layer-1')) {
                for (var i = 0; i < layersAct.length; ++i) {
                    $(layersAct[i]).removeClass('catalog-menu__layer--act');
                    $(layersAct[i]).removeClass('catalog-menu__layer--move');
                }
                $(this).find('.catalog-menu__item--selected').removeClass('catalog-menu__item--selected');
            }


            // Устанавливаем активность на элемент
            $(e.target).parent().find('.catalog-menu__item').removeClass('catalog-menu__item--selected');
            if ($(e.target).hasClass('catalog-menu__item')) {
                $(e.target).addClass('catalog-menu__item--selected');
            }

            // Ищем подраздел с такой же ссылкой в атрибуте data-link
            var layer = document.querySelectorAll('.catalog-menu__layer[data-link$="' + href + '"]');

            // Если такой раздел нашелся, показываем
            if (layer.length > 0) {

                // Скрываем те что выше
                find = $(e.target.closest('.catalog-menu__layer'));
                if ((n = $.inArray(find.index(), layersAct)) >= 0) {
                    for (i = layersAct.length; i > n + 1; i--) {
                        forDelLayer = layersAct.pop();
                        forDelLayer = $('.catalog-menu .catalog-menu__layer:nth-child(' + (forDelLayer + 1) + ')');

                        forDelLayer.removeClass('catalog-menu__layer--move').removeClass('catalog-menu__layer--act');
                    }
                }


                // Устанавливаем уровень вложенности
                $(layer).addClass('catalog-menu__layer-' + (layersAct.length + 2));


                // Все элементы выше делаем невидимыми
                for (i = 1; i < 20; i++) {
                    $('.catalog-menu__layer-' + (layersAct.length + 2 + i)).removeClass('catalog-menu__layer--act').removeClass('catalog-menu__layer--move');
                }


                layer[0].classList.add('catalog-menu__layer--act');
                setTimeout(function () {
                    layer[0].classList.add('catalog-menu__layer--move');
                }, 20);

                // Запоминаем найденый
                layersAct.push($(layer[0]).index());

            } else {
                if (e.target.classList.contains('catalog-menu__item')) {
                    location.href = href + '#catalog-view';
                } else if (e.target.classList.contains('btn-green-border')) {
                    window.open(href, '_blank');
                    return false;
                }
            }
        });
    });

    // Обработчики нажатий на кнопки "назад"
    var backButton = document.querySelectorAll('.catalog-menu__back');
    Array.prototype.forEach.call(backButton, function (value, key) {
        value.addEventListener('click', function (e) {
            e.preventDefault();

            // Ищем родителя (открытый раздел меню)
            var parent = $(this).closest('.catalog-menu__layer');

            // Если нашли, скиываем вышестоящие
            find = parent;
            if ((n = $.inArray(find.index(), layersAct)) >= 0) {
                for (i = layersAct.length; i > n + 1; i--) {
                    forDelLayer = layersAct.pop();
                    forDelLayer = $('.catalog-menu .catalog-menu__layer:nth-child(' + (forDelLayer + 1) + ')');

                    forDelLayer.removeClass('catalog-menu__layer--move').removeClass('catalog-menu__layer--act');
                }
            }
            // и убираем активность у слоя и у пунктов меню
            if (parent.length > 0) {
                parent.removeClass('catalog-menu__layer--move');
                parent.one('webkitTransitionEnd transitionend msTransitionEnd oTransitionEnd', function (e) {
                    parent.removeClass('catalog-menu__layer--act');
                });

                $(parent).find('.catalog-menu__item--selected').removeClass('catalog-menu__item--selected');
            }


            prev = layersAct.pop();

        });
    });


    // Выделение открытого пункта меню
    href = location.pathname;
    var selectLayers = Array(),
        selectLayer;

    // Если человек с мобильника, и перешел через спец. ссылку, то отображаем первый уровень меню.
    if ($.urlParam('first-menu-mobile') == 'y' && $(window).width() < 600) {
        return;
    }

    // Находим текущий пункт меню
    arrItem = $(".catalog-menu__item[href='" + href + "']");

    // Открываем меню на которое указывает ссылка, если такое меню есть
    if (arrItem.length > 0) {
        tmpI = $(".catalog-menu__layer[data-link='" + arrItem.attr("href") + "']");
        if (tmpI.length > 0) {
            tmpI.addClass('catalog-menu__layer--act')
                .addClass('catalog-menu__layer--move');
        }
        selectLayers.push(tmpI);
    }

    //isFirst = true;
    while (arrItem.length > 0) {
        //if (!isFirst) {
        arrItem.addClass('catalog-menu__item--selected');
        //} else {
        //  isFirst = false;
        //}
        tmpLayer = arrItem.closest('.catalog-menu__layer');
        if (tmpLayer.length > 0) {
            selectLayers.push(tmpLayer);
        } else {
            break;
        }
        arrItem = $(".catalog-menu__item[href='" + tmpLayer.data('link') + "']");
    }

    // Реверсируем полученый массив и выделяем
    selectLayers.reverse();
    for (i = 0; i < selectLayers.length; ++i) {
        if (!$(selectLayers[i]).hasClass('catalog-menu__layer-1')) {
            $(selectLayers[i]).addClass('catalog-menu__layer--act')
                .addClass('catalog-menu__layer--move');
        }
        layersAct.push($(selectLayers[i]).index())
    }

    // console.log(selectLayers);


})();

// select
(function () {
    var select = document.querySelectorAll('.select');

    Array.prototype.forEach.call(select, function (value) {
        var input = value.querySelector('.select__input'),
            items = value.querySelector('.select__items'),
            item = items.querySelectorAll('.select__item');

        Array.prototype.forEach.call(item, function (value) {
            value.addEventListener('click', function (e) {
                e.preventDefault();
                var value = this.getAttribute('data-value');

                input.value = this.innerHTML;
                items.classList.add('select__items--close');
                input.setAttribute('data-value', value);
                input.dispatchEvent(new CustomEvent('selected'));
            });
        });

        // input.addEventListener('focus', function () {
        //   items.classList.remove('select__items--close');
        // });
        input.addEventListener('click', function () {
            if (!items.classList.contains('select__items--close')) {
                items.classList.add('select__items--close');
            } else {
                items.classList.remove('select__items--close');
            }
        });
        $(input).focusout(function () {
            setTimeout(function () {
                items.classList.add('select__items--close');
            }, 150);
        });
    });
})();

// Вычисление общей суммы и выделение ячейки
(function () {
    $(".product-table__table-input")
        .change(function () {
            if ($(this).val() > 0) {
                $(this).parent().addClass("product-table__table-td-green");
            } else {
                $(this).parent().removeClass("product-table__table-td-green");
                $(this).val(0);
            }
            $(".product-table__price-sum").text(calcPrice());
        })
        .focusin(function () {
            if (parseInt($(this).val()) == 0) {
                $(this).val("");
            }
        })
        .focusout(function () {
            console.log();
            if (parseInt($(this).val()) == NaN || $(this).val() == '') {
                $(this).val(0);
            }
        });

    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function calcPrice() {
        var priceOneStr = $(".info__price").text(),
            priceOne = 0,
            result = 0;
        priceOneStr = priceOneStr.replace(" ", "");
        priceOneStr = priceOneStr.replace(",", ".");
        priceOne = parseFloat(priceOneStr);
        $(".product-table__table-input").each(function (index) {
            result += priceOne * parseInt($(this).val());
        });

        if (isNumeric(result)) {
            return result.toFixed(2)
        } else {
            return "-"
        }
        ;
    }
})();

// input step
(function () {

    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $(".input-step").click(function (e) {
        e.preventDefault();

        if ($(e.target).hasClass("input-step__next")) {
            counter = $(this).find(".input-step__count");
            price = parseInt(counter.val()) + 1;
            counter.val(price);
            dbg = counter;
            counter.attr('size', (counter.val().length) || 1);
            if ($(counter).hasClass('ajax-basket-no-calc-price')) {
                return;
            }
            calcPrice(price);
        }
        if ($(e.target).hasClass("input-step__prev")) {
            counter = $(this).find(".input-step__count");
            count = parseInt(counter.val());
            if (count > 1) {
                counter.val(--count);
                counter.attr('size', (counter.val().length) || 1);
                if ($(counter).hasClass('ajax-basket-no-calc-price')) {
                    return;
                }
                calcPrice(count);
            }
        }
    });

    $(".ajax-basket-product-count").click(function () {
        this.focus();
    })
        .bind("keypress keydown", function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
            // delete or backspace
            if (e.which == 8 || e.which == 46) {
                this.size = (this.value.length - 1) || 1;
                console.log(e.which);
            } else {
                this.size = (this.value.length + 1) || 1;
            }
            if ($(this).hasClass('ajax-basket-no-calc-price')) {
                return;
            }
            if (isNumeric(this.value)) {
                calcPrice(this.value);
            } else {
                calcPrice(0);
            }
        })
        .bind("keyup change", function () {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
            this.size = (this.value.length) || 1;
            if ($(this).hasClass('ajax-basket-no-calc-price')) {
                return;
            }
            if (isNumeric(this.value)) {
                calcPrice(this.value);
            } else {
                calcPrice(0);
            }
        });

    function calcPrice(num) {
        price_item = $(".info__price");
        priceOneStr = price_item.data("price");
        priceOneStr = priceOneStr.replace(" ", "");
        priceOneStr = priceOneStr.replace(",", ".");
        price_item.text((parseFloat(priceOneStr) * num).toFixed(2));
    }
})();

// sticky club
(function () {
    var banner = $(".menu__banner"),
        bannerMargin = parseInt(banner.css("margin-top"));


    bannerMargin = (bannerMargin == 0) ? DEFAULT_CLUB_MARGIN_TOP : bannerMargin;

    $(window).scroll(function () {
        var tmpMargin = bannerMargin - $(window).scrollTop();
        if (tmpMargin > 0) {
            banner.css("margin-top", tmpMargin);
        }
    })

    if (banner !== null && banner.length > 0) {

        // sticky menu
        var copyright = $(".copyright"),
            menu = $("#menu"),
            content = $(".content"),
            qWindow = $(window),
            copyrightBottomDefault = parseInt(copyright.height());

        copyrightBottomDefault = (copyrightBottomDefault == 0) ? DEFAULT_COPYRIGHT_BOTTOM : -copyrightBottomDefault;

        $(window).scroll(function () {
            var menuMarginTop;

            menuoffset = menu.height() - qWindow.height();
            contentoffset = content.height() - (qWindow.scrollTop() + qWindow.height()) + copyrightBottomDefault;

            // Если оставшаяся высота меньше невидимой части меню с "клубом"
            if (contentoffset < menuoffset) {
                menuMarginTop = -(menuoffset - contentoffset);
            } else {
                menuMarginTop = 0;
            }

            visibleH = (qWindow.scrollTop() + qWindow.height()) - content.height() + copyright.height();
            if (visibleH >= 0) {
                copyright.css("bottom", (copyrightBottomDefault + visibleH));
            } else {
                copyright.css("bottom", (copyrightBottomDefault));
            }
            menu.css("margin-top", menuMarginTop);
        });

    } else {
        var copyright = $(".copyright");
        copyright.css("bottom", 0);
    }

})();


// basket product add button
(function () {
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $('.content__main').on('click','.ajax-btn-basket-add',function (e) {
        e.preventDefault();
        btn = $(this);

        productId = $(this).data('product');
        quantity = 0;
        // in card quantity
        tmpQ = btn.parent().find(".ajax-basket-product-count");
        if (tmpQ.val() > 0) {
            quantity = tmpQ.val();
        } else {
            quantity = $('.ajax-basket-product-count').val();
        }
        tmpText = $(this).text();


        if (!isNumeric(quantity) || quantity < 1) btn.text('Ошибка');
        setTimeout(function () {
            btn.text(tmpText);
        }, 3000);

        // Узнаем на какой странице нажата кнопка корзины
        // Если на странице импланта, то
        if ($(this).data("product-is-implant")) {
            status = true;
            console.log('Сработал имплант!');

            // Отправляем в корзину товары
            $(".product-table__table-input").each(function (index) {
                if ($(this).val() > 0) {
                    productId = $(this).data("id");
                    quantity = $(this).val();
                    productDiam = $(this).data("product-diam");
                    productLength = $(this).data("product-length");

                    $.ajax({
                        url: '/personal/cart/ajax.php',
                        data: {
                            'action': 'add',
                            'productId': productId,
                            'quantity': quantity,
                            'productDiam': productDiam,
                            'productLength': productLength
                        },
                        success: function (data) {
                            data = JSON.parse(data);
                            if (!data['status']) status = false;
                        }
                    });
                }
            });

            // все прошло удачно?
            if (status) {
                $(this).text("Добавлено");
            } else {
                $(this).text("Ошибка");
            }

            // Обновляем корзину
            setTimeout(function () {
                $.ajax({
                    url: '/include/basket.php?ajax=Y',
                    data: {},
                    success: function (data) {
                        $(".menu__cart").html(data);
                    }
                });
            }, 600);

            setTimeout(function () {
                btn.text(tmpText);
            }, 3000);

            return 0;
        }

        // На других страницах просто добавляем товар
        $.ajax({
            url: '/personal/cart/ajax.php',
            data: {
                'action': 'add',
                'productId': productId,
                'quantity': quantity
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                if (data['status']) {
                    btn.text('Добавлено');
                } else {
                    btn.text('Ошибка');
                }
                setTimeout(function () {
                    btn.text(tmpText);
                }, 3000);
            }
        });

        var item = btn.closest('.catalog-view__item').length;
        if(item){
            var img_url = btn.closest('.catalog-view__item').find('.catalog-view__item-img').css('background-image').replace('url(','').replace(')','').replace(/\"/gi, "");
            btn.closest('.catalog-view__item').effect( "transfer", { to: $( ".menu__cart" ),className: "transfer_class" }, 1000 );
            $('.transfer_class').html( '<img src="'+ img_url +'" style="height:100%">' );
            $('.transfer_class').css('z-index','20');
        }else{
            var img_url = btn.closest('.product-detail__wrapper').find('.product-detail__img').attr('src');
            btn.closest('.product-detail__wrapper').find('.product-detail__img').effect( "transfer", { to: $( ".menu__cart" ),className: "transfer_class" }, 1000 );
            $('.transfer_class').html( '<img src="'+ img_url +'" style="height:100%">' );
            $('.transfer_class').css('z-index','20');
        }





        // Обновляем корзину
        setTimeout(function () {
            $.ajax({
                url: '/include/basket.php?ajax=Y',
                data: {},
                success: function (data) {
                    $(".menu__cart").html(data);
                }
            });
        }, 600);
    });
})();

// Подгрузка товаров
var counter_click = 1;
$(function () {
    //путь к файлу с компонентом. Указываем параметр
    var path = "/include/catalog_list.php?ajax=Y" + location.search;
    //счетчик страниц
    var currentPage = 1;

    // Нужно ли скрыть кнопку "показать еще"?
    var catalog = $(".catalog-view__items");
    if (currentPage * catalog.data("limit") >= catalog.data("count")) {
        $("#catalog-show-more").hide();
    }



    $("#catalog-show-more").click(function (e) {

        // Включаем анимацию
        var loadButton = $(this),
            tmpContent = loadButton.html();
        $(this).html('<div class="cssload-container"><div class="cssload-speeding-wheel"></div></div>');

        var lastpage = (++currentPage);

        $.get(path + "&SECTION_ID=" + catalog.data("section-id") + "&PAGEN_1=" + lastpage,
            {sort: $.urlParam('sort'), order: $.urlParam('order'), limit: $.urlParam('limit')}, function (data) {

                var stop = false;
                //добавим товары к списку
                $(".catalog-view__items").append($(data));

                // Скрываем кнопку если необходимо
                if (currentPage * 6 >= catalog.data("count")) {
                    $("#catalog-show-more").hide();
                    stop = true;

                    if ($("#catalog-show-more").data('start_to_page') == 1) {
                        $.get(path + "&SECTION_ID=" + catalog.data("section-id") + "&PAGEN_1=" + lastpage,
                            {clear: 'y'},
                            function () {
                        })
                    }
                }

                // Отключаем анимацию
                loadButton.html(tmpContent);

               if (!stop && typeof lastpage_ref != 'undefined') {
                   if (counter_click < lastpage_ref - 1) {
                       console.log(counter_click, lastpage_ref);
                       counter_click++;
                       if (typeof prod_id == 'undefined') {
                           location.href = '#catalog-show-more';
                       } else {
                           // location.href = '#prod'+prod_id;


                       }
                       console.log(counter_click);
                       $("#catalog-show-more").data('start_to_page', 1).click();
                   } else {
                       $("#catalog-show-more").data('start_to_page', 0);
                   }
               }
            });

        //отключим скролл к верху документа
        e.preventDefault();
    });

    if (typeof lastpage_ref != 'undefined') {
        console.log(counter_click, lastpage_ref);
        $("#catalog-show-more").data('start_to_page', 1).click();
    }
});

// Быстрый заказ
$(function () {
    btnIco = $(".ajax-fast-order .btn-ico");
    form = $(".form-fast-order");

    btnIco.click(function () {
        $(this).addClass("hidden");
        form.removeClass("hidden");
    });
    $(".ajax-fast-order .btn-close").click(function () {
        form.addClass("hidden");
        btnIco.removeClass("hidden");
    });

    $(".ajax-fast-order").submit(function () {
        btn = $(this).find('input[type="submit"]');
        name = $(this).find('input[name="name"]').val();
        telephone = $(this).find('input[name="telephone"]').val();
        tovar = $(this).find('input[name="tovar"]').val();
        rule = $(this).find('input[name="rule"]').is(':checked');
        status = $(this).find('input[name="status"]').val();
        info__name = $(this).find('input[name="info__name"]').val();
        source = $(this).find('input[name="source"]').val();
        lead_type = $(this).find('input[name="lead_type"]').val();
        tmpText = btn.val();

        if (!name || !telephone || !rule) {
            btn.val('Ошибка');
            setTimeout(function () {
                btn.val(tmpText);
            }, 3000);
            return false;
        }
		
        $.ajax({
            url: '/form/ajax.php',
            data: {
                'EVENT': 'FORM_ADD_FAST_ORDER',
                'NAME': name,
                'PHONE_NUMBER': telephone,
                'TOVAR': tovar,
                'RULE': rule,
                'status': status,
                'info__name': info__name,
                'source': source,
                'lead_type': lead_type
            },
            success: function (data) {
				console.log(data);
                data = JSON.parse(data);
                if (data['status']) {
                    btn.val('отправлено');
                    setTimeout(function () {
                        btn.val(tmpText);
                        btnIco.removeClass("hidden");
                        form.addClass("hidden");
                    }, 3000);
                } else {
                    btn.val('Ошибка');
                    setTimeout(function () {
                        btn.val(tmpText);
                    }, 3000);
                }
            }
        });

        return false;
    });

});

$(function () {
    var lessons = $('.lesson');
    var monthItems = $('.months__item');
    var monthMobile = $('.js-lesson-months');
    var monthMobileItem = $('.js-lesson-months .select__item');

    monthItems.click(function () {
        monthItems.removeClass('months__item--select');
        $(this).addClass('months__item--select');
        lessons.text('');
        // Анимация загрузки
        lessons.html('<div class="cssload-container"><div class="cssload-speeding-wheel"></div></div>');

        month = $(this).data('month');

        $.ajax({
            url: '/courses/ajax.php',
            data: {
                'month': month
            },
            success: function (data) {
                lessons.html(data);
                $('html, body').animate({
                    scrollTop: monthItems.offset().top
                }, 1000);
            }
        });
    });

    monthMobileItem.click(function () {
        lessons.text('');
        // Анимация загрузки
        lessons.html('<div class="cssload-container"><div class="cssload-speeding-wheel"></div></div>');
        month = $(this).data('value');

        $.ajax({
            url: '/courses/ajax.php',
            data: {
                'month': month
            },
            success: function (data) {
                lessons.html(data);
                $('html, body').animate({
                    scrollTop: monthMobile.offset().top
                }, 1000);
            }
        });
    });

});

// Кнопка оформить заказ
$(function () {
    var btnOrder = $('.ajax-btn-order'),
        form = $('.info__form'),
        name = form.find('[name=NAME]'),
        lastName = form.find('[name=LAST_NAME]'),
        secondName = form.find('[name=SECOND_NAME]'),
        email = form.find('[name=EMAIL]'),
        phone = form.find('[name=PERSONAL_PHONE]'),
        country = form.find('[name=PERSONAL_COUNTRY]'),
        city = form.find('[name=PERSONAL_CITY]'),
        street = form.find('[name=PERSONAL_STREET]'),
        rule = form.find('[name=RULE]');
    address = $('.js-address');



    function inputValid(input) {
        if (!input.val()) {
            tmpClr = input.css('border-color');
            input.css('border-color', '#f00');
            setTimeout(function () {
                input.css('border-color', tmpClr);
            }, 2000);
            return false;
        } else {
            return true;
        }
    }


    btnOrder.click(function () {

        if (inputValid(name) & inputValid(lastName) & inputValid(email) & inputValid(secondName) & inputValid(phone) &  inputValid(city) & inputValid(street) & rule.is(':checked')) {
			
            personal = 'ФИО: ' + name.val() + ' ' + lastName.val() + ' ' + secondName.val() + ' Телефон: ' + phone.val() + ' email: ' + email.val();
            adr = ' Адрес доставки: ' + country.val() + ', ' + city.val() + ', ' + street.val();
			
            console.log(personal + adr);
            $.ajax({
                url: '/personal/ajax.php',
                data: {
                    'create_order': 'Y',
                    'address': personal + adr
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data['status']) {

                        $.fancybox.open({
                            content : '<h2 style="text-align: center">Ваш заказ №'+ data.id +' принят</h2>',
                            maxWidth  : 600,
                            minWidth : 300,
                            maxHeight : 300,
                            padding : 50,
                            openEffect  : 'elastic',
                        });

                        btnOrder.text('оформлено');
                        setTimeout(function () {
                            console.log(data);
                            location.reload();
                        }, 3000);
                    } else {
                        $.fancybox.open({
                            content : '<h2 style="text-align: center">Корзина пустая</h2>',
                            maxWidth  : 600,
                            minWidth : 300,
                            maxHeight : 300,
                            padding : 50,
                            openEffect  : 'elastic',
                        });
                        btnOrder.text('ошибка');
                        console.log(data);
                    }
                }
            });
        } else {
            console.log(form.offset().top);
            $('html, body').animate({
                scrollTop: form.offset().top - 250
            }, 1000);
        }

    });
});

// Удалить элемент из корзины
$(function () {
    var btnOrderDelete = $('.ajax-btn-order-delete');

    btnOrderDelete.click(function () {
        var id = $(this).data('id'),
            btn = $(this),
            tmpText = $(this).text();

        $.ajax({
            url: '/personal/ajax.php',
            data: {
                'delete_order': 'Y',
                'id': id
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data['status']) {
                    btn.text('удалено');
                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                } else {
                    btn.text('ошибка');
                    console.log(data);
                    setTimeout(function () {
                        btn.text(tmpText)
                    }, 2000);
                }
            }
        });
    });

});

// Повторить заказ
$(".product__lnk-reply").click(function () {
    var id = $(this).data('order-id');
    $.ajax({
        url: '/personal/ajax.php?ajax=Y',
        data: {
            'C_ORDER': 'Y',
            'ID': id
        },
        success: function (data) {
            console.log(data);
            res = JSON.parse(data);
            if (res['status']) {
                location.href = '/personal/';
            }
        }
    });
});

// Скролл каталога
$(function () {
    $(window).load(function () {
        $(".catalog-menu__layer").mCustomScrollbar({theme: "minimal-dark", scrollInertia: "300"});
    });
});

// Показать весь текст новости
$(function () {
    var btn = $('.js-show-more-text');

    if (btn !== null && btn.length > 0) {

        var text = $('.news-text__wrapper');

        btn.click(function () {
            text.removeClass('news-text--hide');
            $(this).remove();
        });

        if (text.height() > 600) {
            text.addClass('news-text--hide');
        } else {
            btn.click();
        }
    }

});

$(function () {
    $('.dropdown').mouseenter(function () {
        $(this).toggleClass('active');
    });
    $('.dropdown').mouseleave(function () {
        console.log('focusout');
        $(this).removeClass('active');
    });
})


$(function () {
    $('a.gallery').fancybox();
})

$(function () {
    $(document).on('click', '.menu__items-box a.toggle-submenu', function (event) {
        var $this = $(this), $next = $this.next();
        if ($next.length) {
            $next.slideToggle().parent().siblings().children('ul').filter(':visible').slideToggle();
    //$next.slideToggle().parent().siblings().find('ul').filter(':visible').slideToggle();
    event.preventDefault();
}
});
})

$(function () {
    $(".menu__items-box a.toggle-submenu").click(function () {
     $(this).toggleClass("open");
   });
})
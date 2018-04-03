(function($){

    window.onresize = navigationResize;
    window.onload = navigationResize;

    function navigationResize() {
        $('#nav li.more').before($('#overflow > li'));

        var $navItemMore = $('#nav > li.more'),
            $navItems = $('#nav > li:not(.more)'),
            navItemMoreWidth = navItemWidth = $navItemMore.width(),
            windowWidth = $(".menu__items_top-box").width(),
            navItemMoreLeft, offset, navOverflowWidth, navMenuWidth;

        $navItems.each(function() {
            navItemWidth += $(this).width();
        });

        navItemWidth > windowWidth ? $navItemMore.show() : $navItemMore.hide();

        while (navItemWidth > windowWidth) {
            navItemWidth -= $navItems.last().width();
            $navItems.last().prependTo('#overflow');
            $navItems.splice(-1,1);
        }




        navItemMoreLeft = $('#nav .more').offset().left;
        navOverflowWidth = $('#overflow li').width();

        if($('.menu').css("transform") == "none"){
            navMenuWidth = $('.menu').width();
        }else{
            navMenuWidth = 0;
        }

        offset = navItemMoreLeft - navOverflowWidth / 2 + 9 - navMenuWidth;

        $('#overflow').css({
            'left': offset
        });
    }



}(jQuery));


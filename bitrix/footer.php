</div>

<?$APPLICATION->IncludeComponent(
  "bitrix:main.include",
  ".default",
  Array(
    "AREA_FILE_SHOW" => "file",
    "AREA_FILE_SUFFIX" => "inc",
    "COMPONENT_TEMPLATE" => ".default",
    "EDIT_TEMPLATE" => "",
    "PATH" => "/bitrix/templates/rossdent/include_areas/footer.php"
  )
);?>
</div>


<?/*<script>
$(function (){
	function hashobserv(e){
		$(window).scrollTop(0);
		$('html, body').animate({
			scrollTop: $(window.location.hash).offset().top + 'px'
		}, 1000, 'swing');
	};
	$(window).on('hashchange', function(e) {
    hashobserv();
	});
  setTimeout(function(){
    hashobserv();
  }, 1400);

});
</script>*/?>
<link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/fancybox/jquery.fancybox.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.7/js/swiper.min.js"></script>
<script src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/script/hammer.min.js"></script>
<script src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/fancybox/jquery.fancybox.js"></script>
<script src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/script/script.js?1"></script>
<script src="/bitrix/templates/<? echo SITE_TEMPLATE_ID;?>/vendor/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter37955640 = new Ya.Metrika({
                    id:37955640,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/37955640" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47485888 = new Ya.Metrika2({
                    id:47485888,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/47485888" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script type="text/javascript">
    (function(d, w, k) {
        w.introvert_callback = function() {
            try {
                w.II = new IntrovertIntegration(k);
            } catch (e) {console.log(e)}
        };

        var n = d.getElementsByTagName("script")[0],
            e = d.createElement("script");

        e.type = "text/javascript";
        e.async = true;
        e.src = "https://api.yadrocrm.ru/js/cache/"+ k +".js";
        n.parentNode.insertBefore(e, n);
    })(document, window, 'ffe181a0');
</script>


</body>
</html>

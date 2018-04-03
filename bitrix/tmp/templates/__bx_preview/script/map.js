ymaps.ready(function () {
    var map = new ymaps.Map('map', {
        center: [45.059829, 38.963455],
        zoom: 15,
        controls: []
    });

    map.behaviors.disable(['scrollZoom', 'DblClickZoom']);

    map.geoObjects.add(new ymaps.Placemark([45.059829, 38.963455], {}, {
            iconLayout: 'default#image',
            iconImageHref: '/bitrix/templates/rossdent/img/map-pointer.png',
            iconImageSize: [76, 91],
            iconImageOffset: [-38, -91]
        }
    ));
});

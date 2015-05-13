var map,
    center,
    featureOpts;

var MY_MAPTYPE_ID = 'custom_style';

function getMap(mapID, lat, long, mapColor, waterColor, showMarker, zoom, saturation) {

    center = new google.maps.LatLng(lat, long);

    /**
     * Set the stylers that control map colours.
     *
     * @type {Array}
     */
    featureOpts = [];
    if(mapColor && waterColor) {
        featureOpts = [
            {
                stylers: [
                    {hue: mapColor},
                    {visibility: 'simplified'},
                    {gamma: 0.5},
                    {weight: 0.5},
                    {saturation: saturation}
                ]
            },
            {
                featureType: 'water',
                stylers: [
                    {color: waterColor},
                    {saturation: saturation}
                ]
            }
        ];
    } else {
        featureOpts = [
            {
                stylers: [
                    {saturation: saturation}
                ]
            }
        ];
    }

    /**
     * Set map options
     *
     * @type {{zoom: *, center: google.maps.LatLng, scrollwheel: boolean, mapTypeControlOptions: {mapTypeIds: *[]}, mapTypeId: string}}
     */
    var mapOptions = {
        zoom: zoom,
        center: center,
        scrollwheel: false,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
        },
        mapTypeId: MY_MAPTYPE_ID
    };

    /**
     * Create Map
     *
     * @type {exports.ecmaIdentifiers.Map}
     */
    map = new google.maps.Map(document.getElementById(mapID), mapOptions);

    if(showMarker){
        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    }

    /**
     * Set the styled map
     *
     * @type {{name: string}}
     */
    var styledMapOptions = {
            name: 'Stylised'
        },
        customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

    map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}

/**
 * Initiate the map
 */
(function($) {
    var element =  document.getElementById('map-canvas');
    if (typeof(element) != 'undefined' && element != null) {
        $(document).ready(function () {
            getMap('map-canvas', $latitude, $longitude, $mapColor, $waterColor, $mapMarker, $mapZoom, $mapSaturation)
        });
    }
})(jQuery);
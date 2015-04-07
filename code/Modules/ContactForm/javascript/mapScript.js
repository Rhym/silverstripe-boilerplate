var map,
    center,
    featureOpts;

var MY_MAPTYPE_ID = 'custom_style';

function getMap(mapID, lat, long, mapColor, waterColor, marker, InfoWindows, zoom, saturation) {

    center = new google.maps.LatLng(lat, long);

    featureOpts = [];
    if(mapColor && mapColor) {
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

    var mapOptions = {
        zoom: zoom,
        center: center,
        scrollwheel: false,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
        },
        mapTypeId: MY_MAPTYPE_ID
    };

    map = new google.maps.Map(document.getElementById(mapID), mapOptions);

    var styledMapOptions = {
        name: 'Stylised'
    };

    var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

    if(marker){
        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    }

    if(InfoWindows.Objects){
        var locations = [],
            marker,
            infowindow = new google.maps.InfoWindow();
        for(i = 0;i < InfoWindows.Objects.length;i++){
            locations.push([InfoWindows.Objects[i].title, InfoWindows.Objects[i].lat, InfoWindows.Objects[i].long, InfoWindows.Objects[i].phone, InfoWindows.Objects[i].email]);
        }
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(
                        '<strong>'+locations[i][0]+'</strong>'
                    );
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

    map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}
function initMap() {
  $(document).ready(function () {

    var addMarker = function (lat, lng) {
      map.removeMarkers();
      map.addMarker({
        lat: lat,
        lng: lng,
        title: 'Address point'
      });

      $('#Form-field-Address-latitude').val(lat);
      $('#Form-field-Address-longitude').val(lng);
    };

    var searchPoint = function (obj) {
      GMaps.geocode({
        address: $(obj).val(),
        callback: function (results, status) {

          if (status == 'OK') {
            var latlng = results[0].geometry.location;
            map.setCenter(latlng.lat(), latlng.lng());
            addMarker(latlng.lat(), latlng.lng());
          }
        }
      });
    };

    var map = new GMaps({
      div: '#map',
      lat: $('#Form-field-Address-latitude').val(),
      lng: $('#Form-field-Address-longitude').val(),
      click: function (e) {
        addMarker(e.latLng.lat(), e.latLng.lng());
      }
    });

    addMarker($('#Form-field-Address-latitude').val(), $('#Form-field-Address-longitude').val());

    // search address
    try {
      $('#Form-field-Address-name_en').on('keyup', function (e) {  searchPoint(this)});
    }catch(e){
      console.error(e);
    }

    try {
      $('#Form-field-Address-name_ru').on('keyup', function (e) {  searchPoint(this)});
    }catch(e){
      console.error(e);
    }

    try {
      $('#Form-field-Address-name_uk').on('keyup', function (e) {  searchPoint(this)});
    }catch(e){
      console.error(e);
    }


  });
}


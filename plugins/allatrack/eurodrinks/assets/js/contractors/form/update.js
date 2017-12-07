$(document).ready(function () {

  var map;
  var addMarker = function (lat, lng) {
    map.removeMarkers();
    map.addMarker({
      lat: lat,
      lng: lng,
      title: 'Address point'
    });

    $('#Form-field-Contractor-latitude').val(lat);
    $('#Form-field-Contractor-longitude').val(lng);
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
  var initMap = function (e) {

    if (document.getElementById('Form-field-Contractor-_new_address').checked){

      console.log(map);
      if (map===undefined){
        map = new GMaps({
          div: '#map-contractor',
          lat: 50.45466,
          lng: 30.5238,
          click: function (e) {
            addMarker(e.latLng.lat(), e.latLng.lng());
          },
          idle:function (e) {
            console.log('idle');
          }
        });
        // search address
        $('#Form-field-Contractor-name_en').on('keyup', function (e) { searchPoint(this)});

      } else {
        $('#Form-field-Contractor-_map-group').removeClass('hide');
      }


    } else {
      $('#Form-field-Contractor-_map-group').addClass('hide');
    }
  }

  $('#Form-field-Contractor-_new_address').on('change', function (e) {
    initMap()
  });
});



/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  administrative_area_level_2: 'long_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function fillInAddress() {
  var place = autocomplete.getPlace();
  
  $('#registrationasmember-form-user_latitude').val(place.geometry.location.lat());
  $('#registrationasmember-form-user_longitude').val(place.geometry.location.lng());
  
  for (var component in componentForm) {
    $('#'+component).val('');
  }
  $('#registrationasmember-form-user_address').val('');

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      $('#'+addressType).val(val);
    }
    if(addressType === 'country'){
       $('#registrationasmember-form-country_country_id option').filter(function () {
           var val = place.address_components[i][componentForm[addressType]];
           return $.trim($(this).text()) == val;
       }).prop('selected', true); 
    }
  }
  fillUserAddress();
}

function fillUserAddress() {   
    var address;
    
    address = $("#registrationasmember-form-user_lastname").val();
    address += " ";
    address += $("#registrationasmember-form-user_forname").val();
    address += "\n";
    address += $("#street_number").val() + ", " + $("#route").val();
    address += "\n";
    address += $("#locality").val() + " " + $("#postal_code").val();
    address += "\n";
    address += $("#administrative_area_level_1").val() + " / " + $("#administrative_area_level_2").val();
    address += "\n";
    address += $("#country").val();   
  
    $('#registrationasmember-form-user_address').val(address);
}

function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

$(document).ready(function (){
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
        { types: ['geocode'] });
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      fillInAddress();
    });
});
/**
 * SCRIPT GDC
 */


$(document).ready(function(){

	if( $('#map').length ){

		var map = L.map('map').setView([51.505, 40.09], 2);

		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);

		if(points != undefined){

			$.each(points, function(key,point){

				L.marker([point.x,point.y]).addTo(map)
					.bindPopup(point.legend);
			})

		}

	}


	

});


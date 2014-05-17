<?php get_header(); ?>

<content>
	

	<?php
	  
	global $wp_query;
	//$args = array( 'post_type' => 'collection', 'posts_per_page' => '-1' );
	//query_posts( $args );
	
	if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			</div>
			
			<?php the_content();?>
			
	<?php endwhile; ?>
	<div class="navigation">
	<?php posts_nav_link(' - ','page suivante','page pr&eacute;c&eacute;dente'); ?>
	</div>
	<?php else : ?>
	<h2>Oooopppsss...</h2>
	<p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici .</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>

	<!-- GOOGLE MAP -->
	<!--<iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/?ie=UTF8&amp;ll=48.69096,2.460938&amp;spn=153.310211,336.445312&amp;t=m&amp;z=2&amp;output=embed"></iframe>-->

	
	<!-- OPENSTREET MAP -->
	<!-- cf http://leafletjs.com !!!! -->
	<!-- + https://github.com/Leaflet/Leaflet.markercluster -->
	<style>
	#mapdiv{
		width:100%;
		height:500px;
	}
	</style>

	<div id="mapdiv"></div>
  	<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
  	<script>
	map = new OpenLayers.Map("mapdiv");
	map.addLayer(new OpenLayers.Layer.OSM());

	/*var pois = new OpenLayers.Layer.Text( "My Points",
	{ location:"./textfile.txt",
	  projection: map.displayProjection
	});
	map.addLayer(pois);*/
	/*
	lat	lon	title	description	icon	iconSize	iconOffset
	48.9459301	9.6075669	Title One	Description one<br>Second line.<br><br>(click again to close)	Ol_icon_blue_example.png	24,24	0,-24
	48.9899851	9.5382032	Title Two	Description two.	Ol_icon_red_example.png	16,16	-8,-8*/

	//Set start centrepoint and zoom    
	var lonLat = new OpenLayers.LonLat( 9.5788, 48.9773 )
	.transform(
		new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
		map.getProjectionObject() // to Spherical Mercator Projection
	);
	var zoom=3;
	map.setCenter (lonLat, zoom);  

	</script>





	<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="http://maps.gstatic.com/intl/fr_fr/mapfiles/api-3/9/16/main.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	});

/*

[
  {
    "stylers": [
      { "visibility": "on" },
      { "hue": "#ff0008" },
      { "saturation": 100 },
      { "lightness": 6 },
      { "gamma": 0.56 }
    ]
  }
]*/

	//<![CDATA[
	function initialize() {
		var myOptions = {
			zoom: 4,
			center: new google.maps.LatLng(moyenneX, moyenneY),
			mapTypeId: google.maps.MapTypeId.TERRAIN,
		}
		var map = new google.maps.Map(document.getElementById("gmap"),
								myOptions);
		
		setMarkers(map, voyages);
		
		google.maps.event.addListener(map, 'idle', function(){
			if(!mapLoaded){
				$('#google_map').trigger('mapLoaded');
				mapLoaded = true;
				
				$(".gmnoprint").each(function(){
					$(this).append('<p>'+$(this).attr('title')+'</p>');
				});
			}
		});
		
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
	var collections = new Array;
				var collection = new Array('Dans Rennes, à l’œuvre…', 48.113928553145, -1.6793096065521, 1, 'http://www.aitre.eu/voyage/dans-rennes-a-loeuvre/');
			collections.push(intermediaire);


		/**
	 * Data for the markers consisting of a name, a LatLng and a zIndex for
	 * the order in which these markers should display on top of each
	 * other.
	 */
	 
	 // TITRE , latitude, longitude, zindex, URL
	/*var voyages = [
		['Voyage 1 TITRE', 50.983363524099, 5.5269491672516, 1,'http://www.aitre.eu/url1'],
		['Voyage 2 TITRE', 51.999117172329, 4.9391806125641, 2,'http://www.aitre.eu/url2'],
		['Voyage 3 TITRE', 51.427330279349, 7.0046103000641, 3,'http://www.aitre.eu/url3'],
	];*/
	
	var moyenneX = 0;
	var moyenneY = 0;
	for(var i =0;i<voyages.length;i++){
		moyenneX+= voyages[i][1];
		moyenneY+= voyages[i][2];
	}
	moyenneX = moyenneX/collections.length;
	moyenneY = moyenneY/collections.length;
	
	
	function setMarkers(map, locations) {
		// Add markers to the map
		
		// Marker sizes are expressed as a Size of X,Y
		// where the origin of the image (0,0) is located
		// in the top left of the image.
		
		// Origins, anchor positions and coordinates of the marker
		// increase in the X direction to the right and in
		// the Y direction down.
		// ON VA SUREMENT CHANGER L'ICONE
		var image = new google.maps.MarkerImage('http://www.aitre.eu/wp-content/themes/aitre/img/icone_gmap.png',
		// This marker is 20 pixels wide by 32 pixels tall.
		new google.maps.Size(43, 42),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(12, 42));
		// Shapes define the clickable region of the icon.
		// The type defines an HTML &lt;area&gt; element 'poly' which
		// traces out a polygon as a series of X,Y points. The final
		// coordinate closes the poly by connecting to the first
		// coordinate.
		var shape = {
			coord: [1, 1, 1, 31, 97, 31, 97 , 1],
			type: 'poly'
		};
		for (var i = 0; i < locations.length; i++) {
			var voyage = locations[i];
			var myLatLng = new google.maps.LatLng(voyage[1], voyage[2]);
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				//shadow: shadow,
				icon: image,
				shape: shape,
				title: voyage[0],
				zIndex: voyage[3],
				url:voyage[4],
			});
			google.maps.event.addListener(marker, "click", function() {
				// ON VA SUR LA PAGE CORRESPONDANT  A L'URL DU POINT
				window.location = this.url;
			});
			/*google.maps.event.addListener(marker, "mouseover", function() {
				// ON VA FICHER LE TEXTE DANS LE TITRE
				// SI IL FAUT ON FERA UNE BOITE PARTICULIERE
				$('#prochain_sejour h2').text(this.title);
			});
			google.maps.event.addListener(marker, "mouseout", function() {
				// ON REMET LE TEITRE EN ETAT NORMAL
				$('#prochain_sejour h2').text('Trouvez votre prochain séjour');
			});*/
																																
		}
	}
	
	//initialize();
	//]]>
</script>

</content>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
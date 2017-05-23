jQuery(window).load( function(){
	$('#google-map').gMap({
		address: 'Menara Sentraya, Jl. Iskandarsyah Raya No.1A, Jakarta, 12130, Indonesia',
		maptype: 'ROADMAP',
		zoom: 15,
		markers: [
			{
				address: "Menara Sentraya, Jl. Iskandarsyah Raya No.1A, Jakarta 12130, Indonesia",
				html: '<div style="width: 300px;"><h4 style="margin-bottom: 8px;">Hi, we\'re <span>Dentsu Digital</span></h4><p class="nobottommargin"> We <strong>Creative.</strong> We <strong>Think.</strong> <br>We <strong>Design.</strong> - Your <strong>Future.</strong><br> Our mission is to <strong>assist</strong> our clients create such high levels of business enterprise value that collectively we set new standards of excellence in our respective industries.</p></div>',
				icon: {
					image: "images/icons/map-icon-red.png",
					iconsize: [32, 39],
					iconanchor: [13,39]
				}
			}
		],
		doubleclickzoom: false,
		controls: {
			panControl: true,
			zoomControl: true,
			mapTypeControl: true,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: false
		}
	});
});

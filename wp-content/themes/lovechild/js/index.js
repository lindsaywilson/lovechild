/* global google, InfoBox */

$(document).ready(function(){
	
	$(window).on('resize', function(){
		var frameHeight = $(this).height()-43-15;
		var pageHeight = $('#content').outerHeight(true);
		if (frameHeight < pageHeight) {
			frameHeight = 'auto';
		}else{
			frameHeight += 'px';
		}
		$('#frame').css('height', frameHeight);
	}).load(function(){
		$(this).trigger('resize');
	}).trigger('resize');
	
	$('#nav .button').each(function(){
		var text = $(this).text();
		var span = $(this).find('span.wrap');
		for (var i = 0; i < 16; i++) {
			span.append('<span class="shadow">' + text + '</span>');
			span = span.find('span.shadow');
		}
	});
	
	//
	// It's the home page!
	//
	if ($('#spinbox').length) {
	
		var spin = function(destination) {
			
			clearInterval(autospin);
			
			if (destination === 'next') {
				destination = $('#indicators li.selected').index() + 1;
				if (destination === $('#indicators li').length) {
					destination = 0;
				}
			}
			
			if ($('#slides li.on').index() !== destination) {
				$('#slides li:eq(' + destination + ')').addClass('queued');
				$('#indicators li.selected').removeClass('selected');
				$('#indicators li:eq(' + destination + ')').addClass('selected');
				$('#slides li.on').fadeOut(300);
				$('#slides li.queued').fadeIn(300, function(){
					$('#slides li.on').removeClass('on').attr('style','');
					$(this).addClass('on').removeClass('queued').attr('style','');
					autospin = setTimeout(function(){
						spin('next');
					}, 7000);
				});
			}
			
		};
		
		var autospin = setTimeout(function(){
			spin('next');
		},7000);
		
		$('#spinbox #indicators a').on('click', function(e){
			e.preventDefault();
			spin($(this).closest('li').index());
		});
		
		$(window).on('mousemove', function(e){
			var percentX = e.pageX/$(this).width();
			var percentY = e.pageY/$(this).height();
			$('#frame').css('backgroundPosition', (-20*percentX) + 'px ' + (30*percentY) + 'px');
			$('.hill').css('margin-bottom', (-50*percentY) + 'px');
			$('.hill.large.left').css('margin-left', (-100*percentX) + 'px');
			$('.hill.large.right').css('margin-right', (-100*(1-percentX)) + 'px');
			$('.hill.small.left').css('margin-left', (-50*percentX) + 'px');
			$('.hill.small.right').css('margin-right', (-50*(1-percentX)) + 'px');
			$('#banana').css({
				'margin-left': (-150*percentX) + 'px',
				'margin-bottom': (-75*percentY) + 'px'
			});
			$('#apricot').css({
				'margin-right': (-200*(1-percentX)) + 'px',
				'margin-bottom': (-100*percentY) + 'px'
			});
		}).load(function(){
			$(this).trigger('mousemove');
		}).trigger('mousemove');
	
	}
	
	//
	// It's the products page!
	//
	if ($('body').hasClass('products')) {
		
	}
	
	//
	// It's the story page!
	//
	if ($('body').hasClass('story')) {
		
	}
	
	//
	// It's the questions page!
	//
	if ($('body').hasClass('questions')) {
		
		$('#faqs li h3 a').on('click', function(e){
			e.preventDefault();
			$(this).closest('li').find('.answer').slideToggle(function(){
				$(window).trigger('resize');
			});
		});
		
		$('#search').on('keyup', function(){
			var query = $(this).val().toLowerCase();
			$('#faqs ul li').show().filter(function(){
				return $(this).find('h3').text().toLowerCase().indexOf(query) === -1;
			}).hide();
		});
		
	}
	
	//
	// It's the news page!
	//
	if ($('body').hasClass('news')) {
		
	}
	
	//
	// It's the nutrition page!
	//
	if ($('body').hasClass('nutrition')) {
		
	}
	
	//
	// Resize teaser images
	//
	if ($('.teaser').length) {
		
		$('#content').imagesLoaded().done(function(){
			
			$('.teaser').each(function(){
				
				var tRatio = $(this).width()/$(this).height();
				var tImg = $(this).find('img');
				var iRatio = tImg.width()/tImg.height();
				var cmap = {};
				
				if (iRatio > tRatio) {
					cmap = {
						'width': ($(this).height()*iRatio) + 'px',
						'height': $(this).height() + 'px',
						'margin-left': (($(this).height()*iRatio)/-2) + 'px',
						'margin-top': ($(this).height()/-2) + 'px'
					};
				}else{
					cmap = {
						'width': $(this).width() + 'px',
						'height': ($(this).width()/iRatio) + 'px',
						'margin-left': ($(this).width()/-2) + 'px',
						'margin-top': (($(this).width()/iRatio)/-2) + 'px'
					};
				}
				
				tImg.css(cmap);
				
			});
			
		});
		
	}
	
	//
	// Open share dialog
	//
	if ($('.share').length) {
		
		$('.share a').on('click', function(e){
			e.preventDefault();
			window.open($(this).attr('href'), '_blank', 'width=640,height=480');
		});
		
	}
	
	//
	// Fade out intro on scroll
	//
	if ($('.box.intro').length) {
		
		var introHeight = 0;
		
		$(window).on('scroll', function(e){
			
			var scrollPos = $(this).scrollTop();
			
			$('.box.intro').css('opacity', (1 - scrollPos/173));
			$('.box.first').css('margin-top', (introHeight * Math.max(0, Math.min(1, (1 - scrollPos/173)))) + 'px');
			
		}).load(function(){
			
			introHeight = $('.box.intro').outerHeight(true);
			$(this).trigger('scroll');
			
		}).trigger('scroll');
		
	}
	
	//
	// Lock sidebar on scroll
	//
	if ($('#sidebar').length) {
		
		var brushed = $('#sidebar').hasClass('brushed');
		
		if (brushed) {
			
			var sections = [];
		
			$('#sidebar a').on('click', function(e){
				e.preventDefault();
				$('body,html').animate({
					'scrollTop': (sections[$(this).closest('li').index()]-171) + 'px'
				},1000);
			});
			
		}

		$(window).on('resize', function(e){
			
			$('#sidebar').css('height', ($(this).height() - 21 - 83) + 'px');
			
		}).on('scroll', function(e){
			
			var scrollPos = $(this).scrollTop();
			if (scrollPos > 21) {
				$('#sidebar').addClass('locked');
			}else{
				$('#sidebar').removeClass('locked');
			}
			
			if (brushed) {
				
				$('#sidebar li').removeClass('on');
				var navOn = 0;
			
				for (var i = 0; i < sections.length; i++) {
					if (scrollPos > sections[i]-173) {
						navOn = i;
					}
				}
			
				$('#sidebar li:eq(' + navOn + ')').addClass('on');
				
			}
			
		}).load(function(){
			
			if (brushed) {
				
				var introOffset = $('.box.intro').outerHeight(true);
				
				$('.box:not(.intro)').each(function(){
					sections.push($(this).offset().top-introOffset);
				});
				
			}
			
			$('#content').css('min-height', $('#sidebar').height() + 'px');
			
			$(this).trigger('scroll').trigger('resize');
			
		}).trigger('scroll').trigger('resize');
		
		if ($('#sidebar #archive').length) {
		
			$('#archive a.year').on('click', function(e){
				e.preventDefault();
				$('#archive ul ul').hide();
				$(this).closest('li').find('ul').show();
			});
			
		}
		
	}
	
	//
	// Maps
	//
	if ($('#map').length) {
		
		var geo = new google.maps.Geocoder();
		var map = new google.maps.Map(document.getElementById("map-canvas"), {
			zoom: 14
		});
		
		var infowindow = new google.maps.InfoWindow({
			content: '<div id="infowindow"></div>'
		});
		
		var infobox = new InfoBox({
			boxClass: 'infobox',
			pixelOffset: new google.maps.Size(-357,-38),
			closeBoxURL: window.template_url + '/images/marker/blank.png',
			closeBoxMargin: '-14px -16px 0 0',
			isHidden: false,
			enableEventPropagation: false
		});
		
		var retailers = [];
		var locals = [];
		var markers = [];

		var diff = function(a,b) {
			return Math.abs(a-b);
		};
		
		var plotRetailers = function() {
			
			for (var j = 0; j < markers.length; j++) {
				markers[j].setMap(null);
			}
			markers = [];
			
			var retailersList = '';
			
			for (var i = 0; i < locals.length; i++) {
				
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(locals[i].lat, locals[i].lon),
					map: map,
					html: '<h3>' + locals[i].name + '</h3><p>' + locals[i].address + '</p><a href="https://www.google.ca/maps/place/' + encodeURIComponent(locals[i].address) + '" target="_blank" class="gmap">View in Google Maps</a>',
					icon: {
						url: window.template_url + '/images/marker/marker-' + (i+1) + '.png',
						size: new google.maps.Size(37,39),
						origin: new google.maps.Point(0,0),
						anchor: new google.maps.Point(15, 37)
					}
				});
				markers.push(marker);
		
				google.maps.event.addListener(marker, 'click', function() {
					infobox.content_ = this.html;
					infobox.open(map, this);
				});
				
				retailersList += '<li><a href="#">' + locals[i].name + '</a></li>';
				
			}
			
			if (retailersList === '') {
				retailersList = 'No nearby retailers';
			}
			
			$('#retailers ol').html(retailersList);
			
		};
		
		var narrowResults = function() {
			
			var bounds = map.getBounds();
			
			locals = [];
			
			for (var i = 0; i < retailers.length; i++) {
				
				if (bounds.contains(new google.maps.LatLng(retailers[i].lat, retailers[i].lon))) {
					
					if ($('#retailers #search').val() !== '') {
						if (retailers[i].name.toLowerCase().indexOf($('#retailers #search').val().toLowerCase()) > -1) {
							locals.push(retailers[i]);
						}
					}else{
						locals.push(retailers[i]);
					}
					
				}
				
			}
			
			locals = locals.slice(0,30);
			
		};
		
		var refreshMarkers = function() {
			narrowResults();
			plotRetailers();
		};

		var handledGeolocation = false;
		var handleNoGeolocation = function(browserRejected) {
			var coords = new google.maps.LatLng(35.0555, -70.2437);
			map.setCenter(coords);
			map.setZoom(3);
		
			refreshMarkers();
		};

		retailers = window.retailers;
		$.getJSON('http://freegeoip.net/json/?callback=?', function(data) {
			
			var coords = new google.maps.LatLng(data.latitude, data.longitude);
			map.setCenter(coords);

			handledGeolocation = true;
		
			refreshMarkers();
		});

		window.setTimeout(function(){
			if (handledGeolocation == false)
			{
				if (navigator.geolocation)
				{
					var geoOptions = {
						enableHighAccuracy: true,
						timeout: 5000,
						maximumAge: 0
					};

					navigator.geolocation.getCurrentPosition(function(position) {
					      	var coords = new google.maps.LatLng(position.coords.latitude,
				                                       position.coords.longitude);
							map.setCenter(coords);
						
							refreshMarkers();
				    }, function() {
				      handleNoGeolocation(true);
				    }, geoOptions);
				} else {
					handleNoGeolocation(false);
				}
			}
		}, 1000);
		
		google.maps.event.addListener(map, 'center_changed', function() {
			refreshMarkers();
		});
		
		google.maps.event.addListener(map, 'zoom_changed', function() {
			refreshMarkers();
		});
		
		$('a#locate').on('click',function(e){
			e.preventDefault();
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position){
					var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					map.setCenter(coords);
					geo.geocode({
						location: coords
					}, function(results, status){
						for (var i = 0; i < results.length; i++) {
							if (results[i].types.indexOf('locality') > -1 && results[i].types.indexOf('political') > -1) {
								$('a#locate').text(results[i].formatted_address);
							}
						}
					});
				});
			}else{
				$('a#locate').text('Geolocation not supported');
			}
		});
		
		$('#locator form').on('submit',function(e){
			e.preventDefault();
			var locale = $(this).find('#locale').val();
			geo.geocode({
				address: locale
			}, function(results, status){
				map.setZoom(14);
				map.setCenter(results[0].geometry.location);
			});
		});
		
		$('#retailers #search').on('keyup', function(e){
			var query = $(this).val();
			$('#retailers ol li').show().filter(function(){
				return $(this).text().indexOf(query) === -1;
			}).hide();
			if (!$('#retailers ol li:visible').length) {
				$('#noResults').show();
			}else{
				$('#noResults').hide();
			}
			refreshMarkers();
		});
		
		$('.stores ul').each(function(){
			var storesList = $(this);
			var storesWidth = 0;
			storesList.imagesLoaded().done(function(data){
				storesList.find('li').each(function(){
					storesWidth += $(this).outerWidth(true);
				});
				storesWidth += 50;
				if (storesWidth > storesList.width()) {
					storesList.parent().find('.grad').show();
					var storesDiff = storesList.width() - storesWidth;
					storesList.on('mousemove', function(e){
						var posX = e.originalEvent.layerX/storesList.width();
						storesList.find('li:first').css('margin-left', (storesDiff*posX)+25 + 'px');
					});
				}
			});
		});
		
		$(document).on('click', '#retailers a', function(e){
			e.preventDefault();
			google.maps.event.trigger(markers[$(this).closest('li').index()], 'click');
		});
		
	}
	
	//
	// Show fruity facts
	//
	if ($('#fruit').length) {
		
		$('#fruit a').on('mouseenter', function() {
			$(this).siblings('a').addClass('faded');
			$('#fruit #fact').html('<h3>' + $(this).find('img').attr('alt') + '</h3><p>' + decodeURIComponent($(this).data('description')).replace('\\', '') + '</p>').show();
		}).on('mouseleave', function() {
			$(this).siblings('a').removeClass('faded');
			$('#fruit #fact').hide();
		}).on('click', function(e) {
			e.preventDefault();
		});
		
	}
	
	/* touch nicer stuff */
	function isTouch() {  
	  try {  
		document.createEvent("TouchEvent");  
		return true;  
	  } catch (e) {  
		return false;  
	  }  
	}
	if (isTouch())
	{
		try
		{
			var ignore = /:hover/;
			for (var i=0; i<document.styleSheets.length; i++)
			{
				var sheet = document.styleSheets[i];
				for (var j=sheet.cssRules.length-1; j>=0; j--)
				{
					var rule = sheet.cssRules[j];
					if (rule.type === CSSRule.STYLE_RULE && ignore.test(rule.selectorText))
					{
						sheet.deleteRule(j);
					}
				}
			}
		}
		catch(e){}
	}
});

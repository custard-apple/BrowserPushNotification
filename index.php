
<html>
	<head>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.simpleWeather.js"></script>
	<link rel="stylesheet" type="text/css" href="css/weather.css">
	</head>
	<body>
		<button class="js-geolocation">Get Weather</button>
		<div class="guide">
		<h3>Guide to get current weather...</h3>
		<article>
			<ul>
				<li>Please Click on the above Get Weather Button</li>
				<li>It will show a pupup to allow browser to track your current location on the top left corner of the browser</li>
				<li>Click on the allow/share link on the popup</li>
				<li>Then It will show browser push notification on the botton right corner which include Current weather forcast as sample given below</li>
			</ul>
			<img class="push" src="imgs/weather_push.png">
		</article>
		</div>
	</body>
</html>
<script>
	/* Does your browser support geolocation? */
	if ("geolocation" in navigator) {
	  $('.js-geolocation').show(); 
	} else {
	  $('.js-geolocation').hide();
	}

	/* Where in the world are you? */
	$('.js-geolocation').on('click', function() {
	  navigator.geolocation.getCurrentPosition(function(position) {
	    loadWeather(position.coords.latitude+','+position.coords.longitude);
	    //load weather using your lat/lng coordinates
	  });
	});

	function loadWeather(location, woeid) {
	  $.simpleWeather({
	    location: location,
	    woeid: woeid,
	    unit: 'f',
	    success: function(weather) {
	    	var matter = weather.temp+"° "+weather.units.temp +", "+ weather.city+" "+weather.region +", "+ weather.currently+", "+weather.alt.temp+"°";
				var title = weather.city+"'s Current Weather :";
			if (!("Notification" in window)) {
				alert("This browser does not support desktop notification");
			}
			// Let's check whether notification permissions have already been granted
			//for html file
			else if (Notification.permission === "granted") {
				var notification = new Notification(title, {
				    icon: 'imgs/weather.png',
				    body: matter,
				});
			}

		  	// Otherwise, we need to ask the user for permission
		  	//for php file
			else if (Notification.permission !== "denied") {
				Notification.requestPermission(function (permission) {
				  // If the user accepts, let's create a notification
				  if (permission === "granted") {
				    var notification = new Notification(title, {
					    icon: 'imgs/weather.png',
					    body: matter,
					});
				  }
				});
			}
	    },
	    error: function(error) {
	      $("#weather").html('<p>'+error+'</p>');
	    }
	  });
	}
</script>
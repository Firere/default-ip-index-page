<?php
// This variable assumes you're running Nginx on Ubuntu 20.04,
// but if your path for enabled sites is different you may modify this
$sitesEnabledPath = "/etc/nginx/sites-enabled";

// You can configure sites which you want ignored by their filename -
// assuming your configuration file for the bare IP is root.conf,
// this ignores it by default
$ignoredSites = array(
	"root.conf"
);

// scandir() has 3 parameters, the second of which is in what order to
// store the elements in the array (alphabetical is default) and the
// last of which is context which can only be null in PHP >=8.0
$sitesEnabled = scandir($sitesEnabledPath);
# To remove empty "." and ".." directories
array_splice($sitesEnabled, 0, 2);

// This only works (properly) if your configuration files end in .conf (or more specifically,
// there are 5 characters after the domain name); to edit each file to show only the domain,
// you will have to implement something yourself, though if the files are the domain itself
// you can simply erase/comment out lines 17 to 21
foreach ($sitesEnabled as &$site) {
	if (in_array($site, $ignoredSites)) {
		$ignoredSite = array_search($site, $sitesEnabled);
		unset($sitesEnabled[$ignoredSite]);
		continue;
	}

	$site = substr($site, 0, -5);
}
# For why this is done, see: https://bugs.php.net/bug.php?id=60534
unset($site);
?>
<!DOCTYPE html>
<html>
<head>
	<style>
		#sites {
			text-align: center;
		}
		.site-container {
			width: 250px;
			border: .75px black solid;
			border-radius: 20px;
		}
	</style>
	<title></title>
</head>
<body>
	<h1 id="header-ip"></h1>
	<hr/>
	<div id="sites">
		<?php
			foreach ($sitesEnabled as $site) { ?>
		<div class="site-container" id="<?= $site ?>">
			<div class="site"><?= $site ?></div>
		</div>
		<?php } ?>
	</div>
	<script>
		const serverIp = window.location.hostname;
		document.getElementsByTagName("title")[0].innerHTML = "Server " + serverIp;
		document.getElementById("header-ip").innerHTML = "Server " + serverIp;

		for (let site in document.getElementsByClassName("site-container")) {
			//const snapshot = 
			document.getElementsByClassName("site-container")[site].style.backgroundImage = snapshot;
		}
	</script>
	<script>
		function run() {
			const url = setUpQuery();
			fetch(url)
				.then(response => response.json())
				.then(json => {
		      	// See https://developers.google.com/speed/docs/insights/v5/reference/pagespeedapi/	runpagespeed#response
		      	// to learn more about each of the properties in the response object.
		      	showInitialContent(json.id);
		      	const cruxMetrics = {
		        	"First Contentful Paint": json.loadingExperience.metrics.FIRST_CONTENTFUL_PAINT_MS.	category,
		        	"First Input Delay": json.loadingExperience.metrics.FIRST_INPUT_DELAY_MS.category
		      	};
		      	showCruxContent(cruxMetrics);
		      	const lighthouse = json.lighthouseResult;
		      	const lighthouseMetrics = {
		       		'First Contentful Paint': lighthouse.audits['first-contentful-paint'].displayValue,
		        	'Speed Index': lighthouse.audits['speed-index'].displayValue,
		        	'Time To Interactive': lighthouse.audits['interactive'].displayValue,
		        	'First Meaningful Paint': lighthouse.audits['first-meaningful-paint'].displayValue,
		        	'First CPU Idle': lighthouse.audits['first-cpu-idle'].displayValue,
		        	'Estimated Input Latency': lighthouse.audits['estimated-input-latency'].displayValue
		      	};
		      	showLighthouseContent(lighthouseMetrics);
		    });
		}

		function setUpQuery() {
		  	const api = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
		  	const parameters = {
		    	url: encodeURIComponent('https://developers.google.com')
		  	};
		  	let query = `${api}?`;
		  	for (key in parameters) {
		    	query += `${key}=${parameters[key]}`;
		  	}
		  	return query;
		}

		function showInitialContent(id) {
		  	document.body.innerHTML = '';
		  	const title = document.createElement('h1');
		  	title.textContent = 'PageSpeed Insights API Demo';
		  	document.body.appendChild(title);
		  	const page = document.createElement('p');
		  	page.textContent = `Page tested: ${id}`;
		  	document.body.appendChild(page);
		}

		function showCruxContent(cruxMetrics) {
		  	const cruxHeader = document.createElement('h2');
		  	cruxHeader.textContent = "Chrome User Experience Report Results";
		  	document.body.appendChild(cruxHeader);
		  	for (key in cruxMetrics) {
		  		const p = document.createElement('p');
		    	p.textContent = `${key}: ${cruxMetrics[key]}`;
		    	document.body.appendChild(p);
		  	}
		}

		function showLighthouseContent(lighthouseMetrics) {
		  	const lighthouseHeader = document.createElement('h2');
		  	lighthouseHeader.textContent = "Lighthouse Results";
		  	document.body.appendChild(lighthouseHeader);
		  	for (key in lighthouseMetrics) {
		    	const p = document.createElement('p');
				p.textContent = `${key}: ${lighthouseMetrics[key]}`;
		    	document.body.appendChild(p);
		  	}
		}

		run();
	</script>
</body>
</html>

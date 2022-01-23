<?php
// This variable assumes you're running Nginx on Ubuntu 20.04,
// but if your path for enabled sites is different you may modify this
$sitesEnabledPath = "./test";

// scandir() has 3 parameters, the last of which is context;
// it can only be nullable in version >=8.0.0
$sitesEnabled = scandir($sitesEnabledPath);

# to remove empty "." and ".." directories
array_splice($sitesEnabled, 0, 2);


// This only works (properly) if your configuration files end in conf;
// to edit each file to show only the domain, you will have to implement
// something yourself, though if the files are the domain itself you don't
// have to do anything
foreach ($sitesEnabled as &$site) {
	$site = substr($site, 0, -5);
}

# For why this is done, see: https://bugs.php.net/bug.php?id=60534
unset($site);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1 id="header-ip"><h1>
	<hr/>
	<div id="sites">
		<?php
			foreach ($sitesEnabled as $site) {
				echo
"
		<div class=\"site-container\" id=\"" . $site . "\">
			" . $site . "
		</div>	
";
			}
		?>
	</div>
	<script>
		window.onload = function() {
			const serverIp = window.location.hostname;
			document.getElementsByTagName("title")[0].innerHTML = "Server " + serverIp;
			document.getElementById("header-ip").innerHTML = "Server " + serverIp;
		}	
	</script>
</body>
</html>

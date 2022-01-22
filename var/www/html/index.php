<?php
/*
 * This variable assumes you're running Nginx on Ubuntu 20.04,
 * but if your path for enabled sites is different you may modify this
*/
$sitesEnabled = "/etc/nginx/sites-enabled/";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1 id="header-ip"><h1>
	<script>
		window.onload = function() {
			const serverIp = window.location.hostname;
			document.getElementsByTagName("title")[0].innerHTML = "Server " + serverIp;
			document.getElementById("header-ip").innerHTML = "Server " + serverIp;
		}	
	</script>
</body>
</html>

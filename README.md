# default-ip-index-page
A default index page to show when a user connects to the bare IP, showing all sites on that server.

The default files assume:
- You are running Ubuntu >=20.04 (though may work lower, depending on how Nginx structures directories in those versions)
- You are using Nginx/Apache2 (Apache isn't done yet)
- You have PHP set up and configured in Nginx/Apache (this was written in PHP 8.1 but is likely to work with some past and future versions)
- Your sites in `sites-enabled` are named as `domain.tld.conf`
- Your IP configuration is named `root.conf`
- Your index page is stored in `/var/www/html`

These settings can easily be modified to fit your system in the files, so you don't have to strictly meet these assumptions. Where you are meant to change them, they are pointed out in comments in the code.

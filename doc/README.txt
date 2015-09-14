Requierments
=======================================
On your php server:
sudo apt-get install php5 php5-json php-xml

Instalation
=================================================

1.- Copy webcam directory to /var/www/ on your PHP server
2.- Modify webcam/test.php

	$HOST="YOUR OPENERP IP SERVER"; 
	$PORT="YOUR OPENERP PORT"; 
	$DB="YOUR OPENERP DB"; 
	$USER="YOUR OPENERP USER";
	$PASS="YOUR OPENERP PASSWORD";

3.- Configure your photo_security module to integrate your webcam php page, edit on view/:

	On line 159:
		<iframe src="http://localhost:81/webcam/index.html"

	Change it for your PHP server URL 
     
Issues
=================================================
On Firefox it hangs out, instead use Google Chrome


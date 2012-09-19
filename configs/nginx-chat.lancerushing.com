server {
	root /var/www/webroot;
	index index.html index.htm;

	server_name chat.lancerushing.com;

	location / {
		try_files $uri $uri/ /router;
	}
	
	location /router {
		fastcgi_pass 127.0.0.1:9000;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME "/var/www/router.php";
	}
}


<?php
	define('USER_TYPES', array(
		'admin' => '0',
		'user' => '1',
		'staff' => '2',
	));

	if(env('DB_USERNAME') == 'root')
	{
		define('IMAGE_URL', 'http://127.0.0.1:8000/');
	}else{
		define('IMAGE_URL', 'https://firstpros.net/newspaper/public/');
	}

	define('ONESIGNAL_APP_ID', '9db40abc-b261-4aaf-a923-1ce91f5deaee');
	define('ONESIGNAL_REST_KEY', 'NDc2MmI5NTUtNGE1MS00ZjFlLWIzNDktMzQ5NTZjOWEzNjNj');
?>
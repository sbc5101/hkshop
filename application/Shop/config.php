<?php
	return [
		'session' => [
		    'type'           => '',
		    'auto_start'     => true,
		    'expire'         => 3600,

		],
		'cache'  => [
		    'type'   => 'File',
		    'path'   => CACHE_PATH.'admin/',
		    'prefix' => 'yo_',
		    'expire' => 0,
		],
		
	];
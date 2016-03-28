<?php

return new \Phalcon\Config(array(
	'database' => array(
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'name'     => 'questionnaire',
	),
	'application' => array(
		'controllersDir' => __DIR__ . '/../../app/controllers/',
		'modelsDir'      => __DIR__ . '/../../app/models/',
		'viewsDir'       => __DIR__ . '/../../app/views/',
		'pluginsDir'     => __DIR__ . '/../../app/plugins/',
		'libraryDir'     => __DIR__ . '/../../app/library/',
	),
	'resource' => array(
		'useCDN' => 0,
		'baseUri' => '/'
	),
	'cache' => array(
		'voltCacheDir' => __DIR__ . '/../../cache/volt/',
	),
	'security' => array(
		'protectBackend' => 0,
		'openHttps' => 0
	),
	'models' => array(
		'metadata' => array(
			'adapter' => 'Memory'
		)
	)
));

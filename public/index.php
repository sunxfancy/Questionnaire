<?php

    //setting default time_zone
    ini_set('error_reporting', E_ALL);
    date_default_timezone_set('PRC');
   

try {

    // $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');
    $config = include(__DIR__."/../app/config/config.php");

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir
        )
    )->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
 
	//Setup the database service
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host"     => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname"   => $config->database->name,
            'charset'  => 'UTF8',
        	
        ));
    });

    //Setup the view component
    $di->set('view', function() use($config){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir( $config->application->viewsDir );
        $view->registerEngines(array(
            ".phtml" => 'Phalcon\Mvc\View\Engine\Php',
            ".volt" => 'volt'
        ));
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function() use($config){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($config->resource->baseUri);
        return $url;
    });

    //Start the session the first time when some component request the session service
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    $di->set('elements', function(){
        return new Elements();
    });
    /**
     * Setting up volt
     */
    $di->set('volt', function($view, $di) use($config) {

        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

        $volt->setOptions(array(
            "compiledPath" => $config->cache->voltCacheDir
        ));

        return $volt;
    }, true);
	
	//phalcon Case insesitive routing || url:https://forum.phalconphp.com/discussion/1824/case-insesitive-routing-how-to-
    if (isset($_GET['_url'])) {
    	$_GET['_url'] = strtolower($_GET['_url']);
    }
    
    //setroutes
//     $di->set('router', function ()
//     {
//         require __DIR__.'/../app/config/routes.php';
//         return $router;
//     });

    $usecdn = $config->resource->useCDN;
    $di->set('usecdn',function () use($usecdn)
    {
        return $usecdn;
    });

    // setplugins
    if ($config->security->protectBackend) {
        $di->set("dispatcher",function() use($di)
        {
            $dispatcher    =new Phalcon\Mvc\Dispatcher();
            $eventsManager = $di->getShared("eventsManager");
            $security      = new Security($di);
            $eventsManager->attach('dispatch', $security);

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
    }

    $di->set('flash',function ()
    {
        return new Phalcon\Flash\Session(array(
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info'
        ));
    });

    //cookie
    $di->set("cookies",function()
    {
        $cookies=new Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);
        return $cookies;
    });

    /**
     * If the configuration specify the use of metadata adapter use it or use memory otherwise
     */
    $di->set('modelsMetadata', function() use ($config) {
        if (isset($config->models->metadata)) {
            $metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'.$config->models->metadata->adapter;
            return new $metadataAdapter();
        } else {
            return new \Phalcon\Mvc\Model\Metadata\Memory();
        }
    });
   
 /**
   * setting model caching service
   */
	$di->set('modelsCache' , function() use ($config) {
	//frontend   a day
		$frontCache = new \Phalcon\Cache\Frontend\Data(
		array(
			'lifetime'=>86400
 		));
		$cache = new \Phalcon\Cache\Backend\Memcache(
				$frontCache,
				array(
						"host" => "localhost",
						"port" => "11211"
				)
		);
		return $cache;  
   });
    	

    //Handle the request
    $app = new \Phalcon\Mvc\Application($di);
    
    echo $app->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
} catch(PDOException $e){
	die('数据库连接失败-'.$e->getMessage());
}

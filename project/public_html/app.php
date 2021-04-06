<?php
//var_dump($_SERVER);die();
require_once __DIR__.'/../vendor/autoload.php';

use KCS\Router;
use KCS\Config;
use DI\ContainerBuilder;

$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('../log/app.log', Monolog\Logger::WARNING));

try {
    $config = new Config();
    
    $container = (new ContainerBuilder())->useAutowiring(true)->build();
    $container->set(Config::class, $config);

    $router = new Router($config, $container);
    
    $router->start();

} catch (Exception $exception) {

    http_response_code(400);
    echo "Klaida: " . $exception->getMessage();
    $log->warning($exception->getMessage());
    //$customExceptionHandler->handle($exception); -> echo log..
}
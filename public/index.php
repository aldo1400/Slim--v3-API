<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App([
      'settings' => [
        'displayErrorDetails' => true,
        ]
    ]);

    // RUTA SIMPLE

$app->get('/hello/{nombre}', function (Request $request, Response $response) {
    $nombre=$request->getAttribute('nombre');
    echo "Hola ".$nombre."xdxdxd";
});

//RUTAS CON PARAMETROS OPCIONALES

$app->get("/pruebas1[/{uno}[/{dos}]]",function(Request $request, Response $response ){
    echo $request->getAttribute('uno')." hola desde aqui ".$request->getAttribute('dos');
});

//RUTAS CON RESTRICCIONES

$app->get("/pruebas2/{uno:[a-zA-Z]+}/{dos:[0-9]+}",function(Request $request, Response $response ){
    echo $request->getAttribute('uno')." hola desde aqui ".$request->getAttribute('dos');
});


$app->run();
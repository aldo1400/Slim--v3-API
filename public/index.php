<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App([
      'settings' => [
        'displayErrorDetails' => true,
        ]
    ]);

// MIDDLEWARE

    $middlewareExample = function ($request, $response, $next) {
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        return $response;
    };
// RUTA SIMPLE

$app->get('/hello/{nombre}' ,function (Request $request, Response $response) {
    $nombre=$request->getAttribute('nombre');
    $response->getBody()->write(" hola ,$nombre ");
    return $response;
})->add($middlewareExample);


//RUTAS CON PARAMETROS OPCIONALES

$app->get("/pruebas1[/{uno}[/{dos}]]",function(Request $request, Response $response ){
    echo $request->getAttribute('uno')." hola desde aqui ".$request->getAttribute('dos');
});

//RUTAS CON RESTRICCIONES

$app->get("/pruebas2/{uno:[a-zA-Z]+}/{dos:[0-9]+}",function(Request $request, Response $response ){
    echo $request->getAttribute('uno')." hola desde aqui ".$request->getAttribute('dos');
});

//GRUPO DE RUTAS
// Por ejemplo alumno/crear alumno/editar alumno/eliminar
// use $app was replace for $this in SlimFramework v3

// $app->group('/api',function() use ($app){
//     $app->group('/ejemplo',function() use ($app){
//         $app->get('/hola/{nombre}',function(Request $request,Response $response){
//             echo "Hola ".$request->getAttribute('nombre');
//         });
//         $app->get('/dime-tu-apellido/{apellido}',function(Request $request , Response $response){
//             echo "Tu apellido es:".$request->getAttribute('apellido');
//         });
//     });
// });

$url="/API-SLIM2/public/api/ejemplo/";

// REDIRECCIONES EN RUTAS

$app->group('/api',function() use ($app,$url){
    $app->group('/ejemplo',function() use ($app,$url){
        $app->get('/hola/{nombre}',function(Request $request,Response $response){
            echo "Hola ".$request->getAttribute('nombre');
        });
        $app->get('/dime-tu-apellido/{apellido}',function(Request $request , Response $response){
            echo "Tu apellido es:".$request->getAttribute('apellido');
        });
        $app->get('/mandame-a-hola',function(Request $request,Response $response) use ($app,$url) {
            return $response->withRedirect($url."hola/Victor");
        });
    });
});




$app->run();
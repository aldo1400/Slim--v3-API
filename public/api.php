<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App([
      'settings' => [
        'displayErrorDetails' => true,
        ]
    ]);

$db=new mysqli("localhost","root","","pruebas");

$app->get("/productos",function() use ($db,$app){
    $query=$db->query("SELECT * FROM productos");
    $productos=array();
    while($fila=$query->fetch_assoc()){
        $productos[]=$fila;
    }
    echo json_encode($productos);
});

$app->post("/productos",function(Request $request, Response $response ) use ($db,$app){
    $name=$request->getParam('name');
    $description=$request->getParam('description');   
    $price=$request->getParam('price');

    $query="INSERT INTO productos(name,description,price) VALUES ('$name','$description','$price')";
   
    $insert=$db->query($query);

    if($insert){
        $result=array("STATUS"=>"true","message"=>"Producto creado correctamente");
    }
    else{
        $result=array("STATUS"=>"false","message"=>"Producto no se ha creado");
    }

    echo json_encode($result);
});

$app->put("/productos/{id}",function(Request $request, Response $response ) use ($db,$app){    
    $id=$request->getAttribute('id');
    $name=$request->getParam('name');
    $description=$request->getParam('description');   
    $price=$request->getParam('price');

    $query="UPDATE productos SET name='$name',description='$description',price='$price' WHERE id='$id'";
    
    $update=$db->query($query);
    
    if($update){
        $result=array("STATUS"=>"true","message"=>"Producto se ha actualizado correctamente");
    }
    else{
        $result=array("STATUS"=>"false","message"=>"Producto no se ha actualizado");
    }
    echo json_encode($result);
});

$app->delete("/productos/{id}",function(Request $request,Response $response) use ($db,$app){
    $id=$request->getAttribute('id');
    $query="DELETE FROM productos WHERE id='$id'";
    $delete=$db->query($query);
    if($delete){
        $result=array("STATUS"=>"true","message"=>"Producto se ha borrado correctamente");
    }
    else{
        $result=array("STATUS"=>"false","message"=>"Producto no se ha borrado");
    }
    echo json_encode($result);

});


$app->run();

?>
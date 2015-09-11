<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 11/09/15
 * Time: 12:01 AM
 */

require_once('./Router.php');

$router = new Router();

//var_dump($_REQUEST["data"]);

$post = file_get_contents('php://input');

$json;
try{
    $json = json_decode($post);
}catch(Exception $e){
    $response["head"]["command"] = "unknown";
    $response["data"]["result"] = "request format could not be parsed";
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode($response);
}

$command = $json->head->command;
if(method_exists($router, $command)){
    $response = $router->$command($json->data);
    header('Content-Type: application/json');
    echo $response;
}else{
    $response["head"]["command"] = $command;
    $response["data"]["result"] = "command not recognized as valid command";
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode($response);
}


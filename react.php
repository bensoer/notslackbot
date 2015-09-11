<?php
/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 11/09/15
 * Time: 1:48 AM
 */
/**
 * this file deals with reactions from incoming slack calls
 */

require_once('./Database.php');
require_once('./config.inc');

$post = file_get_contents('php://input');

$json;
try{
    $json = json_decode($post);
}catch(Exception $e){
    //die silently
}


$channel = $json->channel_name;

$triggerWord = $json->trigger_word;

$database = new Database();

$responses = $database->getResponsesToRequest($triggerWord);

$randomNumber = rand(0, count($responses)-1);

$randomResponse = $responses[$randomNumber];

//now call slack to send back the response;

$response["text"] = $randomResponse;

$json_data = json_encode($response);

$post = file_get_contents(SLACKINBOUNDHOOK,null,stream_context_create(array(
    'http' => array(
        'protocol_version' => 1.1,
        'user_agent'       => 'notslackbot',
        'method'           => 'POST',
        'header'           => "Content-type: application/json\r\n".
            "Connection: close\r\n" .
            "Content-length: " . strlen($json_data) . "\r\n",
        'content'          => $json_data,
    ),
)));

if($post){
    http_response_code(200);
}else{
    http_response_code(500);
}

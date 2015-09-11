<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 11/09/15
 * Time: 12:02 AM
 */
require_once('./Database.php');
class Router
{
    private $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function add($data){
        $result = $this->database->insert($data);

        if($result){
            $response["head"]["command"] = "add";
            $response["data"]["request"] = $data->request;
            $response["data"]["response"] = $data->response;
            $response["data"]["result"] = "request and response added";
            http_response_code(200);
            return json_encode($response);
        }else{
            $response["head"]["command"] = "add";
            $response["data"]["result"] = "error adding request and response";
            $response["data"]["error"] = $result;
            http_response_code(500);
            return json_encode($response);
        }
    }

    public function delete($data){
        $result = $this->database->delete($data);

        if($result){
            $response["head"]["command"] = "delete";
            $response["data"]["request"] = $data->request;
            $response["data"]["response"] = $data->response;
            $response["data"]["result"] = "request and response deleted";
            http_response_code(200);
            return json_encode($response);
        }else{
            $response["head"]["command"] = "delete";
            $response["data"]["result"] = "error deleting request and response";
            $response["data"]["error"] = $result;
            http_response_code(500);
            return json_encode($response);
        };
    }

    public function listAll($data){
        $result = $this->database->listAll();



        if($result){

            $matchups = [];
            while($row = mysqli_fetch_assoc($result)){
                $matchups[] = $row;
            }

            $response["head"]["command"] = "listAll";
            $response["data"]["result"] = $matchups;
            http_response_code(200);
            return json_encode($response);
        }else{
            $response["head"]["command"] = "listAll";
            $response["data"]["result"] = "error listing all requests and responses";
            $response["data"]["error"] = $result;
            http_response_code(500);
            return json_encode($response);
        };



    }

    public function test(){
        $response["head"]["command"] = "test";
        $response["data"]["result"] = "this is a test response";
        return json_encode($response);
    }
}
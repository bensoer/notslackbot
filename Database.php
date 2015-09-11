<?php

/**
 * Created by PhpStorm.
 * User: bensoer
 * Date: 11/09/15
 * Time: 12:02 AM
 */
require_once('./config.inc');
class Database
{

    private $con;

    public function __construct(){
        $this->con = mysqli_connect(SERVER, USERNAME, PASSWORD, DB);

        if (!$this->con) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }

    public function insert ($data){
        //INSERT INTO table VALUES ('each value')
        $sql = "INSERT INTO reactions VALUES (null,'" .$data->request ."','" . $data->response . "')";

        $result = mysqli_query($this->con, $sql);

        return $result;
    }

    public function delete ($data){
        $sql = "DELETE FROM reactions WHERE request = '" . $data->request . "' AND response = '". $data->response . "'";
        $result = mysqli_query($this->con, $sql);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function listAll ($data){
        $sql = "SELECT * FROM reactions";
        $result = mysqli_query($this->con, $sql);

        return $result;
    }

    public function getResponsesToRequest($request){
        $sql = "SELECT response FROM reactions WHERE request = '" . $request . "'";

        $result = mysqli_query($this->con, $sql);

        if($result){

            $all = [];
            while($row = mysqli_fetch_assoc($result)){
                $all[] = $row["response"];
            }

            return $all;
        }else{
            return [];
        }
    }
}
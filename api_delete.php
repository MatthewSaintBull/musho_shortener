<?php
header('Access-Control-Allow-Origin: *');


require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB
require 'JWT_ENCODE_DECODE.php';
require 'MONGO_MANAGER.php';

//$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017"); //INIZIALIZZA CONNESSIONE MONGODB
//$bulk = new MongoDB\Driver\BulkWrite;
$manager = new MongoManager();
$manager->getConnection('localhost','27017');

$secret_key = "ThisIsTheSecretKey12ForJWT"; //key segreta per codifica e decodifica token

$postdata = file_get_contents("php://input"); //get json dall'app

$tokenmanager = new JwtAuth;

if (isset($postdata)) { //se il json è valido

    //$request = json_decode($postdata, true); //decode json
   // $token = $request['token']; //prende token passato dall'app <--- implementare https
    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJ1c2VybmFtZSI6InRlc3QiLCJpZF91c2VyIjoxfQ.plpyKnSd4roaYiR65pO_rDZtuE2PV2fvDLoA1yV4a0E";
    //$name = $request['name'];
    $name="Facebook";
    $id_user = $tokenmanager->get_id_user($token);
    $filter = ['id' => $id_user];
    $url = $manager->getDocument('musho.user',$filter);
    if (empty($url[0])) {
        echo "TOKEN_ERROR";
    } else {
        //rimuove elemento
        //$bulk->delete(['id_user' => $id_user, 'name' => $name]);
        //$result = $manager->executeBulkWrite('musho.url', $bulk);
        $result=$manager->deleteDocument('musho.url',['id_user' => $id_user, 'name' => $name]);
    }

}

?>
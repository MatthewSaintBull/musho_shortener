<?php
header('Access-Control-Allow-Origin: *');


require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017"); //INIZIALIZZA CONNESSIONE MONGODB
$bulk = new MongoDB\Driver\BulkWrite;

$secret_key = "ThisIsTheSecretKey12ForJWT"; //key segreta per codifica e decodifica token

$postdata = file_get_contents("php://input"); //get json dall'app

$tokenmanager = new JwtAuth;

if (isset($postdata)) { //se il json è valido

    $request = json_decode($postdata, true); //decode json
    $token = $request['token']; //prende token passato dall'app <--- implementare https
    //$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJ1c2VybmFtZSI6InRlc3QiLCJpZF91c2VyIjoxfQ.plpyKnSd4roaYiR65pO_rDZtuE2PV2fvDLoA1yV4a0E";
    $name = $request['name'];
    $id_user = $tokenmanager->get_id_user($token);
    $filter = ['id' => $id_user];
    $query = new MongoDB\Driver\Query($filter);  //definisce la query col filtro
    $result = $manager->executeQuery("musho.user", $query); //esegue la query sulla collection url del db musho

    $url = $result->toArray();

    if (empty($url)) {
        echo "TOKEN_ERROR";
    } else {
        //rimuove elemento
        $bulk->delete(['id_user' => $id_user, 'name' => $name]);
        $result = $manager->executeBulkWrite('musho.url', $bulk);
    }

}

?>
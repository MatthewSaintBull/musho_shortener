<?php

/*
    API PER IL LOGIN
*/


header('Access-Control-Allow-Origin: *');

require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB
require 'JWT_ENCODE_DECODE.php';
require 'MONGO_MANAGER.php';
$manager = new MongoManager();
$manager->getConnection('localhost', '27017');

$secret_key = "ThisIsTheSecretKey12ForJWT"; //key segreta per codifica e decodifica token
$postdata = file_get_contents("php://input"); //get json dall'app

$tokenmanager = new JwtAuth;
if (isset($postdata)) { //se il json è valido
    $request = json_decode($postdata, true); //decode json
    $username = $request['username']; //prende username passato dall'app <--- implementare https
    $password = $request['password']; //prende password passata dall'app <--- implementare https
    $password = crypt($password, '$2a$09$trythissecretkeyifyouwanttogetthepassword$'); // crypta password
    $filter = ['username' => $username, 'password' => $password]; //filtro per la query mongodb

    $user = $manager->getDocument('musho.user', $filter);
    if (!empty($user)) { //se non è vuoto
        $email = $user[0]->email;
        $id_user = $user[0]->id;
        $token = $tokenmanager->encode($email, $username, $id_user);
        echo $token;
    } else echo "error"; //altrimenti errore

}


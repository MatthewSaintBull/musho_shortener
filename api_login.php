<?php

    /*
        API PER IL LOGIN
    */


	header('Access-Control-Allow-Origin: *');

	
	require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB
	use \Firebase\JWT\JWT; //INCLUDE CLASSE JWT
    require 'JWT_ENCODE_DECODE.php';
	
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017"); //INIZIALIZZA CONNESSIONE MONGODB

	$secret_key = "ThisIsTheSecretKey12ForJWT"; //key segreta per codifica e decodifica token

    $postdata = file_get_contents("php://input"); //get json dall'app
 
	$tokenmanager = new JwtAuth;
	if (isset($postdata)) { //se il json è valido

        $request = json_decode($postdata,true); //decode json
    	$username = $request['username']; //prende username passato dall'app <--- implementare https
    	$password = $request['password']; //prende password passata dall'app <--- implementare https
    	$password = crypt($password,'$2a$09$trythissecretkeyifyouwanttogetthepassword$'); // crypta password
    	$filter = ['username' => $username, 'password'=>$password]; //filtro per la query mongodb
    	$query = new MongoDB\Driver\Query($filter);  //definisce la query col filtro
    	$result = $manager->executeQuery("musho.user", $query); //esegue la query sulla collection user del db musho

    	$user = current($result->toArray()); //risultato della query castato in array 
    	if(!empty($user)){ //se non è vuoto
    		    $email = $user->email; //prendo email dall'utente ottenuto dal db
                //AGGIUNGERE CLASS

				$token=$tokenmanager->encode($email,$username,$user->id_user);
				echo $token;
// 		    	$token = JWT::encode($payload, $secret_key); //genera token contenente il payload e cryptandolo con la key definita prima
//		    	echo $token; //stampa il token
    	}
    	else echo "error"; //altrimenti errore
    	
}
?>

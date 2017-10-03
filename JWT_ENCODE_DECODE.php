<?php


require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT; //INCLUDE CLASSE JWT

Class JwtAuth
{

    private $secret_key = "ThisIsTheSecretKey12ForJWT";


    private function genPayload($email, $username, $user_id)
    { //dati i parametri genera il payload da dare al token generator
        $payload = array(
            "email" => $email,
            "username" => $username,
            "id_user" => $user_id
        );
        return $payload;
    }

    //ENCODING

    private function genToken($payload)
    { //dato il payload genererà il token
        $token = JWT::encode($payload, $this->secret_key);
        return $token;
    }


    public function encode($email, $username, $user_id)
    { //funzione utilizzabile dall'utente
        $payload = $this->genPayload($email, $username, $user_id);
        $token = $this->genToken($payload);
        return $token;
    }


    //DECODING

    private function decodeToken($token)
    { //ottiene stringa contenente tutti i parametri dal token. AGGIUNGERE CONTROLLO SUL DECODE DEL TOKEN
        $fromToken = JWT::decode($token, $this->secret_key, array('HS256')); //decodifica il token
        $params = (array)$fromToken; //genera l'array dalla stringa ottenuta dal token decodificato
        return $params;
    }

    public function get_id_user($token)
    {
        $params = $this->decodeToken($token);
        return $params['id_user'];
    }

    public function get_username($token)
    {
        $params = $this->decodeToken($token);
        return $params['username'];
    }

    public function get_email($token)
    {
        $params = $this->decodeToken($token);
        return $params['email'];
    }
}


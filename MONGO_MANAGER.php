<?php

require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB


Class MongoManager {
    private $manager = null;
    private $bulk = null;

    private function connect($address,$port){
        $this->manager = new MongoDB\Driver\Manager("mongodb://".$address.":".$port);
        $this->bulk = new MongoDB\Driver\BulkWrite;
    }

    public function getConnection($address,$port){
        try{
            $this->connect($address,$port);
            return true;
        }catch (Exception $e){
            return false;
        }
    }

    private function select($db,$filter){
        if($filter == false){
            $query = new MongoDB\Driver\Query();
        } else {
            $query = new MongoDB\Driver\Query($filter);
        }
        $result = $this->manager->executeQuery($db,$query); //esegue la query sulla collection user del db musho
        return $result;
    }
//creare funzione controllo se document pieno o vuoto
    public function getDocument($db,$filter){
        $document = $this->select($db,$filter)->toArray();
        //aggiungere return false se non ci sono elementi
        return $document;
    }

    private function insert($db,$params){
        try{
            $this->bulk->insert($params);
            $this->manager->executeBulkWrite($db,$bulk);
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function addDocument($db,$params){
        return $this->insert($db,$params);
    }

    private function delete($db,$params){
        try{
            $this->bulk->delete([$params]);
            $result = $this->manager->executeBulkWrite($db, $this->bulk);
            return true;
        }catch (Exception $e){
            return false;
        }
    }

    public function deleteDocument($db,$params){
        return $this->delete($db,$params);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: sherl
 * Date: 02/10/17
 * Time: 12:03
 */

class Shorter extends MongoManager
{
    private function existsHash($item)
    { //verifica esistenza hash
        $filter = ['id' => $item]; //filtro da applicare alla query
        $document = $this->getDocument('musho.url', $filter);
        if (empty($document)) {
            return false;
        } else {
            return true;
        }
    }

    public function short($address,$port)
    {
        $this->getConnection($address,$port);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //set di caratteri disponibili alla generazione di un hash
        do {
            $newHash = substr(str_shuffle($chars), 0, 6); //crea un nuovo hash random di 6 caratteri
        } while ($this->existsHash($newHash) != false); //verifica che non esista già l'hash
        return $newHash; //alla fine del ciclo ritorna l'hash
    }
}

?>
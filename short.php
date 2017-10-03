 <?php 
	/*function existsHash($item){ //verifica esistenza hash

		require_once 'vendor/autoload.php'; //include classe mongodb

		$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017"); //definisce nuova connessione al db <-- controllare se possibile fare una sola connessione
		$filter = ['id' => $item]; //filtro da applicare alla query
    	$query = new MongoDB\Driver\Query($filter);  //definisce la query con il filtro
    	$result = $manager->executeQuery("musho.url", $query); //esegue la query sulla collection url del db musho

    	$url = current($result->toArray()); //esegue un cast del risultato in un array
    	if(empty($url)){ //se l'array è vuoto allora l'hash è libero
    		return false; //ritorna false e termina il ciclo
		}
		else return true; //altrimenti l'hash esiste già e ricomincia il ciclo
	}

	function short($url){ //funzione principale
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //set di caratteri disponibili alla generazione di un hash
		do{
			$newHash = substr( str_shuffle( $chars ), 0, 6 ); //crea un nuovo hash random di 6 caratteri
		} while (existsHash($newHash) != false); //verifica che non esista già l'hash
		return $newHash; //alla fine del ciclo ritorna l'hash
	}*/


	require 'SHORTER.php';

	$shorter = new Shorter;

?>



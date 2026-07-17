<?php
// rendo accessibile questo endpoint a tutti (CORS)
header("Access-Control-Allow-Origin: *");
// definisco il metodo consentito per la request (CORS)
header("Access-Control-Allow-Methods: POST");
// definisco la validità massima dell'autorizzazione in secondi (CORS)
header("Access-Control-Max-Age: 3600");
// definisco i tipi di header consentiti (CORS)
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// specifico il formato della risposta (JSON)
header("Content-Type: application/json; charset=UTF-8");
 
// includo le classi per la gestione dei dati
include_once '../dataMgr/Database.php';
include_once '../dataMgr/Tavolo.php';

// creo una connessione al DBMS
$database = new Database();
$db = $database->getConnection();
 
// creo un'istanza di Prodotto
$tavolo = new Tavolo($db);

// leggo i dati nel body della request (metodo POST)
$data = json_decode(file_get_contents("php://input"));
// controllo che i dati ci siano...
if(
    !empty($data->persone)
) {
 
    // inserisco i valori nelle variabili d'istanza dell'oggetto $tavolo
    $tavolo->setEsterno($data->esterno);
    $tavolo->setPersone($data->persone);
 
	// invoco il metodo create() che crea un nuovo prodotto
    if($tavolo->create()){ // se va a buon fine...
        http_response_code(201); // response code 201 = created
 
        // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
        echo json_encode(array("message" => "tavolo was created"));
    }
    else{ // se la creazione è fallita...
        http_response_code(503); // response code 503 = service unavailable
 
        // creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
        echo json_encode(array("message" => "Unable to create tavolo"));
    }
}
else { // se i dati sono incompleti
    http_response_code(400); // response code 400 = bad request
	// creo un oggetto JSON costituito dalla coppia message: testo-del-messaggio
    // uso l’operatore ternario con empty() per evitare l’errore sulla stampa di un valore inesistente
    echo json_encode(array("message" => "Unable to create tavolo. Data is incomplete:"
		 . " persone=" . (empty($data->persone) ? "null" : $data->persone) . " esterno=" . (empty($data->esterno) ? "null" : $data->esterno) . " disponibilita=" . (empty($data->disponibilita) ? "null" : $data->disponibilita)));
}
?>
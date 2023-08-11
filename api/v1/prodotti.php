<?php

// Includi i file necessari per la connessione al database e l'oggetto Prodotto
include_once '../../config/database.php';
include_once '../../objects/Prodotto.php';

// Ottieni il metodo della richiesta HTTP (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Inizializza l'ID a 0
$id = 0;

// Verifica se è presente il parametro 'request' nella richiesta
if(isset($_REQUEST['request'])){
    // Filtra e sanitizza l'ID dalla richiesta
    $id = filter_var($_REQUEST['request'], FILTER_SANITIZE_NUMBER_INT);
}

// Gestisci le diverse casistiche in base al metodo della richiesta
switch ($method) {
    case 'GET':
        // Imposta gli header per consentire l'accesso da qualsiasi dominio e specifica il tipo di contenuto JSON
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Se è stato specificato un ID, esegui azioni specifiche
        if ($id > 0) {
            // ** Inserisci qui la logica per gestire una richiesta GET con ID specifico **
        } else {
            // Crea un oggetto Prodotto utilizzando la connessione al database
            $prodotto = new Prodotto($db);

            // Esegui una query per leggere i dati dei prodotti dal database
            $stmt = $prodotto->leggi();

            // Ottieni il numero di righe restituite dalla query
            $num = $stmt->rowCount();
        }

        // Verifica se sono stati trovati prodotti o meno
        if ($num == 0) {
            // Nessun prodotto trovato, restituisci un messaggio JSON
            echo json_encode(
                array("messaggio" => "Nessun prodotto trovato.")
            );
        } else {
            // Inizializza un array per memorizzare i dati dei prodotti
            $products_arr = array();
            $products_arr["records"] = array();

            // Itera attraverso i risultati della query e estrai i dati dei prodotti
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                // Crea un array con i dati del prodotto corrente
                $product_item = array(
                    "id" => $id,
                    "nome" => $nome,
                    "descrizione" => html_entity_decode($descrizione),
                    "prezzo" => $prezzo,
                    "categoria_id" => $categoria_id,
                    "categoria_nome" => $categoria_nome
                );

                // Aggiungi l'array del prodotto all'array principale
                array_push($products_arr["records"], $product_item);
            }

            // Restituisci i dati dei prodotti in formato JSON
            echo json_encode($products_arr);
        }

        break;
}

?>

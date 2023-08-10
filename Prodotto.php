<?php

class Prodotto {
    // Connessione al database e nome della tabella
    private $conn; // Oggetto di connessione al database
    private $nome_tabella = "prodotti"; // Nome della tabella nel database
    
    // Proprietà dell'oggetto
    public $id; // ID del prodotto
    public $nome; // Nome del prodotto
    public $descrizione; // Descrizione del prodotto
    public $prezzo; // Prezzo del prodotto
    public $categoria_id; // ID della categoria del prodotto
    public $categoria_nome; // Nome della categoria del prodotto
    public $data_insert; // Data di inserimento del prodotto
    
    // Costruttore dell'oggetto, riceve l'oggetto di connessione al database
    public function __construct($db){
        $this->conn = $db;
    }
    
    // Metodo per leggere tutti i prodotti dal database
    function leggi(){
        $sql = "SELECT c.nome as categoria_nome, p.id, p.nome, p.descrizione, p.prezzo, p.categoria_id, p.data_insert
        FROM " . $this->nome_tabella . " p
        INNER JOIN categorie c ON p.categoria_id = c.id
        ORDER BY p.data_insert DESC"; // Query SQL per ottenere i prodotti con le informazioni sulla categoria
        $stmt = $this->conn->prepare($sql); // Preparazione della query
        $stmt->execute(); // Esecuzione della query
        return $stmt; // Restituzione del risultato della query
    }
    
    // Metodo per leggere un singolo prodotto dal database
    function leggiProdotto(){
        $sql = "SELECT c.nome as categoria_nome, p.id, p.nome, p.descrizione, p.prezzo, p.categoria_id, p.data_insert
        FROM " . $this->nome_tabella . " p
        INNER JOIN categorie c
        ON p.categoria_id = c.id
        WHERE
        p.id = ?
        LIMIT
        0,1"; // Query SQL per ottenere un prodotto specifico tramite ID
        $stmt = $this->conn->prepare( $sql ); // Preparazione della query
        $stmt->bindParam(1, $this->id); // Collegamento del parametro ID
        $stmt->execute(); // Esecuzione della query
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Estrazione della riga risultante
        $this->nome = $row['nome']; // Assegnazione delle proprietà dell'oggetto
        $this->prezzo = $row['prezzo'];
        $this->descrizione = $row['descrizione'];
        $this->categoria_id = $row['categoria_id'];
        $this->categoria_nome = $row['categoria_nome'];
    }
}

?>

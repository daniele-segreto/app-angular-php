<?php

class Categoria {
    // Definizione delle proprietà dell'oggetto Categoria
    
    private $conn; // Oggetto di connessione al database
    private $table_name = "categorie"; // Nome della tabella nel database
    
    public $id; // ID della categoria
    public $nome; // Nome della categoria
    public $descrizione; // Descrizione della categoria
    public $data_insert; // Data di inserimento della categoria
    
    // Costruttore dell'oggetto Categoria
    public function __construct($db){
        $this->conn = $db; // Inizializzazione della connessione al database
    }
    
    // Metodo per leggere tutte le categorie dal database
    public function readAll(){
        // Query per ottenere tutte le categorie
        $sql = "SELECT id, nome, descrizione
        FROM " . $this->table_name . "
        ORDER BY nome";
        $stmt = $this->conn->prepare( $sql ); // Preparazione della query
        $stmt->execute(); // Esecuzione della query
        return $stmt; // Restituzione del risultato della query
    }
}

?>
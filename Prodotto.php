<?php

class Prodotto {
    // Definizione delle proprietà dell'oggetto Prodotto
    private $conn; // Oggetto di connessione al database
    private $nome_tabella = "prodotti"; // Nome della tabella nel database
    
    public $id; // ID del prodotto
    public $nome; // Nome del prodotto
    public $descrizione; // Descrizione del prodotto
    public $prezzo; // Prezzo del prodotto
    public $categoria_id; // ID della categoria del prodotto
    public $categoria_nome; // Nome della categoria del prodotto
    public $data_insert; // Data di inserimento del prodotto
    
    // Costruttore dell'oggetto Prodotto
    public function __construct($db){
        $this->conn = $db; // Inizializzazione della connessione al database
    }
    
    // Metodo per leggere tutti i prodotti dal database
    function leggi(){
        // Query per ottenere tutti i prodotti con le informazioni sulla categoria
        $sql = "SELECT c.nome as categoria_nome, p.id, p.nome, p.descrizione, p.prezzo, p.categoria_id, p.data_insert
        FROM " . $this->nome_tabella . " p
        INNER JOIN categorie c ON p.categoria_id = c.id
        ORDER BY p.data_insert DESC";
        $stmt = $this->conn->prepare($sql); // Preparazione della query
        $stmt->execute(); // Esecuzione della query
        return $stmt; // Restituzione del risultato della query
    }
    
    // Metodo per leggere un singolo prodotto dal database
    function leggiProdotto(){
        // Query per ottenere un prodotto specifico tramite ID
        $sql = "SELECT c.nome as categoria_nome, p.id, p.nome, p.descrizione, p.prezzo, p.categoria_id, p.data_insert
        FROM " . $this->nome_tabella . " p
        INNER JOIN categorie c
        ON p.categoria_id = c.id
        WHERE
        p.id = ?
        LIMIT
        0,1";
        $stmt = $this->conn->prepare( $sql ); // Preparazione della query
        $stmt->bindParam(1, $this->id); // Collegamento del parametro ID
        $stmt->execute(); // Esecuzione della query
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Estrazione della riga risultante
        // Assegnazione delle proprietà dell'oggetto dai dati del database
        $this->nome = $row['nome'];
        $this->prezzo = $row['prezzo'];
        $this->descrizione = $row['descrizione'];
        $this->categoria_id = $row['categoria_id'];
        $this->categoria_nome = $row['categoria_nome'];
    }
    
    // Metodo per creare un nuovo prodotto nel database
    function crea(){
        $sql = "INSERT INTO " . $this->nome_tabella . "
        SET nome=:nome, prezzo=:prezzo, descrizione=:descrizione, categoria_id=:categoria_id, data_insert=:data_insert";
        $stmt = $this->conn->prepare($sql); // Preparazione della query
        // Pulizia e collegamento dei parametri
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->prezzo = htmlspecialchars(strip_tags($this->prezzo));
        $this->descrizione = htmlspecialchars(strip_tags($this->descrizione));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->data_insert = htmlspecialchars(strip_tags($this->data_insert));
        // Collegamento dei parametri
        $stmt->bindParam(":nome", $this->nome,PDO::PARAM_STR);
        $stmt->bindParam(":prezzo", $this->prezzo,PDO::PARAM_STR);
        $stmt->bindParam(":descrizione", $this->descrizione,PDO::PARAM_STR);
        $stmt->bindParam(":categoria_id", $this->categoria_id,PDO::PARAM_INT);
        $stmt->bindParam(":data_insert", $this->data_insert,PDO::PARAM_STR);
        if($stmt->execute()){
            return true; // Restituzione true se l'inserimento ha avuto successo
        }
        return false; // Restituzione false in caso di errore
    }
    
    // Metodo per aggiornare un prodotto nel database
    function aggiorna(){
        $sql = "UPDATE
        " . $this->nome_tabella . "
        SET
        nome = :nome,
        prezzo = :prezzo,
        descrizione = :descrizione,
        categoria_id = :categoria_id
        WHERE
        id = :id";
        $stmt = $this->conn->prepare($sql); // Preparazione della query
        // Pulizia e collegamento dei parametri
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->prezzo = htmlspecialchars(strip_tags($this->prezzo));
        $this->descrizione = htmlspecialchars(strip_tags($this->descrizione));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Collegamento dei parametri
        $stmt->bindParam(':nome', $this->nome,PDO::PARAM_STR);
        $stmt->bindParam(':prezzo', $this->prezzo,PDO::PARAM_STR);
        $stmt->bindParam(':descrizione', $this->descrizione,PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $this->categoria_id,PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id,PDO::PARAM_INT);
        if($stmt->execute()){
            return true; // Restituzione true se l'aggiornamento ha avuto successo
        }
        return false; // Restituzione false in caso di errore
    }
    
    // Metodo per eliminare un prodotto dal database
    function delete(){
        $sql = "DELETE FROM " . $this->nome_tabella . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql); // Preparazione della query
        $this->id = filter_var($this->id,FILTER_SANITIZE_NUMBER_INT); // Pulizia dell'ID
        $stmt->bindParam(1, $this->id,PDO::PARAM_INT); // Collegamento del parametro ID
        if($stmt->execute()){
            return true; // Restituzione true se l'eliminazione ha avuto successo
        }
        return false; // Restituzione false in caso di errore
    }
    
}

?>

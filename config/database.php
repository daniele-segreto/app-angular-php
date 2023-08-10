<?php

// Definizione della classe "Database"
class Database {
    // Attributi privati per le credenziali del database
    private $host = "localhost"; // Indirizzo del server del database
    private $db_name = "angularphp"; // Nome del database
    private $username = "root"; // Nome utente del database
    private $password = ""; // Password del database
    public $conn; // Oggetto connessione al database

    // Metodo per ottenere la connessione al database
    public function getConnection(){
        $this->conn = null; // Inizializzazione dell'oggetto connessione

        try{
            // Creazione di un nuovo oggetto PDO per la connessione al database
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Impostazione del set di caratteri UTF-8 per la connessione
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception){
            // Gestione delle eccezioni nel caso di errore di connessione
            echo "Errore di connessione: " . $exception->getMessage();
        }

        // Restituzione dell'oggetto connessione
        return $this->conn;
    }
}

?>

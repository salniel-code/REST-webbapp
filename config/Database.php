<?php
// Kod av Sally Nielsen
include("config.php");
// Klass för att koppla till databasen
class Database
{
    // Inställningar för db
    private $host = "redacted";
    private $user = "redacted";
    private $pass = "redacted";
    private $db = "redacted";
    private $connection;


    // Kopplar till db
    protected function connect()
    {

        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Om anslutningen misslyckas -
        if ($this->connection->connect_errno > 0) {
            echo "Anslutning misslyckades: " . $this->connection->connect_error;
            exit();
        } else {
            return $this->connection;
        }
        
    }
    
}

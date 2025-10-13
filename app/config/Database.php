<?php

class Database{

    private $host = "localhost";
    private $db_name = "rs_poljoprivreda";
    private $username = "root";
    private $password = "";
    private $conn;

    //$host i slicno je atribut objekta, a bez $ je pristup svojstu objekta.



    public function connect()
    {
        $this->conn = null; //Najbolja praksa, da se ne bi desilo nesto nezeljeno. This je incijator varijabli objekta a ne lokalnih parametara.
        
        try {
        $this->conn = new PDO ("mysql:host=" . $this->host . ";dbname=". $this->db_name,
                               $this->username, 
                               $this->password 
                              );
           
        echo "Konekcija uspostavljena.";}
        catch (PDOException $e) 
        {
            echo "Konekcija nije uspostavljena" . $e->getMessage();
        }

        return $this->conn;

    }
}

?>



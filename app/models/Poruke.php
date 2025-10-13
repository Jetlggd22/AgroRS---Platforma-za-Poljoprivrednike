<?php

class Poruka
{
    private $conn;
    private $table = "poruke";

    private $posiljaoc_ID;
    private $primaoc_ID;
    private $sadrzaj;
    private $vrijeme_slanja;

    public function __construct ($db)
    {
        $this->conn = $db;
    }

    public function ViewAllMessages()
    {
        try
        {
            $query = " SELECT * FROM " . $this->table . " ORDER BY Vrijeme_Slanja desc ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log("Error." . $e->getMessage());
            return false;
        }
    }

    public function ViewAllReceivedMessages()
    {
        try
        {
            $query = "  SELECT * FROM " . $this->table . " WHERE Primaoc_ID = :primaoc_ID ORDER BY Vrijeme_Slanja desc ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":primaoc_ID", $this->primaoc_ID);
            $stmt->execute();
            return $stmt-> fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log("Nemate poruka!" . $e->getMessage());
            return false;
        }

    }

    public function ViewAllSentMessages()
    {
        try
        {
            $query = " SELECT * FROM " . $this->table .  " WHERE Posiljaoc_ID = :posiljaoc_id ORDER BY Vrijeme_Slanja desc ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":posiljaoc_id",$this->posiljaoc_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log("Nemate poslanih poruka!" . $e->getMessage());
            return false;
        }

    }

    public function SendMessage()
    {
        try
        {
            $query = " INSERT INTO " . $this->table . " SET Primaoc_ID = :primaoc_id, Posiljaoc_ID = :posiljaoc_id, Sadrzaj = :sadrzaj, Vrijeme_Slanja = NOW() ";
            $stmt = $this->conn->prepare($query);
            $this->sadrzaj = htmlspecialchars(strip_tags($this->sadrzaj));
            $stmt->bindParam(":primaoc_id", $this->primaoc_id);
            $stmt->bindParam(":posiljaoc_id", $this->posiljaoc_id);
            $stmt->bindParam(":sadrzaj", $this->sadrzaj);
            



            if($stmt->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(PDOException $e)
        {
            error_log("Poruku nije moguce poslati. Error." . $e->getMessage());
            return false;
        }

    }

    public function DeleteMessage()
    {
        try
        {
            $query = " DELETE FROM " . $this->table . " WHERE ID = :id ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log("Greska pri prisanju poruke" . $e->getMessage());
            return false;
        }
    }




}





?>
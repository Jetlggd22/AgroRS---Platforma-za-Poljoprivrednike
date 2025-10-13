            <?php

            class Korisnik
            {
                private $conn;
                private $table = "korisnici";

                public $id;
                public $ime;
                public $prezime;
                public $email;
                public $lozinka;
                public $telefon;
                public $datum_registracije;
                public $adresa;


                public function __construct($db)
                {
                    $this->conn = $db;
                
                }

                public function EmailExists()
                {
                    try{
                            $query = " SELECT ID FROM " . $this->table . " WHERE Email = :email ";
                            $stmt = $this->conn->prepare($query);
                            $this->email = htmlspecialchars(strip_tags($this->email));
                            $stmt->bindParam(":email", $this->email);
                            $stmt->execute();

                            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;

            
                    }
                    catch (PDOException $e)
                    {
                        error_log("Korisnik sa ovim mejlom vec postoji " . $e->getMessage());
                        return false;

                    }
                }

                public function CreateUser()
                {
                    try{
                            if($this->EmailExists())
                            {
                                throw new Exception("Korisnik sa ovim mejlom vec postoji.");
                            
                            }

                            $query = " INSERT INTO " . $this->table . " SET  Ime = :ime, Prezime = :prezime, Email = :email, Lozinka = :lozinka, Telefon = :telefon, Adresa = :adresa, Datum_Registracije = NOW() ";
                            $stmt = $this->conn->prepare($query);

                            $this->ime = htmlspecialchars(strip_tags($this->ime));
                            $this->prezime = htmlspecialchars(strip_tags($this->prezime));
                            $this->email = htmlspecialchars(strip_tags($this->email));
                            $this->telefon = htmlspecialchars(strip_tags($this->telefon));
                            $this->adresa = htmlspecialchars(strip_tags($this->adresa));

                            $this->lozinka = password_hash($this->lozinka, PASSWORD_DEFAULT);

                            $stmt->bindParam(":ime", $this->ime);
                            $stmt->bindParam(":prezime",$this->prezime);
                            $stmt->bindParam(":email",$this->email);
                            $stmt->bindParam(":lozinka",$this->lozinka);
                            $stmt->bindParam(":telefon",$this->telefon);
                            $stmt->bindParam(":adresa",$this->adresa);

                            if($stmt->execute())
                            {
                                return true;
                            }
                            return false;
                    }

                    catch(PDOException $e)
                    {
                        error_log("Greska pri registraciji." . $e->getMessage());
                        return false;
                    }
                }

                public function FindUserByEmail()
                {
                    try
                    {
                        $query = " SELECT * FROM " . $this->table . " WHERE Email = :email "; 
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(":email", $this->email);
                        $stmt->execute();
                        return $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    catch (PDOException $e)
                    {
                        error_log("Korisnik ne postoji ili je greska" . $e->getMessage());
                         return false;
                    }
                }

                public function Login($entered_password)
                {
            
                    $user = $this->FindUserByEmail();
                    
                        if($user && password_verify($entered_password, $user['Lozinka']))
                        {   
                            unset($user['Lozinka']); //da vrati korisnika bez lozinke
                            return $user;
                        }
                        else
                        {
                            return false;
                        }
                }
                    

                

                public function UpdateUser()
                {
                    try
                    {
                        $query = " UPDATE " . $this->table . " SET  Ime = :ime, Prezime = :prezime, Telefon = :telefon, Adresa = :adresa WHERE ID = :id ";
                        $stmt = $this->conn->prepare($query);
                        
                        $this->ime = htmlspecialchars(strip_tags($this->ime));
                        $this->prezime = htmlspecialchars(strip_tags($this->prezime));
                        $this->telefon = htmlspecialchars(strip_tags($this->telefon));
                        $this->adresa = htmlspecialchars(strip_tags($this->adresa));
                        
                        $stmt->bindParam(":ime", $this->ime);
                        $stmt->bindParam(":prezime", $this->prezime);
                        $stmt->bindParam(":telefon", $this->telefon);
                        $stmt->bindParam(":adresa", $this->adresa);
                        $stmt->bindParam(":id", $this->id);
                        
                        return $stmt->execute();
                    }
                    catch (PDOException $e)
                    {
                        error_log(" Greska pri azuriranju " . $e->getMessage());
                    }
                }


                public function DeleteUser()
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
                        error_log(" Greska pri brisanju " . $e->getMessage());
                        return false;
                    }
                }

                public function UpdatePassword()
                {
                    try
                    {
                        $query = " UPDATE " . $this->table . " SET Lozinka = :lozinka WHERE ID = :id ";
                        $stmt = $this->conn->prepare($query);
                        $this->lozinka = password_hash($this->lozinka,PASSWORD_DEFAULT);
                        $stmt->bindParam(":lozinka", $this->lozinka);
                        $stmt->bindParam(":id", $this->id);
                        return $stmt->execute();
                    }
                    catch(PDOException $e)
                    {
                        error_log("Greska pri promjeni lozinke " . $e->getMessage());
                        return false;
                    }
                }
            


            }       



            ?>
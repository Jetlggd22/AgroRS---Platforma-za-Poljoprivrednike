        <?php

        class Proizvod
        {
            private $conn;
            private $table = "Proizvodi";

            public $id;
            public $naziv;
            public $opis;
            public $cijena;
            public $slika;
            public $kategorija;
            public $datum_objave;
            public  $korisnik_proizvod;


            public function __construct($db)
            {
                $this->conn = $db;
            }

            public function CreateProduct()
            {
                try{
                
                $query = " INSERT INTO " . $this->table . "(Naziv,Opis,Cijena,Datum_Objave,Kategorija_ID,Korisnik_ID) VALUES (:naziv,:opis,:cijena,NOW(),:kategorija,:korisnik_proizvod) ";

                $stmt = $this->conn->prepare($query);

                $this->naziv = htmlspecialchars(strip_tags($this->naziv));
                $this->opis = htmlspecialchars(strip_tags($this->opis));
                $this->cijena = htmlspecialchars(strip_tags($this->cijena));
                $this->kategorija = htmlspecialchars(strip_tags($this->kategorija));
                $this->korisnik_proizvod = htmlspecialchars(strip_tags($this->korisnik_proizvod));
         
                $stmt->bindParam(":naziv", $this->naziv);
                $stmt->bindParam(":opis", $this->opis);
                $stmt->bindParam(":cijena", $this->cijena);
                $stmt->bindParam(":kategorija", $this->kategorija);
                $stmt->bindParam(":korisnik_proizvod", $this->korisnik_proizvod);
                

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
                error_log("greska!" . $e->getMessage());
                return false;
            }
        }


        public function ReadAllProducts()
        {
            try {
                
                    $query = " SELECT * FROM " . $this->table . " ORDER BY Datum_Objave DESC ";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute();
                    return $stmt->fetchALL(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e)
            {
                error_log("Greska pri ucitavanju: " . $e->getMessage());
                return array();
            }

        }


        public function ReadOneProduct()
        {
            try {
                    $query = " SELECT * FROM " . $this->table . " WHERE ID = :id LIMIT 0,1";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(":id", $this->id);
                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            catch(PDOException $e)
            {
                error_log("Greska pri ucitavanju: " . $e->getMessage());
                return array();
            }
        }


        public function DeleteProduct()
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
                error_log("Greska pri brisanju: " . $e->getMessage());
                return false;        
            }
        }

        public function UpdateProduct()
        {
            try{
                $query = "UPDATE " . $this->table . " SET Naziv = :naziv, Opis = :opis, Cijena = :cijena, Kategorija_ID = :kategorija, Datum_Objave = NOW() WHERE ID = :id";
                $stmt = $this->conn->prepare($query);
                
                $this->naziv = htmlspecialchars(strip_tags($this->naziv));
                $this->opis = htmlspecialchars(strip_tags($this->opis));
                $this->cijena = htmlspecialchars(strip_tags($this->cijena));
                $this->kategorija = htmlspecialchars(strip_tags($this->kategorija));
                
                $stmt->bindParam(":naziv", $this->naziv);
                $stmt->bindParam(":id", $this->id);
                $stmt->bindParam(":opis", $this->opis);
                $stmt->bindParam(":cijena", $this->cijena);
                $stmt->bindParam(":kategorija", $this->kategorija);
      

            return $stmt->execute();
            
            }
            catch (PDOException $e)
            {
                error_log("Greska pri azuriranju: " . $e->getMessage());
                return false;

            }
        }



        public function SearchProduct($search_input)
        {
            try
            {
            
            $query = "SELECT * FROM " . $this->table . " WHERE Naziv LIKE ? OR Opis LIKE ? OR Kategorija_ID LIKE ? ORDER BY Datum_Objave DESC";
            $stmt = $this->conn->prepare($query);
            
            $search_input = htmlspecialchars(strip_tags($search_input));
            $search_input = "%{$search_input}%";

            $stmt->bindParam(1, $search_input);
            $stmt->bindParam(2, $search_input);
            $stmt->bindParam(3, $search_input);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }
            catch (PDOException $e)
            {
                error_log("Greska pri pretrazi: " . $e->getMessage());
                return false;

            }







        }





        }


        ?>
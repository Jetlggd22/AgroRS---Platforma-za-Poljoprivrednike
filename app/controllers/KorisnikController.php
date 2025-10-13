    <?php
    require_once __DIR__ . "../../models/Korisnik.php";

    class KorisnikController
    {
        private $model;

        public function __construct($db)
        {
            $this->model = new Korisnik($db);
        }

        public function NadjiKorisnikaPoEmailu($email)
        {
            $this->model->email = $email;
            $korisnik = $this->model->FindUserByEmail();
            if($korisnik)
            {
                return $korisnik;
            }
            else
            {
                return "Korisnik nije pronadjen!";
            }
        }

        public function KreirajKorisnika($ime,$prezime,$email,$lozinka,$telefon,$adresa)
        {
            $this->model->ime = $ime;
            $this->model->prezime = $prezime;
            $this->model->telefon = $telefon;
            $this->model->email = $email;
            $this->model->lozinka = $lozinka;
            $this->model->adresa = $adresa;
            

            $korisnik = $this->model->CreateUser();
            if($korisnik)
            {
                return true;
            }
            else
            {
                return false;
            }

        }


        public function Prijava($email,$lozinka)
        {
            $this->model->email = $email;
            $korisnik = $this->model->Login($lozinka);

            if($korisnik)
            {
                return $korisnik ;
            }
            else
            {
                return false;   
            }
        }


        public function AzuriranjeProfila($ime,$prezime,$adresa,$telefon,$id)
        {
            $this->model->ime = $ime;
            $this->model->prezime = $prezime;
            $this->model->adresa = $adresa;
            $this->model->telefon = $telefon;
            $this->model->id = $id;

            if($this->model->UpdateUser())
            {
                return "Azuriranje je uspjesno.";
            }
            else
            {
                return "Azuriranje nije uspjelo.";
            }

        }

        public function ObrisiProfil($id)
        {
            $this->model->id = $id;
            if($this->model->DeleteUser())
            {
                return "Brisanje je uspjesno.";
            }
            else
            {
                return "Greska pri brisanju";
            }
        }

        public function AzuriranjeLozinke($lozinka,$id)
        {
            $this->model->lozinka = $lozinka;
            $this->model->id = $id;
            if($this->model->UpdatePassword())
            {
                return "Lozinka je uspjesno promijenjena.";
            }
            else
            {
                return "Greska pri azuriranju.";
            }
        }
    }



    ?>
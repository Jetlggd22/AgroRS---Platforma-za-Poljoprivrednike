    <?php
    require_once __DIR__ . "/../../models/Proizvod.php";

    class ProizvodController
    {
        private $model;

        public function __construct($db)
        {
            $this->model = new Proizvod($db);
        }

        public function UnesiProizvod($naziv,$opis,$cijena,$kategorija,$korisnik_proizvod)
        {
            $this->model->naziv = $naziv;
            $this->model->opis = $opis;
            $this->model->cijena = $cijena;
            $this->model->kategorija = $kategorija;
            $this->model->korisnik_proizvod = $korisnik_proizvod;
            
            if($this->model->CreateProduct())
            {
                return "Proizvod je objavljen.";
            }
            else
            {
                return "Greska prilikom objave";
            }
        
        }

        public function CitajSveProizvode()
        {
            $proizvodi = $this->model->ReadAllProducts();

            if(!empty($proizvodi))
            {
                return $proizvodi;
            }
            else
            {
                return "Nema proizvoda!";
            }

        }

        public function BrisanjeProizvoda($id)
        {
            $this->model->id = $id;

            if($this->model->DeleteProduct())
            {
                return "Brisanje uspjesno.";
            }
            else
            {
                return "Greska prilikom brisanja";
            }
        }


        public function Pretraga($trazena_vrijednost)
        {
            $rezultat = $this->model->SearchProduct($trazena_vrijednost);

            if(!empty($rezultat))
            {
                return $rezultat;
            }
            else
            {
                return "Taj proizvod nije pronadjen.";          
            }
        }

        public function Azuriranje($id,$naziv,$opis,$cijena,$kategorija)
        {
            $this->model->id = $id;
            $this->model->naziv = $naziv;
            $this->model->opis = $opis;
            $this->model->cijena = $cijena;
            $this->model->kategorija = $kategorija;


            if($this->model->UpdateProduct())
            {
                return "Azuriranje je uspjesno.";
            }
            else
            {
                return "Greska pri azuriranju.";
            }

        }





    }






    ?>
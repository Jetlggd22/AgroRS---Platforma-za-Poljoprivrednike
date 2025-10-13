<?php
require_once __DIR__ . "/../../models/Poruke.php";

class PorukeController
{
    private $model;

    public function __construct($db)
    {
        $this->$model = new Poruka($db);
    }

    public function PrikaziSvePoruke()
    {
        $SvePoruke = $this->model->ViewAllMessages();
        if(!empty($SvePoruke))
        {
            return $SvePoruke;
        }
        else
        {
            return "Nemate poruka.";
        }
    }

    public function PrikaziSvePrimljenePoruke($primaoc_id)
    {
        $this->model->primaoc_id = $primaoc_id;
        $PrimljenePoruke = $this->model->ViewAllReceivedMessages();
        
        if(!empty($PrimljenePoruke))
        {
            return $PrimljenePoruke;
        }
        else
        {
            return "Nemate novih poruka.";
        }
    }

    public function PrikaziSvePoslanePoruke($posiljaoc_id)
    {
        $this->model->posiljaoc_id = $posiljaoc_id;
        $PoslanePoruke = $this->model->ViewAllSentMessages();

        if(!empty($PoslanePoruke))
        {
            return $PoslanePoruke;
        }
        else
        {
            return "Nemate poslanih poruka.";
        }
    }
    
}

?>
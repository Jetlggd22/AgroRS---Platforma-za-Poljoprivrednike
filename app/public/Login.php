<?php
session_start();
require_once __DIR__ . "../../config/Database.php";
require_once __DIR__ . "../../controllers/KorisnikController.php";

$database = new Database();
$db = $database->connect();
$korisnikController = new KorisnikController($db);

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email = $_POST['Email'];
    $lozinka = $_POST['Lozinka'];
    $korisnik = $korisnikController->Prijava($email,$lozinka);

    if($korisnik)
    {
        $_SESSION['id_korisnika'] = $korisnik['ID'];
        $_SESSION['ime_korisnika'] = $korisnik['Ime'];
        $_SESSION['email_korisnika'] = $korisnik['Email'];
        header("Location: Index.php");
        exit();
    }
    else
    {
        echo "Greska pri prijavi.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Travela - Tourism Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="col-lg-8">
                        <h3 class="mb-2">Send us a message</h3>
                        <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
                        <form method ="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" name = "Email" placeholder="Your Name">
                                        <label for="name">Ime</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text   " class="form-control border-0" name = "Lozinka" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                        </body>
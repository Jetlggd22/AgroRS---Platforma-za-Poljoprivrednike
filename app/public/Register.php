    <?php
    session_start();
    require_once __DIR__ . "/../config/Database.php";
    require_once __DIR__ . "/../controllers/KorisnikController.php";

    $database = new Database();
    $db = $database->connect();
    $korisnikController = new KorisnikController($db);

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $ime = $_POST['Ime'];
        $prezime = $_POST['Prezime'];
        $email = $_POST['Email'];
        $lozinka = $_POST['Lozinka'];
        $telefon = $_POST['Telefon'];
        $adresa = $_POST['Adresa'];
        
        $korisnik = $korisnikController->KreirajKorisnika($ime,$prezime,$email,$lozinka,$telefon,$adresa);

        if($korisnik)
        {
            header("Location: Login.php");
            exit();
        }
        
    }

    ?>
    <!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
</head>
<body>
    <h2>Registracija</h2>
    
    <form method="POST">
        <div>
            <label>Ime:</label>
            <input type="text" name="Ime" required>
        </div>
        
        <div>
            <label>Prezime:</label>
            <input type="text" name="Prezime" required>
        </div>
        
        <div>
            <label>Email:</label>
            <input type="email" name="Email" required>
        </div>
        
        <div>
            <label>Lozinka:</label>
            <input type="password" name="Lozinka" required>
        </div>
        
        <div>
            <label>Telefon:</label>
            <input type="text" name="Telefon">
        </div>
        
        <div>
            <label>Adresa:</label>
            <input type="text" name="Adresa">
        </div>
        
        <button type="submit">Registruj se</button>
    </form>
    
    <p>Već imate nalog? <a href="Login.php">Prijavite se</a></p>
</body>
</html>

<?php
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korime = $_POST["nova_lozinka"];
    $napraviHash = hash('adler32', $korime);
    $upitMail = $baza->selectDB("SELECT email FROM korisnik WHERE korisnicko_ime = '$korime'");
    $validacija = mysqli_fetch_array($upitMail);
    if ($upitMail->num_rows > 0) {
        $email = $validacija[0];
        $mail_to = $email;
        $mail_from = "From: Knjiznica";
        $mail_subject = "Nova lozinka";
        $mail_body = "Vaša nova lozinka je" ." ". "$napraviHash";
        
        $baza->updateDB("UPDATE korisnik SET lozinka = '$napraviHash' , potvrda_lozinke = '$napraviHash' WHERE email = '$email'");
        if (mail($mail_to, $mail_subject, $mail_body, $mail_from)) {
            echo("Poslana poruka za: '$mail_to'!");
        } else {
            echo("Problem kod poruke za: '$mail_to'!");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Matija Lazar">
        <meta name="keywords" content="FOI, WebDiP">
        <link href ="css/matlazar.css" rel ="stylesheet" type="text/css">
        <link href="css/matlazar_responsive.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src ="js/matlazar.js"></script>
        <title>Knjižnica</title>
    </head>
    <body>
        <header>
            <h1>Knjižnica</h1>
        </header>
        <div class="glavnasekcija">
            <section>
                <br><br>
                <form id="novalozinka" method="post" name="novalozinka" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate="novalidate" >
                    <label for="nova_lozinka">Vaše korisničko ime</label>
                    <input type="text" id="nova_lozinka" name="nova_lozinka">
                    <input type="submit"  value=" Pošalji novu lozinku ">
                </form>
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>

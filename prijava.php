<?php
if (!isset($_SERVER["HTTPS"]) || strtolower($_SERVER["HTTPS"]) != "on") {
    $adresa = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    header("Location:$adresa");
}
$greska = "";
$poruka = "";
if (isset($_GET["aktivirano"])) {
    $poruka = "Dobrodošli, račun vam je sada aktivan";
}

//Prijava
include 'dohvati_virtualno.php';
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $korisnik = $_POST["korime"];
    $lozinka2 = filter_input(INPUT_POST, 'lozinka');
    $sqlprovjera = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korisnik' AND lozinka = '$lozinka2' AND blokiran < 3 AND status = 1";
    $broj = $baza->selectDB($sqlprovjera);
    if ($broj->num_rows > 0) {
        $upitZaSesiju = $baza->selectDB("SELECT id_tip,telefon,email,id_korisnik FROM korisnik WHERE korisnicko_ime = '$korisnik' ");
        $sesija = mysqli_fetch_array($upitZaSesiju, MYSQLI_BOTH);
        $vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
        session_start();
        $_SESSION["korime"] = $korisnik;
        $_SESSION["lozinka"] = $lozinka2;
        $_SESSION["id_tip"] = $sesija[0];
        $_SESSION["telefon"] = $sesija[1];
        $_SESSION["email"] = $sesija[2];
        $_SESSION["id_korisnik"] = $sesija[3];
        $_SESSION["vrijeme_prijave"] = $vrijeme;
        setcookie("kolacic", $korisnik);
        $dnevnikUpdate = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,radnja_id,id_korisnik)"
                . " VALUES (DEFAULT,'$vrijeme',1,'$sesija[3]')";
        $baza->updateDB($dnevnikUpdate);
        $baza->updateDB("UPDATE upit SET posjecenost = posjecenost + 1 WHERE upit_id = 2");
        header("Location: http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/index.php?korisnik_tip=" . $_SESSION["korime"]);
    } else {
        $upitGreske = $baza->selectDB("SELECT korisnicko_ime,lozinka,status,blokiran,id_tip FROM korisnik WHERE korisnicko_ime = '$korisnik' OR lozinka = '$lozinka2'");
        $blokiran = mysqli_fetch_array($upitGreske);
        if ($blokiran[4] != 1) {
            if ($blokiran[2] == 0) {
                $greska = "Vas racun nije aktiviran. Moguće da ga niste aktivirali";
            } elseif ($blokiran[3] >= 3) {
                $greska = "Račun je blokiran, promašili ste tri puta lozinku ili korisničko ime";
            } else {
                $upitZaključavanja = "UPDATE korisnik SET blokiran = blokiran + 1 WHERE korisnicko_ime = '$korisnik' OR lozinka = '$lozinka2'";
                $baza->updateDB($upitZaključavanja);
                $ispis = 2 - $blokiran[3];
                $greska = "Pogresno korisnicko ime ili lozinka" . "<br>" . "Imate još" . " " . $ispis . " " . "pokušaja" . "<br>" . "inače će Vaš račun biti zaključan";
            }
        }
    }
}
$baza->zatvoriDB();
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
        <div id = "navigacija">
            <nav>
                <label for="show-menu" class="show-menu">☰ Izbornik</label>
                <input type="checkbox" id="show-menu" role="button">
                <ul id="menu">
                    <li><a class ="active" href="index.php">Početna</a></li>
                    <li><a href = "dokumentacija.html">Dokumentacija</a></li>
                    <li><a href = "o_autoru.html" >O autoru</a></li>
                    <li  class="desno"><a href ="registracija.php">Registracija</a></li>';
                </ul>
            </nav>
        </div>
        <div class="glavnasekcija">
            <section>
                <p><?php echo $poruka ?></p>

                <div class="prijava">
                    <h3 class="h3">Prijava</h3>
                    <form id = "prijava" method = "post" name = "form1" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <label for="korime" class="labele">Korisničko ime: </label>
                        <input type="text" id="korime" class="unos" name="korime" placeholder="Korisničko ime" value="<?php
                        if (isset($_COOKIE["kolacic"])) {
                            echo $_COOKIE["kolacic"];
                        }
                        ?>"><br><br>
                        <label for="lozinka" class="labele">Lozinka: </label>
                        <input type="password" id="lozinka" class="unos" name="lozinka" placeholder="Lozinka"><br><br><br>
                        <input type="submit" class="submit" value=" Prijavi se ">
                        <input type="reset" class="reset" value=" Inicijaliziraj "><br><br><br>
                        <a href ="http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/zaboravljena_lozinka.php" style="text-align: center">Zaboravljena lozinka?</a>
                        <p><?php echo $greska; ?></p>
                        
                    </form>
                </div>
               
               
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>

<?php
session_start();
include 'baza_class.php';
$baza=new Baza();
$baza->spojiDB();
$baza->updateDB("UPDATE stranica SET posjecenost = posjecenost + 1 WHERE stranica_id = 1");
if (!isset($_SESSION["korime"])) {
    header("Location:prijava.php");
}
if (!isset($_SERVER["HTTPS"]) || strtolower($_SERVER["HTTPS"]) != "on") {
    $adresa = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    header("Location:$adresa");
}

$greska = "";
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
                    <?php
                    if(isset($_SESSION["id_tip"]) && $_SESSION["id_tip"] == 1){
                       echo '<li><a href = "korisnici.php" >Korisnici</a></li>';
                       echo '<li><a href = "crud_csv.php" >Popunjavanje</a></li>';
                       echo '<li><a href = "konfiguracija.php" >Konfiguracija</a></li>';
                       echo '<li><a   href = "dnevnik.php" >Dnevnik</a></li>';
                        echo '<li><a href = "statistika.php" >Statistika</a></li>';
                    }if(isset ($_SESSION["id_tip"]) && ($_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1)){
                       echo '<li><a href = "moderator.php" >Moderator</a></li>';
                    }if($_SESSION["id_tip"] == 3 || $_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1){
                        echo '<li><a href = "posudba.php" >Posudbe</a></li>';
                        echo '<li><a href = "knjige.php" >Knjige</a></li>';
                        echo '<li><a href = "galerija.php" >Galerija</a></li>';
                    }
                    ?>
                    <li  class="desno"><a href ="logout.php">Odjavi se</a></li>';
                </ul>
            </nav>
        </div>
        <div class="glavnasekcija">
            <section>
                
                <div class="knjiznice2">
                </div>
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>

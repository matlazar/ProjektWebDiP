<?php
session_start();
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.css"/> 
        <script type="text/javascript" src ="js/data_tables.js"></script>
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
                    <li><a  href="index.php">Početna</a></li>
                    <li><a href = "dokumentacija.html">Dokumentacija</a></li>
                    <li><a href = "o_autoru.html" >O autoru</a></li>
                    <?php
                    if (isset($_SESSION["id_tip"]) && $_SESSION["id_tip"] == 1) {
                        echo '<li><a href = "korisnici.php" >Korisnici</a></li>';
                        echo '<li><a href = "crud_csv.php" >Popunjavanje</a></li>';
                        echo '<li><a href = "konfiguracija.php" >Konfiguracija</a></li>';
                        echo '<li><a  class ="active" href = "dnevnik.php" >Dnevnik</a></li>';
                        echo '<li><a href = "statistika.php" >Statistika</a></li>';
                    }if (isset($_SESSION["id_tip"]) && ($_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1)) {
                        echo '<li><a href = "moderator.php" >Moderator</a></li>';
                    }if ($_SESSION["id_tip"] == 3 || $_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1) {
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
            <?php
            $upitPosudbe = "SELECT korisnik.ime, korisnik.prezime, dnevnici.dnevnik_datum_vrijeme,radnja.naziv_radnje FROM dnevnici JOIN korisnik ON korisnik.id_korisnik = dnevnici.id_korisnik JOIN radnja ON radnja.id_radnja = dnevnici.radnja_id ";
            $posudbe = "<table id='rezervirane' class = 'display'><thead><th>Ime i prezime</th><th>Datum i vrijeme</th><th>Radnja</th></thead><tbody>";
            $posudbe1 = '';
            $posudba = $baza->selectDB($upitPosudbe);
            while ($red = mysqli_fetch_assoc($posudba)) {
                $posudbe1 .= '<tr>' . '<td>' . $red["ime"] . ' ' . $red["prezime"] . '</td>' . '<td>' . $red["dnevnik_datum_vrijeme"] . '</td>' . '<td>' . $red["naziv_radnje"] . '</td>' . '</tr>';
            }
            $posudbe .=$posudbe1 . '</tbody></table>';
            print $posudbe;
            ?>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>

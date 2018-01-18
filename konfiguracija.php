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
                       echo '<li><a class="active" href = "konfiguracija.php" >Konfiguracija</a></li>';
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
                <div class="odabirModeratora">
                    <h3>Virtualno vrijeme</h3><hr>
                    <a href="http://barka.foi.hr/WebDiP/pomak_vremena/vrijeme.html" target="_blank" class = "virtualno">Virtualno vrijeme</a><br>
                    <a href="virtualno.php" class = "virtualno">Izvrši pomak</a><br><br>
                    <?php
                    include 'dohvati_virtualno.php';
                    $br_Sati = dohvati_pomak();
                    echo "Trenutni vremenski pomak: "." ".$br_Sati ." "."sati". "<br>";
                    ?>
                </div>
                <div class="odabirModeratora">
                    <h3>Straničenje</h3><hr>
                </div>
                <div class="odabirModeratora">
                    
                </div>
                <div class="odabirModeratora">
                    
                </div>
                <div class="odabirModeratora">
                    
                </div>
                <div class="odabirModeratora">
                    
                </div>
                <div class="odabirModeratora">
                    
                </div>
                <div class="odabirModeratora">
                    
                </div>
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>
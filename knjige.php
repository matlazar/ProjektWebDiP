<?php
session_start();
include 'knjige_lajkovi.php';
$baza = new Baza();
$baza->spojiDB();
$baza->updateDB("UPDATE stranica SET posjecenost = posjecenost + 1 WHERE stranica_id = 3");
$korisnik = $_SESSION["id_korisnik"];
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
                    <li><a href="index.php">Početna</a></li>
                    <li><a href = "dokumentacija.html">Dokumentacija</a></li>
                    <li><a href = "o_autoru.html" >O autoru</a></li>
                    <?php
                    if (isset($_SESSION["id_tip"]) && $_SESSION["id_tip"] == 1) {
                        echo '<li><a href = "korisnici.php" >Korisnici</a></li>';
                        echo '<li><a href = "crud_csv.php" >Popunjavanje</a></li>';
                        echo '<li><a href = "konfiguracija.php" >Konfiguracija</a></li>';
                        echo '<li><a   href = "dnevnik.php" >Dnevnik</a></li>';
                        echo '<li><a href = "statistika.php" >Statistika</a></li>';
                    }if (isset($_SESSION["id_tip"]) && ($_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1)) {
                        echo '<li><a href = "moderator.php" >Moderator</a></li>';
                    }if ($_SESSION["id_tip"] == 3 || $_SESSION["id_tip"] == 2 || $_SESSION["id_tip"] == 1) {
                        echo '<li><a href = "posudba.php" >Posudbe</a></li>';
                        echo '<li><a class="active" href = "knjige.php" >Knjige</a></li>';
                        echo '<li><a href = "galerija.php" >Galerija</a></li>';
                    }
                    ?>
                    <li  class="desno"><a href ="logout.php">Odjavi se</a></li>';
                </ul>
            </nav>
        </div>
        <div class="glavnasekcija">
            <section>
                <div  class="lajk">
                    <h3>Sviđa mi se/ Ne sviđa mi se</h3>
                    <div class ="lajk2">
                        <h3>Knjiga</h3>
                        <hr>
                        <form id="knjiga1" name="knjiga1" method="post" action=<?php echo"knjige_lajkovi.php?id=" . $korisnik ?>>
                            <label for = "knjiga" class="unosModerator">Knjiga</label>
                            <?php
                            $popuni7 = "SELECT knjiga_id,naslov  FROM knjiga";
                            $podaci7 = $baza->selectDB($popuni7);
                            print '<select name="knjiga" id="knjiga" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci7)) {
                                print '<option value="' . $red['knjiga_id'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naslov'] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <br><br>
                            <input type="submit" id = "like" name="like"  value="Sviđa mi se">
                            <input type="submit" id="unlike" name="unlike" value="Ne sviđa mi se">
                            <input type="submit" id="remove" name="remove" value="Obriši dojam">
                        </form>
                    </div>
                    <div class ="lajk2">
                        <h3>Žanr</h3>
                        <hr>
                        <form id="knjiga2" name="knjiga2" method="post" action=<?php echo"knjige_lajkovi.php?id=" . $korisnik ?>>
                            <label for = "kategorije" class="unosModerator">Knjiga</label>
                            <?php
                            $popuni2 = "SELECT id_tip_kategorije,naziv  FROM tip_kategorije";
                            $podaci2 = $baza->selectDB($popuni2);
                            print '<select name="kategorije" id="kategorije" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci2)) {
                                print '<option value="' . $red['id_tip_kategorije'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naziv'] . '</option>';
                            }
                            print '</select>';
                            ?><br><br>
                            <input type="submit" id = "like1" name="like1"  value="Sviđa mi se">
                            <input type="submit" id="unlike1" name="unlike1" value="Ne sviđa mi se">
                            <input type="submit" id="remove1" name="remove1" value="Obriši dojam">
                        </form>
                    </div>                   
                </div>
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


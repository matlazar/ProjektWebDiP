<?php
session_start();
include 'posudbe_skripta.php';
$baza = new Baza();
$baza->spojiDB();
$baza->updateDB("UPDATE stranica SET posjecenost = posjecenost + 1 WHERE stranica_id = 5");
$korisnik = $_SESSION["id_korisnik"];
$br_Sati = dohvati_pomak();
$vrijeme = date('Y-m-d', strtotime($br_Sati . " hours"));
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
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.css"/> 
        <script type="text/javascript" src ="js/data_tables.js"></script>
        <script type="text/javascript" src ="js/ajax.js"></script>
        <script type="text/javascript" src ="js/matlazar.js"></script>
        <title>Knjižnica</title>
    </head>
    <body>
        <header>
            <h1>Knjižnica</h1>
            <p id ="jas"></p>
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
                        echo '<li><a class="active" href = "posudba.php" >Posudbe</a></li>';
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

                <div class = "posudbe">
                    <div class = "odrediPosudbu">
                        <h3>Rezerviraj kod moderatora</h3>
                        <hr>
                        <form id="knjiga2" name="knjiga2" method="post" action="<?php echo"posudbe_skripta.php?korisnik=" . $korisnik ?>">
                            <label for = "mod_knjizara" class="unosModerator">Knjižnica</label>
                            <?php
                            $popuni1 = "SELECT knjiznica.id_knjiznica,knjiznica.naziv_knjiznice,korisnik.ime,korisnik.prezime FROM knjiznica LEFT JOIN korisnik ON knjiznica.id_korisnik = korisnik.id_korisnik WHERE knjiznica.id_korisnik IS NOT NULL ";
                            $podaci1 = $baza->selectDB($popuni1);
                            print '<select name="mod_knjizara" id="mod_knjizara" class="cmbBox" >';
                            while ($red = mysqli_fetch_assoc($podaci1)) {
                                print '<option value="' . $red['id_knjiznica'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naziv_knjiznice'] . ' - ' . $red["ime"] . ' ' . $red["prezime"] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <input type="submit" id = "potvrdi" name="potvrdi" value="Potvrdi"><br><br>
                            <label for = "slobodne" class="unosModerator">Slobodne knjige</label>
                            <?php
                            if (isset($_GET["id"])) {
                                $id_kn = $_GET["id"];
                                $popuni2 = "SELECT knjiga.knjiga_id,knjiga.naslov FROM knjiga INNER JOIN pripada ON knjiga.knjiga_id = pripada.knjiga_id WHERE pripada.id_knjiznica='$id_kn' AND status_knjige=2";

                                $podaci2 = $baza->selectDB($popuni2);
                            }
                            print '<select name="slobodne" id="slobodne" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci2)) {
                                print '<option value="' . $red['knjiga_id'] . '|' . $id_kn . '"';
                                print ' selected="selected"';
                                print '>' . $red['naslov'] . '</option>';
                            }
                            print '</select>';
                            ?><br><br>
                            <label for = "broj_dana" class="unosModerator">Broj dana</label>
                            <input type="text" id="broj_dana" name="broj_dana" class="cmbBox"><br><br>
                            <label for = "datum" class="unosModerator">Rezerviraj od</label>
                            <input type="text" id="datum" name="datum" class="cmbBox" value = "<?php echo $vrijeme ?>"><br><br>
                            <input type="submit" id = "rezerviraj" name="rezerviraj"  value="Rezerviraj">
                        </form>
                    </div>

                    <div class = "odrediPosudbu">
                        <h3>Rezerviraj od korisnika</h3>
                        <hr>
                        <form id="knjiga4" name="knjiga4" method="post" action=<?php echo"posudbe_skripta.php?korisnik=" . $korisnik ?>>
                            <label for = "kor_knjizara" class="unosModerator">Knjižnica</label>
                            <?php
                            $popuni2 = "SELECT knjiznica.id_knjiznica,knjiznica.id_korisnik,knjiznica.naziv_knjiznice,korisnik.ime,korisnik.prezime FROM knjiznica LEFT JOIN korisnik ON knjiznica.id_korisnik = korisnik.id_korisnik WHERE knjiznica.id_korisnik IS NOT NULL ";
                            $podaci2 = $baza->selectDB($popuni2);
                            print '<select name="kor_knjizara" id="kor_knjizara" class="cmbBox" >';
                            while ($red = mysqli_fetch_assoc($podaci2)) {
                                print '<option value="' . $red['id_knjiznica'] . '|' . $red['id_korisnik'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naziv_knjiznice'] . ' - ' . $red["ime"] . ' ' . $red["prezime"] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <input type="submit" id = "potvrdi2" name="potvrdi2" value="Potvrdi"><br><br>

                            <label for = "posudba" class="unosModerator">Posuđene knjige</label>
                            <?php
                            if (isset($_GET["k"]) && isset($_GET["m"])) {
                                $id_kn = $_GET["k"];
                                $id_m = $_GET["m"];
                                $popuni2 = "SELECT knjiga.knjiga_id,knjiga.naslov FROM knjiga INNER JOIN pripada ON knjiga.knjiga_id = pripada.knjiga_id WHERE pripada.id_knjiznica='$id_kn' AND status_knjige=3";

                                $podaci2 = $baza->selectDB($popuni2);
                            }
                            print '<select name="posudba" id="posudba" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci2)) {
                                print '<option value="' . $red['knjiga_id'] . '|'.$id_kn .'|'. $id_m . '"';
                                print ' selected="selected"';
                                print '>' . $red['naslov'] . '</option>';
                            }
                            print '</select>';
                            ?><br><br>
                            <label for = "broj_dana1" class="unosModerator">Broj dana</label>
                            <input type="text" id="broj_dana1" name="broj_dana1" class="cmbBox"><br><br>
                            <label for = "datum1" class="unosModerator">Rezerviraj od</label>
                            <input type="text" id="datum1" name="datum1" class="cmbBox" value = "<?php echo $vrijeme ?>"><br><br>
                            <input type="submit" id = "rezerviraj1" name="rezerviraj1"  value="Rezerviraj">
                            <p><?php
                                if (isset($_GET["ne"])) {
                                    echo 'Knjiga je već trebala biti vraćena';
                                } elseif (isset($_GET["posudba"])) {
                                    echo 'Knjigu možete posuditi na najviše' .' '. $_GET["posudba"].' ' . "dana";
                                }
                                ?></p>
                        </form>
                    </div>
                    <hr>
                    <h3>Rezervacije od drugog korisnika</h3>
                    <?php
                        $upitPosudbe = "select korisnik.ime, korisnik.prezime, rezervacija_korisnik.datum_od, rezervacija_korisnik.datum_do, knjiga.naslov from korisnik join rezervacija_korisnik on korisnik.id_korisnik = rezervacija_korisnik.posudi_id join knjiga on rezervacija_korisnik.knjiga_id = knjiga.knjiga_id where rezervacija_korisnik.posudioje_id =  '$korisnik' ";
                        $posudbe = "<table id='rezervirane2' class = 'display'><thead><th>Ime i prezime</th><th>Knjiga</th><th>Datum od</th><th>Datum do</th></thead><tbody>";
                        $posudbe1 = '';
                        $posudba = $baza->selectDB($upitPosudbe);
                        while ($red = mysqli_fetch_assoc($posudba)) {
                            $posudbe1 .= '<tr>' . '<td>' . $red["ime"] . ' ' . $red["prezime"] . '</td>' . '<td>' . $red["naslov"] . '</td>' . '<td>' . $red["datum_od"] . '</td>' . '<td>' . $red["datum_do"] . '</td>' . '</tr>';
                        }
                        $posudbe .=$posudbe1 . '</tbody></table>';
                        print $posudbe;
                    ?>
                </div>
            </section>
        </div>
        <div class="footer">
            <footer>

            </footer>
        </div>
    </body>
</html>


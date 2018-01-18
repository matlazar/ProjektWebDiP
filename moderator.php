<?php
session_start();
include 'knjige_kategorije_knjiznice.php';
$baza = new Baza();
$baza->spojiDB();
$baza->updateDB("UPDATE stranica SET posjecenost = posjecenost + 1 WHERE stranica_id = 4");
$korisnik = $_SESSION["id_korisnik"];
$tip = $_SESSION["id_tip"];
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
                        echo '<li><a class="active" href = "moderator.php" >Moderator</a></li>';
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
            <section>
                <div class="kategorije">
                    <h3>Kategorije</h3>
                    <hr>
                    <form id="kategorija" name="kategorija" method="post" action="<?php echo 'knjige_kategorije_knjiznice.php?korisnik=' . $korisnik ?>">
                        <label for = "kategorije" class="unosModerator">Kategorija</label>
                        <input id="kategorije" name="kategorije" type="text" class="cmbBox"><br><br>
                        <input type="submit"  value="Dodaj kategoriju">
                    </form>

                    <hr>
                    <h3>Dodaj kategoriju knjižnici</h3>
                    <form id="kategorija1" name="kategorija2" method="post" action="knjige_kategorije_knjiznice.php">
                        <label for = "knjiznica" class="unosModerator">Knjižnica</label>
                        <?php
                        $popuni1 = "SELECT id_knjiznica,naziv_knjiznice  FROM knjiznica";
                        $podaci1 = $baza->selectDB($popuni1);
                        print '<select name="knjiznica" id="knjiznica" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci1)) {
                            print '<option value="' . $red['id_knjiznica'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv_knjiznice'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>

                        <label for = "kategorije1" class="unosModerator">Kategorija</label>
                        <?php
                        $popuni2 = "SELECT id_tip_kategorije,naziv  FROM tip_kategorije";
                        $podaci2 = $baza->selectDB($popuni2);
                        print '<select name="kategorije1" id="kategorije1" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci2)) {
                            print '<option value="' . $red['id_tip_kategorije'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <input type="submit" name="katknji" value="Dodaj kategoriju knjižnici">
                    </form>

                    <hr>
                    <h3>Dodaj knjigu</h3>
                    <form id="knjiga" name="knjiga" method="post" action="<?php echo 'knjige_kategorije_knjiznice.php?korisnik=' . $korisnik ?>">
                        <label for = "naziv_knjige" class="unosModerator">Naslov</label>
                        <input type="text" id="naziv_knjige" name="naziv_knjige"><br>
                        <label for = "br_stranica" class="unosModerator">Broj stranica</label>
                        <input type="number" id="br_stranica" name="br_stranica"><br>
                        <label for = "izdanje" class="unosModerator">Godina izdanja</label>
                        <input type="number" id="izdanje" name="izdanje"><br>
                        <label for = "izdavac" class="unosModerator">Izdavač</label>
                        <?php
                        $popuni3 = "SELECT izdavac_id,naziv  FROM izdavac";
                        $podaci3 = $baza->selectDB($popuni3);
                        print '<select name="izdavac"  id="izdavac" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci3)) {
                            print '<option value="' . $red['izdavac_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?><br>
                        <label for = "autor" class="unosModerator">Autor</label>
                        <?php
                        $popuni4 = "SELECT autor_id,ime,prezime  FROM autor";
                        $podaci4 = $baza->selectDB($popuni4);
                        print '<select name="autor" id="autor" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci4)) {
                            print '<option value="' . $red['autor_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['ime'] . ' ' . $red['prezime'] . '</option>';
                        }
                        print '</select>';
                        ?>
                        <br>
                        <label for = "zanr" class="unosModerator">Žanr</label>
                        <?php
                        $popuni5 = "SELECT id_tip_kategorije,naziv  FROM tip_kategorije";
                        $podaci5 = $baza->selectDB($popuni5);
                        print '<select name="zanr" id="zanr" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci5)) {
                            print '<option value="' . $red['id_tip_kategorije'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?>
                        <br><br>
                        <input type="submit" name="katknji" value="Dodaj knjigu">
                    </form>
                    <hr>
                    <h3>Dodaj knjigu knjižnici</h3>
                    <form id="knjiga_knjiznica" name="knjiga_knjiznica" method="post" action="knjige_kategorije_knjiznice.php">
                        <p><?php
                            if (isset($_GET["error"])) {
                                echo 'Žanr knjige se ne podudara sa žanrovima knjižnice';
                            }
                            ?></p>
                        <label for = "x_knjiznica" class="unosModerator">Knjižnica</label>
                        <?php
                        $popuni6 = "SELECT id_knjiznica,naziv_knjiznice  FROM knjiznica";
                        $podaci6 = $baza->selectDB($popuni6);
                        print '<select name="x_knjiznica" id="x_knjiznica" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci6)) {
                            print '<option value="' . $red['id_knjiznica'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv_knjiznice'] . '</option>';
                        }
                        print '</select>';
                        ?>
                        <br>
                        <label for = "x_knjiga" class="unosModerator">Knjiga</label>
                        <?php
                        $popuni7 = "SELECT knjiga_id,naslov  FROM knjiga";
                        $podaci7 = $baza->selectDB($popuni7);
                        print '<select name="x_knjiga" id="x_knjiga" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci7)) {
                            print '<option value="' . $red['knjiga_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naslov'] . '</option>';
                        }
                        print '</select>';
                        ?>
                        <br><br>
                        <input type="submit" name="dodaj" value="Dodaj knjigu knjižnici">
                    </form>
                </div>
                <div class = "ispis_posudbe">
                    <h3>Rezervacije</h3>
                    <?php
                        $upitPosudbe = "select korisnik.ime, korisnik.prezime, rezervacija.datum_od, rezervacija.datum_do, knjiga.naslov from korisnik join rezervacija on korisnik.id_korisnik = rezervacija.korisni1_id join knjiga on rezervacija.knjiga_id = knjiga.knjiga_id where rezervacija.korisnik2_id = '$korisnik' ";
                        $posudbe = "<table id='rezervirane' class = 'display'><thead><th>Ime i prezime</th><th>Knjiga</th><th>Datum od</th><th>Datum do</th></thead><tbody>";
                        $posudbe1 = '';
                        $posudba = $baza->selectDB($upitPosudbe);
                        while ($red = mysqli_fetch_assoc($posudba)) {
                            $posudbe1 .= '<tr>' . '<td>' . $red["ime"] . ' ' . $red["prezime"] . '</td>' . '<td>' . $red["naslov"] . '</td>' . '<td>' . $red["datum_od"] . '</td>' . '<td>' . $red["datum_do"] . '</td>' . '</tr>';
                        }
                        $posudbe .=$posudbe1 . '</tbody></table>';
                        print $posudbe;
                    ?>
                    <h3>Aplikativna statitika</h3>
                    <form id="like_knjiga" name="like_knjiga" method="post" action="<?php echo 'knjige_kategorije_knjiznice.php?korisnik=' . $korisnik ?>">
                        <label for = "knjigice" class="unosModerator">Knjige</label>
                        <?php
                        $provjera = $baza->selectDB("SELECT id_tip FROM korisnik WHERE id_korisnik = '$korisnik'");
                        $korisnik_id = mysqli_fetch_assoc($provjera);
                        if ($korisnik_id["id_tip"] == 2) {
                            $popuni8 = "SELECT knjiznica.id_knjiznica,knjiga.knjiga_id,knjiga.naslov FROM pripada JOIN knjiga ON knjiga.knjiga_id = pripada.knjiga_id JOIN knjiznica ON pripada.id_knjiznica = knjiznica.id_knjiznica JOIN korisnik ON knjiznica.id_korisnik = korisnik.id_korisnik  WHERE knjiznica.id_korisnik = '$korisnik'";
                            $podaci8 = $baza->selectDB($popuni8);
                            print '<select name="knjigice" id="knjigice" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci8)) {
                                print '<option value="' . $red['knjiga_id'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naslov'] . '</option>';
                            }
                        } else {
                            $popuni8 = "SELECT knjiznica.id_knjiznica,knjiga.knjiga_id,knjiga.naslov,knjiznica.naziv_knjiznice FROM knjiga  JOIN pripada ON knjiga.knjiga_id = pripada.knjiga_id JOIN knjiznica ON knjiznica.id_knjiznica = pripada.id_knjiznica WHERE  pripada.status_knjige=2;";
                            $podaci8 = $baza->selectDB($popuni8);
                            print '<select name="knjigice" id="knjigice" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci8)) {
                                print '<option value="' . $red['knjiga_id'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naslov'] . '-' . $red["naziv_knjiznice"] . '</option>';
                            }
                        }

                        print '</select>';
                        ?><br><br>
                        <input type="submit" name="knjili" value="Prikaži">
                        <?php
                        if (isset($_GET["s"]) && isset($_GET["n"])) {
                            echo 'Like: ' . ' ' . $_GET["s"] . ' ,' . 'Unlike: ' . ' ' . $_GET["n"];
                        }
                        ?>
                    </form>
                    <form id="like_knjiznica" name="like_knjiznica" method="post" action="knjige_kategorije_knjiznice.php">
                        <label for = "zanrici" class="unosModerator">Kategorije</label>
                        <?php
                        $popuni8 = "SELECT id_tip_kategorije, naziv FROM tip_kategorije;";
                        $podaci8 = $baza->selectDB($popuni8);
                        print '<select name="zanrici" id="zanrici" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci8)) {
                            print '<option value="' . $red['id_tip_kategorije'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <input type="submit" name="knjili2" value="Prikaži">
                        <?php
                        if (isset($_GET["sv"]) && isset($_GET["ns"])) {
                            echo 'Like: ' . ' ' . $_GET["sv"] . ' ,' . 'Unlike: ' . ' ' . $_GET["ns"];
                        }
                        ?>
                    </form>
                </div>
            </section>
        </div>
        <div class="footer">
            <footer>
                <?php echo $tip; ?>
            </footer>
        </div>
    </body>
</html>
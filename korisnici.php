<?php
session_start();
include 'gradovi_knjiznice.php';
$baza = new Baza();
$baza->spojiDB();
$baza->updateDB("UPDATE stranica SET posjecenost = posjecenost+1 WHERE stranica_id=2");
$korisnik=$_SESSION["id_korisnik"];
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
        <script type="text/javascript" src ="js/matlazar.js"></script>
        <script type="text/javascript" src ="js/ajax.js"></script>
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
                    if(isset($_SESSION["id_tip"]) && $_SESSION["id_tip"] == 1){
                       echo '<li><a class = "active" href = "korisnici.php" >Korisnici</a></li>';
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
                <div class="odabirModeratora">
                    <h3>Korinički računi</h3>
                    <form id="dodaj_moderatora" name="dodaj_moderatora" method="post" action="">
                        <label for ="cmbBox1"  class="unosModerator">Korisnik</label>
                        <?php
                        $popuni = "SELECT id_korisnik,ime,prezime  FROM korisnik WHERE id_tip != 1 AND blokiran != 3 AND status != 0";
                        $podaci = $baza->selectDB($popuni);
                        print '<select name="cmbBox1" id="cmbBox1" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci)) {
                            print '<option value="' . $red['id_korisnik'] . ' ' . $red['ime'] . ' ' . $red['prezime'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['ime'] . ' ' . $red['prezime'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <input type="button" id="moderator" name="moderator" value="Blokiraj">
                        <hr><br>
                        <label for ="cmbBox2"  class="unosModerator">Korisnik</label>
                        <?php
                        $popuni2 = "SELECT id_korisnik,ime,prezime  FROM korisnik WHERE id_tip != 1 AND blokiran = 3 AND status != 0";
                        $podaci2 = $baza->selectDB($popuni2);
                        print '<select name="cmbBox2" id="cmbBox2" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci2)) {
                            print '<option value="' . $red['id_korisnik'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['ime'] . ' ' . $red['prezime'] . '</option>';
                        }
                        print '</select>';
                        ?>
                        <br><br>
                        <input type="button" id="korisnik" name="korisnik" value="Aktiviraj">
                    </form> 
                </div>
                <div class="knjiznica">
                    <h2>Dodavanje knjižnice</h2>
                    <hr>
                    <div class="grad">
                        <h3>Dodaj novi grad</h3>
                        <hr>
                        <form id="dodaj_grad" name="dodaj_grad" method="post" action="<?php echo 'gradovi_knjiznice.php?korisnik='.$korisnik; ?>">
                            <label for = "grad" class="unosModerator">Unesi ime grada</label>
                            <input id="grad" name="grad" type="text" class="cmbBox"><br><br>
                            <input type="submit"  value="Dodaj grad">
                            <p><?php
                                if (isset($_GET["ok"])) {
                                    echo 'Uspješno dodan grad';
                                } 
                                ?></p>
                        </form>
                        <hr>
                        <h3>Izbriši postojeći grad</h3>
                        <form id="dodaj_grad2" name="dodaj_grad2" method="post" action="gradovi_knjiznice.php">
                            <label for = "grad2" class="unosModerator">Odaberi grad</label>
                            <?php
                            $popuni3 = "SELECT id_grad,grad  FROM grad";
                            $podaci3 = $baza->selectDB($popuni3);
                            print '<select name="grad2" id="grad2" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci3)) {
                                print '<option value="' . $red['id_grad'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['grad'] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <input type="submit"  value="Izbriši grad">
                            <p><?php
                                if (isset($_GET["ok2"])) {
                                    echo 'Uspješno izbrisan grad';
                                } 
                                ?></p>
                        </form>
                    </div>
                    <div class = "grad2">
                        <h3>Dodaj novu knjižnicu</h3>
                        <hr>
                        <form id="dodaj_knjiznicu" name="dodaj_knjiznicu" method="post" action="http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/gradovi_knjiznice.php">
                            <label for = "naziv_knjiznice" class="unosModerator">Naziv</label>
                            <input id="naziv_knjiznice" name="naziv_knjiznice" type="text" class="cmbBox"><br><br>
                            <label for = "email_knjiznice" class="unosModerator">Email</label>
                            <input id="email_knjiznice" name="email_knjiznice" type="text" class="cmbBox"><br><br>
                            <label for = "adresa_knjiznica" class="unosModerator">Adresa</label>
                            <input id="adresa_knjiznica" name="adresa_knjiznica" type="text" class="cmbBox"><br><br>
                            <label for = "tel_knjiznica" class="unosModerator">Telefon</label>
                            <input id="tel_knjiznica" name="tel_knjiznica" type="text" class="cmbBox"><br><br>
                            <label for = "grad_knjiznica" class="unosModerator">Odaberi grad</label>
                            <?php
                            $popuni4 = "SELECT id_grad,grad  FROM grad";
                            $podaci4 = $baza->selectDB($popuni4);
                            print '<select name="grad_knjiznica" id="grad_knjiznica" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci4)) {
                                print '<option value="' . $red['id_grad'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['grad'] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <input type="submit"  value="Dodaj knjižnicu">
                            <hr>
                            <h3>Izbriši knjižnicu</h3>
                            <label for = "grad_knjiznica" class="unosModerator">Odaberi knjižnicu</label>
                            <?php
                            $popuni5 = "SELECT id_knjiznica,naziv_knjiznice   FROM knjiznica";
                            $podaci5 = $baza->selectDB($popuni5);
                            print '<select name="grad_knjiznica2" id="grad_knjiznica2" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci5)) {
                                print '<option value="' . $red['id_knjiznica'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naziv_knjiznice'] . '</option>';
                            }
                            print '</select>';
                            ?>
                            <input type="submit"  value="Izbriši knjižnicu">
                           
                        </form>
                    </div>
                </div>

                <div class="dodovanjeKnjiznice">
                    <h3>Dodaj moderatora knjižnici</h3><hr>
                    <form id="knjiznica_moderator" name="knjiznica_moderator" method="post" action="gradovi_knjiznice.php">
                        <label for = "mod_knjiznica" class="unosModerator">Knjižnica</label>
                        <?php
                            $popuni6 = "SELECT id_knjiznica,naziv_knjiznice   FROM knjiznica";
                            $podaci6 = $baza->selectDB($popuni6);
                            print '<select name="mod_knjiznica" id="mod_knjiznica" class="cmbBox">';
                            while ($red = mysqli_fetch_assoc($podaci6)) {
                                print '<option value="' . $red['id_knjiznica'] . '"';
                                print ' selected="selected"';
                                print '>' . $red['naziv_knjiznice'] . '</option>';
                            }
                            print '</select>';
                            ?><br><br>
                        <label for = "mod_korisnik" class="unosModerator">Korisnik</label>
                        <?php
                        $popuni7 = "SELECT id_korisnik,ime,prezime  FROM korisnik WHERE id_tip != 1 AND blokiran != 3 AND status != 0 AND id_tip = 3";
                        $podaci7 = $baza->selectDB($popuni7);
                        print '<select name="mod_korisnik" id="mod_korisnik" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci7)) {
                            print '<option value="' .$red['id_korisnik'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['ime'] . ' ' . $red['prezime'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <input type="submit"  value="Dodijeli moderatora">
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

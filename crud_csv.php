<?php
session_start();
include 'CRUD.php';
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
                    <li><a href="index.php">Početna</a></li>
                    <li><a href = "dokumentacija.html">Dokumentacija</a></li>
                    <li><a href = "o_autoru.html" >O autoru</a></li>
                    <?php
                    if (isset($_SESSION["id_tip"]) && $_SESSION["id_tip"] == 1) {
                        echo '<li><a href = "korisnici.php" >Korisnici</a></li>';
                        echo '<li><a class = "active" href = "crud_csv.php" >Popunjavanje</a></li>';
                        echo '<li><a href = "konfiguracija.php" >Konfiguracija</a></li>';
                        echo '<li><a   href = "dnevnik.php" >Dnevnik</a></li>';
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
            <section>
                <div class="odabirModeratora">
                    <h3>CSV popunjavanje tablica</h3>
                    <hr>
                    <form enctype="multipart/form-data" action="uploader.php" method="post" name="form_csv" id = "form_csv">
                        <label class="unosModerator" for="csv">Datoteka</label>
                        <input name="csv" id="csv" type="file"><br><br>
                        <label class="unosModerator" for="tablica">Tablica</label>
                        <select name="tablica" id="tablica" class="cmbBox">
                            <option value = "">Odaberi tablicu</option>
                            <option value="korisnik">Korisnik</option>
                            <option value="knjiznica">Knjižnica</option>
                        </select><br><br> 
                        <input type = "submit" name = "Submit" value="Dodaj u bazu">
                    </form>
                </div>

                <div class="dodajAutore">
                    <h3>Status knjige</h3><hr>
                    <form id="status" name="status" method="post" action="CRUD.php">
                        <label for = "status" class="unosModerator">Izdavač</label>
                        <input id="status" name="status" type="text" class="cmbBox"><br><br>
                        <input type="submit"  value="Dodaj status">
                    </form>
                    <hr>
                    <h3>Obriši/ažuriraj status</h3>
                    <form id="obrisi_status" name="obrisi_status" method="post" action="CRUD.php">
                        <label for = "status2" class="unosModerator">Status</label>
                        <?php
                        $popuni1 = "SELECT status_id,naziv  FROM status";
                        $podaci1 = $baza->selectDB($popuni1);
                        print '<select name="status2" id="status2" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci1)) {
                            print '<option value="' . $red['status_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <label for = "status3" class="unosModerator">Novi naziv</label>
                        <input id="status3" name="status3" type="text" class="cmbBox"><br><br>
                        <input type="submit" name="submitBrisi"  value="Izbriši status">
                        <input type="submit" name="submitUpdate" value="Ažuriraj status">
                    </form>
                    <hr>
                </div>

                <div class="dodajAutore">
                    <h3>Dodaj izdavača</h3><hr>
                    <form id="dodaj_izdavaca" name="dodaj_izdavaca" method="post" action="CRUD.php">
                        <label for = "izdavac" class="unosModerator">Izdavač</label>
                        <input id="izdavac" name="izdavac" type="text" class="cmbBox"><br><br>
                        <input type="submit"  value="Dodaj izdavača">
                    </form>
                    <hr>
                    <h3>Obriši/ažuriraj izdavača</h3>
                    <form id="obrisi_izdavaca" name="obrisi_izdavaca" method="post" action="CRUD.php">
                        <label for = "izdavac2" class="unosModerator">Izdavač</label>
                        <?php
                        $popuni2 = "SELECT izdavac_id,naziv  FROM izdavac";
                        $podaci2 = $baza->selectDB($popuni2);
                        print '<select name="izdavac2" id="izdavac2" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci2)) {
                            print '<option value="' . $red['izdavac_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['naziv'] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <label for = "izdavac3" class="unosModerator">Novi naziv</label>
                        <input id="izdavac3" name="izdavac3" type="text" class="cmbBox"><br><br>
                        <input type="submit" name="submitBrisi"  value="Izbriši izdavača">
                        <input type="submit" name="submitUpdate" value="Ažuriraj izdavača">
                    </form>
                    <hr>
                </div>
                <div class="dodajAutore">
                    <h3>Dodaj autora</h3><hr>
                    <form id="autor" name="autor" method="post" action="CRUD.php">
                        <label for = "ime" class="unosModerator">Ime</label>
                        <input id="ime" name="ime" type="text" class="cmbBox"><br><br>
                        <label for = "prezime" class="unosModerator">Prezime</label>
                        <input id="prezime" name="prezime" type="text" class="cmbBox"><br><br>
                        <input type="submit"  value="Dodaj autora">
                    </form>
                    <hr>
                    <h3>Obriši/ažuriraj autora</h3>
                    <form id="obrisi_autora" name="obrisi_autora" method="post" action="CRUD.php">
                        <label for = "autor" class="unosModerator">Autor</label>
                        <?php
                        $popuni4 = "SELECT autor_id,ime,prezime  FROM autor";
                        $podaci4 = $baza->selectDB($popuni4);
                        print '<select name="autor" id="autor" class="cmbBox">';
                        while ($red = mysqli_fetch_assoc($podaci4)) {
                            print '<option value="' . $red['autor_id'] . '"';
                            print ' selected="selected"';
                            print '>' . $red['ime'] ." " .$red["prezime"] . '</option>';
                        }
                        print '</select>';
                        ?><br><br>
                        <label for = "ime2" class="unosModerator">Novo ime</label>
                        <input id="ime2" name="ime2" type="text" class="cmbBox"><br><br>
                        <label for = "prezime2" class="unosModerator">Novo prezime</label>
                        <input id="prezime2" name="prezime2" type="text" class="cmbBox"><br><br>
                        <input type="submit" name="submitBrisi"  value="Izbriši autora">
                        <input type="submit" name="submitUpdate" value="Ažuriraj autora">
                    </form>
                    <hr>
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
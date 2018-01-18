<?php
session_start();
include 'slike.php';
$baza = new Baza();
$baza->spojiDB();
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
                        echo '<li><a  href = "posudba.php" >Posudbe</a></li>';
                        echo '<li><a  href = "knjige.php" >Knjige</a></li>';
                        echo '<li><a  class="active" href = "galerija.php" >Galerija</a></li>';
                    }
                    ?>
                    <li  class="desno"><a href ="logout.php">Odjavi se</a></li>';
                </ul>
            </nav>
        </div>
        <div class="glavnasekcija">
            <section>

                <div class = "posudbe">
                    <form enctype="multipart/form-data" action="<?php echo "slike.php?korisnik=" . $korisnik ?>" method="post">
                        <label for = "oznaka" class="unosModerator">Dodaj oznaku</label>
                        <input type="text" id="oznaka" name="oznaka"><br><br>
                        Preuzmi datoteku: <input name="userfile" type="file" /><br>
                        <input type="submit" value="Pošalji" name="upload" />
                    </form>
                    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for = "filter" class="unosModerator">Oznaka</label>
                        <input type="text" id="filter" name="filter"><br><br>
                        <input type="submit" value="Filtriraj" name="filtriraj" />
                    </form>
                    <?php
                    
                    if (isset($_POST["filter"]) && isset($_POST["filtriraj"])) {              
                        $oznaka = $_POST["filter"];
                        $upitSlike = $baza->selectDB("SELECT naziv,oznaka FROM slike WHERE id_korisnik = '$korisnik' AND oznaka = '$oznaka' ");
                        if ($_POST["filter"] == "") {
                            $upitSlike = $baza->selectDB("SELECT naziv,oznaka FROM slike WHERE id_korisnik = '$korisnik'");
                        }
                    } else {
                        $upitSlike = $baza->selectDB("SELECT naziv,oznaka FROM slike WHERE id_korisnik = '$korisnik'");
                    }
                    while ($red = mysqli_fetch_assoc($upitSlike)) {
                        print '<img src ="' . 'upload/' . $red['naziv'] . '" width = "100px" height = "100px" >';
                        print '<br>' . $red["oznaka"];
                    }
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

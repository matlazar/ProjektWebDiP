<?php

include 'baza_class.php';
include 'dohvati_virtualno.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
if (isset($_GET["id"])) {
    $korisnik = $_GET["id"];
}
$vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
//Lajkovi 
if (isset($_POST["knjiga"]) && isset($_POST["like"])) {
    $knjiga = $_POST["knjiga"];
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk WHERE id_korisnik = '$korisnik' AND id_knjiga = '$knjiga'");
    if ($upitPovijestiLike->num_rows == 0) {
        $baza->updateDB("UPDATE knjiga SET svida = svida + 1 WHERE knjiga_id = '$knjiga'");
        $baza->updateDB("INSERT INTO lajk(id_korisnik,id_knjiga,opis_like,vrijeme_like) VALUES ('$korisnik','$knjiga',1,'$vrijeme')");
        header("Location: knjige.php?ok=1");
    }
    header("Location: knjige.php?er=1");
}

if (isset($_POST["knjiga"]) && isset($_POST["unlike"])) {
    $knjiga = $_POST["knjiga"];
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk WHERE id_korisnik = '$korisnik' AND id_knjiga = '$knjiga'");
    if ($upitPovijestiLike->num_rows == 0) {
        $baza->updateDB("UPDATE knjiga SET nesvida = nesvida + 1 WHERE knjiga_id = '$knjiga'");
        $baza->updateDB("INSERT INTO lajk(id_korisnik,id_knjiga,opis_like,vrijeme_like) VALUES ('$korisnik','$knjiga',DEFAULT,'$vrijeme')");
        header("Location: knjige.php?ok=2");
    }
    header("Location: knjige.php?er=2");
}

if (isset($_POST["knjiga"]) && isset($_POST["remove"])) {
    $knjiga = $_POST["knjiga"];
    $upit_opis_like = $baza->selectDB("SELECT opis_like FROM lajk WHERE id_korisnik = '$korisnik' AND id_knjiga = '$knjiga'");
    $like_tip = mysqli_fetch_array($upit_opis_like, MYSQLI_BOTH);
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk WHERE id_korisnik = '$korisnik' AND id_knjiga = '$knjiga'");
    if ($upitPovijestiLike->num_rows > 0) {
        if ($like_tip[0] == 1) {
            $baza->updateDB("UPDATE knjiga SET svida = svida - 1 WHERE knjiga_id = '$knjiga'");
            $baza->updateDB("DELETE FROM lajk WHERE id_knjiga = '$knjiga' AND id_korisnik = '$korisnik'");
            header("Location: knjige.php?ok=2");
        } else {
            $baza->updateDB("UPDATE knjiga SET nesvida = nesvida - 1 WHERE knjiga_id = '$knjiga'");
            $baza->updateDB("DELETE FROM lajk WHERE id_knjiga = '$knjiga' AND id_korisnik = '$korisnik'");
            header("Location: knjige.php?ok=2");
        }
    }
    header("Location: knjige.php?ok=2");
}

//Lajkovi zanra

if (isset($_POST["kategorije"]) && isset($_POST["like1"])) {
    $zanr = $_POST["kategorije"];
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk_zanr WHERE korisnik_id = '$korisnik' AND zanr_id = '$zanr'");
    if ($upitPovijestiLike->num_rows == 0) {
        $baza->updateDB("UPDATE tip_kategorije SET svida = svida + 1 WHERE id_tip_kategorije = '$zanr'");
        $baza->updateDB("INSERT INTO lajk_zanr(zanr_id,korisnik_id,status_like,vrijeme_like) VALUES ('$zanr','$korisnik',1,'$vrijeme')");
        header("Location: knjige.php?ok=1");
    }
    header("Location: knjige.php?er=1");
}

if (isset($_POST["kategorije"]) && isset($_POST["unlike1"])) {
    $zanr = $_POST["kategorije"];
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk_zanr WHERE korisnik_id = '$korisnik' AND zanr_id = '$zanr'");
    if ($upitPovijestiLike->num_rows == 0) {
        $baza->updateDB("UPDATE tip_kategorije SET nesvida = nesvida + 1 WHERE id_tip_kategorije = '$zanr'");
        $baza->updateDB("INSERT INTO lajk_zanr(zanr_id,korisnik_id,status_like,vrijeme_like) VALUES ('$zanr','$korisnik',1,'$vrijeme')");
        header("Location: knjige.php?ok=2");
    }
    header("Location: knjige.php?er=2");
}

if (isset($_POST["kategorije"]) && isset($_POST["remove1"])) {
    $zanr = $_POST["kategorije"];
    $upit_opis_like = $baza->selectDB("SELECT status_like FROM lajk_zanr WHERE korisnik_id = '$korisnik' AND zanr_id = '$zanr'");
    $like_tip = mysqli_fetch_array($upit_opis_like, MYSQLI_BOTH);
    $upitPovijestiLike = $baza->selectDB("SELECT * FROM lajk_zanr WHERE korisnik_id = '$korisnik' AND zanr_id = '$zanr'");
    if ($upitPovijestiLike->num_rows > 0) {
        if ($like_tip[0] == 1) {
            $baza->updateDB("UPDATE tip_kategorije SET svida = svida - 1 WHERE id_tip_kategorije = '$zanr'");
            $baza->updateDB("DELETE FROM lajk_zanr WHERE zanr_id = '$zanr' AND korisnik_id = '$korisnik'");
            header("Location: knjige.php?ok=2");
        } else {
            $baza->updateDB("UPDATE tip_kategorije SET nesvida = nesvida - 1 WHERE id_tip_kategorije = '$zanr'");
            $baza->updateDB("DELETE FROM lajk_zanr WHERE zanr_id = '$zanr' AND korisnik_id = '$korisnik'");
            header("Location: knjige.php?ok=2");
        }
    }
    header("Location: knjige.php?ok=2");
}
?>

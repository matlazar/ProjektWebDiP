<?php

include 'baza_class.php';
include 'dohvati_virtualno.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
if (isset($_GET["korisnik"])) {
    $korisnik = $_GET["korisnik"];
}
$vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));

if (isset($_POST["mod_knjizara"]) && isset($_POST["potvrdi"])) {
    $id = $_POST["mod_knjizara"];
    header("Location: posudba.php?id=" . $id);
}

if (isset($_POST["slobodne"]) && isset($_POST["rezerviraj"]) && isset($_POST["broj_dana"]) && isset($_POST["datum"])) {
    $poruka = $_POST['slobodne'];
    $broj_dana = $_POST["broj_dana"];
    $datum_od = $_POST["datum"];
    $datum_do = date('Y-m-d', strtotime($datum_od . '+' . $broj_dana . 'days'));
    $knjiga_knjiznica = explode('|', $poruka);
    $upitZamoderatora = $baza->selectDB("SELECT id_korisnik FROM knjiznica WHERE id_knjiznica = '$knjiga_knjiznica[1]'");
    $moderator = mysqli_fetch_array($upitZamoderatora, MYSQLI_BOTH);
    $baza->updateDB("INSERT INTO rezervacija (korisni1_id,korisnik2_id,knjiga_id,broj_dana,datum_od,datum_do) "
            . "VALUES('$korisnik','$moderator[0]','$knjiga_knjiznica[0]','$broj_dana','$datum_od','$datum_do')");
    $baza->updateDB("UPDATE pripada SET status_knjige = 3 WHERE knjiga_id = '$knjiga_knjiznica[0]' AND id_knjiznica = '$knjiga_knjiznica[1]'");
    $dnevnikUpdate = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,radnja_id,id_korisnik)"
                . " VALUES (DEFAULT,'$vrijeme',4,'$korisnik')";
    header("Location: posudba.php");
}


//Posudi od drugog korisnika
if (isset($_POST["kor_knjizara"]) && isset($_POST["potvrdi2"])) {
    $vrijednosti = $_POST['kor_knjizara'];
    $id = explode('|', $vrijednosti);
    header("Location: posudba.php?k=" . $id[0] . "&m=" . $id[1]);
}

if (isset($_POST["posudba"]) && isset($_POST["rezerviraj1"]) && isset($_POST["broj_dana1"]) && isset($_POST["datum1"])) {
    $poruka = $_POST['posudba'];
    $knjiga_lib_mod = explode('|', $poruka);
    $knjiga = $knjiga_lib_mod[0];
    $mod = $knjiga_lib_mod[2];
    $knjiznica = $knjiga_lib_mod[1];


    $broj_dana = $_POST["broj_dana1"];
    $datum_od = $_POST["datum1"];
    $datum_do = date('Y-m-d', strtotime($datum_od . '+' . $broj_dana . 'days'));

    //provjera datum do od
    $upit = $baza->selectDB("SELECT datum_do FROM posudba WHERE posudioje_id='$mod' AND knjiga_id = '$knjiga' ");
    $provjeraDatuma = mysqli_fetch_array($upit, MYSQLI_BOTH);
    $provjera = round(strtotime($datum_do) - strtotime($provjeraDatuma[0])) / 86400;
    $provjera_od = round(strtotime($datum_od) - strtotime($provjeraDatuma[0])) / 86400;
    if ($provjera_od >= 0) {
        header("Location: posudba.php?ne=1");
    } elseif ($provjera > 0) {
        $prava_posudba = $broj_dana - $provjera;
        header("Location: posudba.php?posudba=" . $prava_posudba);
    } else {
        $novi_datum_do = date('Y-m-d', strtotime($datum_od . '+' . $broj_dana . 'days'));
        $baza->updateDB("INSERT INTO rezervacija_korisnik (posudi_id,posudioje_id,knjiga_id,broj_dana,datum_od,datum_do) "
                . "VALUES('$korisnik','$mod','$knjiga','$broj_dana','$datum_od','$novi_datum_do')");
         $baza->updateDB("UPDATE pripada SET status_knjige = 3 WHERE knjiga_id = '$knjiga' AND id_knjiznica = '$knjiznica'");
        header("Location: posudba.php?da=1");
    }

     

}
?>


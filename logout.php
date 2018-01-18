<?php
include 'baza_class.php';
include 'dohvati_virtualno.php';
$br_Sati = dohvati_pomak();
$baza = new Baza();
$baza->spojiDB();
session_start();
$id_korisnik = $_SESSION["id_korisnik"];
$vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
unset($_SESSION["korime"]);
unset($_SESSION["id_tip"]);
unset($_SESSION["lozinka"]);
unset($_SESSION["id_korisnik"]);
unset($_SESSION["telefon"]);
unset($_SESSION["email"]);
unset($_SESSION["vrijeme_prijave"]);
$dnevnikUpdate = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,radnja_id,id_korisnik)"
                . " VALUES (DEFAULT,'$vrijeme',2,'$id_korisnik')";
$baza->updateDB($dnevnikUpdate);
session_unset();
session_destroy();
$baza->zatvoriDB();
header("Location: prijava.php");
?>

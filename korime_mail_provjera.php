<?php
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
if (isset($_POST['korisnik'])) {
    $korime = $_POST['korisnik'];
    $upitZaKorIme = " SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime='$korime'";
    $queryKorIme = $baza->selectDB($upitZaKorIme);
    if ($queryKorIme->num_rows > 0) {
        echo 0;
    } else {
        echo 1;
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $upitZaEmail = " SELECT email FROM korisnik WHERE email='$email' ";
    $queryEmail = $baza->selectDB($upitZaEmail);
    if ($queryEmail->num_rows > 0) {
        echo 0;
    } else {
        echo 1;
    }
}
$baza->zatvoriDB();
?>
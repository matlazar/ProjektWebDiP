<?php
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $blokiraj = " UPDATE korisnik SET blokiran = 3  WHERE id_korisnik ='$id'";
    $baza->updateDB($blokiraj);
}

if (isset($_POST['odblokiraj'])) {
    $aktiviraj = $_POST['odblokiraj'];
    $odblokiraj = " UPDATE korisnik SET blokiran = 0  WHERE id_korisnik ='$aktiviraj'";
    $baza->updateDB($odblokiraj);
}
$baza->zatvoriDB();
?>

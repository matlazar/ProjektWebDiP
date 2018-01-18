<?php
function dohvati_pomak() {
    $baza = new Baza();
    $baza->spojiDB();
    //dohvacanje vremena iz baze (pomaka)
    $upit = "SELECT br_sati FROM virtualno";
    $rez = $baza->selectDB($upit);
    while (list($br_sati) = $rez->fetch_array()) {
        $rezultat = $br_sati;
    }
    return $rezultat;
}
?>
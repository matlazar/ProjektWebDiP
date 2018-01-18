<?php

include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
if (isset($_POST["Submit"]) && $_POST["tablica"] === "knjiznica") {
    $datoteka = $_FILES[csv][tmp_name];
    $otvori = fopen($datoteka, "r");
    $poruka = 0;
    while (($otvori_dat = fgetcsv($otvori, 1000, ",")) !== false) {
        $naziv = $otvori_dat[0];
        $emai = $otvori_dat[1];
        $adresa = $otvori_dat[2];
        $telefon = $otvori_dat[3];
        if ($baza->updateDB("INSERT INTO knjiznica(id_knjiznica,naziv_knjiznice,email,adresa,telefon,id_grad,id_korisnik) "
                        . "VALUES(DEFAULT,'$naziv','$emai','$adresa','$telefon',NULL,NULL)")) {
            $poruka = 1;
        }
    }
}
if (isset($_POST["Submit"]) && $_POST["tablica"] === "korisnik") {
    include 'dohvati_virtualno.php';
    $br_Sati = dohvati_pomak();
    $datoteka = $_FILES[csv][tmp_name];
    $otvori = fopen($datoteka, "r");
    $poruka = 0;
    while (($otvori_dat = fgetcsv($otvori, 1000, ",")) !== false) {
        $vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
        $ime = $otvori_dat[0];
        $prezime = $otvori_dat[1];
        $korime = $otvori_dat[2];
        $pass = $otvori_dat[3];
        $dan= $otvori_dat[4];
        $mjesec = $otvori_dat[5];
        $godina = $otvori_dat[6];
        $spol = $otvori_dat[7];
        $drzava = $otvori_dat[8];
        $tel=$otvori_dat[9];
        $email = $otvori_dat[10];
        $status = $otvori_dat[11];
        $blokiran = $otvori_dat[12];
        $id_tip = $otvori_dat[13];
        $podatakzahash = '' . date('m.d.Y. h:i:s a', time()) . $korime;
        $napraviHash = hash('ripemd160', $podatakzahash);
        if ($baza->updateDB("INSERT INTO korisnik(id_korisnik,ime,prezime,korisnicko_ime,lozinka,potvrda_lozinke,dan,mjesec,godina,spol,drzava,telefon,email,datum_vrijeme,aktivacijski,status,blokiran,id_tip)"
                        . "VALUES(DEFAULT, '$ime','$prezime','$korime','$pass','$pass','$dan','$mjesec','$godina','$spol','$drzava','$tel','$email','$vrijeme','$napraviHash','$status','$blokiran','$id_tip')")) {
            $poruka = 2;
        }
    }
} 
$baza->zatvoriDB();
header("Location: crud_csv.php?rtrn=".$poruka);
?>
<?php
include 'dohvati_virtualno.php';
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
if (isset($_GET["korisnik"])) {
    $korisnik = $_GET["korisnik"];
}
if (isset($_POST["grad"])) {
    $vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
    $korisnik = $_SESSION["id_korisnik"];
    $grad = $_POST["grad"];
    $dodajGrad = "INSERT INTO grad (id_grad,grad) VALUES(DEFAULT,'$grad')";
    $baza->updateDB($dodajGrad);
    $baza->updateDB("UPDATE upit SET posjecenost=posjecenost + 1 WHERE upit_id = 3");
    header("Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/korisnici.php?ok=1");
}

if(isset($_POST["grad2"])){
    $vrijeme = date('Y-m-d H:i:s', time());
    $korisnik = $_SESSION["id_korisnik"];
    $grad = $_POST["grad2"];
    $izbrisGrad = "DELETE FROM grad WHERE id_grad = '$grad'";
    $baza->updateDB($izbrisGrad);
    header("Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/korisnici.php?ok2=1");
}

if(isset($_POST["naziv_knjiznice"]) && isset($_POST["email_knjiznice"]) && isset($_POST["adresa_knjiznica"]) && isset($_POST["tel_knjiznica"]) && isset($_POST["grad_knjiznica"])){
    $vrijeme = date('Y-m-d H:i:s', time());
    $korisnik = $_SESSION["id_korisnik"];
    $dnevnikUpdate = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,stranica_id,upit_id,radnja_id,id_korisnik)"
            . " VALUES (DEFAULT,'$vrijeme',NULL,4,3,'$korisnik')";
    $baza->updateDB($dnevnikUpdate);
    $baza->updateDB("UPDATE upit SET posjecenost = posjecenost + 1 WHERE upit_id = 4");
    $naziv = $_POST["naziv_knjiznice"];
    $email =$_POST["email_knjiznice"] ;
    $adresa = $_POST["adresa_knjiznica"];
    $telefon = $_POST["tel_knjiznica"];
    $grad = $_POST["grad_knjiznica"];
    $baza->updateDB("INSERT INTO knjiznica(id_knjiznica,naziv_knjiznice,email,adresa,telefon,id_grad,id_korisnik) VALUES (DEFAULT,'$naziv','$email','$adresa','$telefon','$grad',NULL)");
    header("Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/korisnici.php?ok3=1");
}

if(isset($_POST["mod_knjiznica"]) && isset($_POST["mod_korisnik"])){
   $knjiznica = $_POST["mod_knjiznica"];
   $moderator = $_POST["mod_korisnik"];
   $baza->updateDB("UPDATE upit SET posjecenost = posjecenost + 1 WHERE upit_id = 5");
   $baza->updateDB("UPDATE korisnik SET id_tip = 2 WHERE id_korisnik = '$moderator'");
   $baza->updateDB("UPDATE knjiznica SET id_korisnik = '$moderator' WHERE id_knjiznica = '$knjiznica'");
   header("Location: https://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/korisnici.php?ok4=1");
}

$baza->zatvoriDB();
?>
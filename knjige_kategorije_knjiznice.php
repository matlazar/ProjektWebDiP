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
if (isset($_POST["kategorije"])) {
    $kategorije = $_POST["kategorije"];
    $baza->updateDB("INSERT INTO tip_kategorije (id_tip_kategorije,naziv) VALUES(DEFAULT,'$kategorije')");
    $dnevnikUpdate2 = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,radnja_id,id_korisnik)"
            . " VALUES (DEFAULT,'$vrijeme',5,'$korisnik')";
    $baza->updateDB($dnevnikUpdate2);
    header("Location: moderator.php?ok=1");
}

if(isset($_POST["kategorije1"]) && isset($_POST["knjiznica"]) && isset($_POST["katknji"])){
    $kategorija = $_POST["kategorije1"];
    $knjiznica = $_POST["knjiznica"];
    $baza->updateDB("INSERT INTO kategorije_knjiznice (id_tip,id_knjiznica) VALUES('$kategorija','$knjiznica')");
    header("Location: moderator.php?ok=2");
}

if(isset($_POST["naziv_knjige"]) && isset($_POST["br_stranica"]) && isset($_POST["izdanje"]) && isset($_POST["izdavac"]) && isset($_POST["autor"]) && isset($_POST["zanr"])){
    $naslov = $_POST["naziv_knjige"];
    $stranica = $_POST["br_stranica"];
    $izdanje = $_POST["izdanje"];
    $izdavac = $_POST["izdavac"];
    $autor = $_POST["autor"];
    $zanr = $_POST["zanr"];
    $baza->updateDB("INSERT INTO knjiga (knjiga_id,naslov,broj_stranica,godina_izdanja,svida,nesvida,autor_id,izdavac_id,zanr_id)"
            . " VALUES(DEFAULT,'$naslov','$stranica','$izdanje',DEFAULT,DEFAULT,'$autor','$izdavac','$zanr')");
    $dnevnikUpdate = "INSERT INTO dnevnici (dnevnik_id,dnevnik_datum_vrijeme,radnja_id,id_korisnik)"
            . " VALUES (DEFAULT,'$vrijeme',3,'$korisnik')";
    $baza->updateDB($dnevnikUpdate);
    $baza->updateDB("UPDATE upit SET posjecenost = posjecenost + 1 WHERE upit_id = 1");
    header("Location: moderator.php?ok=3");
}

if(isset($_POST["x_knjiznica"]) && isset($_POST["x_knjiga"]) && isset($_POST["dodaj"])){
    $knjiga = $_POST["x_knjiga"];
    $knjiznica = $_POST["x_knjiznica"];
    $upitZaKategoriju = $baza->selectDB("SELECT zanr_id FROM knjiga WHERE knjiga_id = '$knjiga'");
    $kategorija = mysqli_fetch_array($upitZaKategoriju,MYSQLI_BOTH);
    $provjera_zanra = $baza->selectDB("SELECT * FROM kategorije_knjiznice WHERE id_tip = '$kategorija[0]' AND id_knjiznica = '$knjiznica'");
    if($provjera_zanra->num_rows > 0){
    $baza->updateDB("INSERT INTO pripada (knjiga_id,id_knjiznica,status_knjige,broj_posudbi) VALUES('$knjiga','$knjiznica',DEFAULT,DEFAULT)");
    header("Location: moderator.php?ok=4");
    }else{
        header("Location: moderator.php?error=1");
    }
}

if(isset($_POST["knjigice"]) && isset($_POST["knjili"])){
    $knjig = $_POST["knjigice"];
    $upit=$baza->selectDB("SELECT svida,nesvida FROM knjiga WHERE knjiga_id = '$knjig'");
    $lajkovi = mysqli_fetch_assoc($upit);
    header("Location: moderator.php?s=".$lajkovi["svida"]."&n=".$lajkovi["nesvida"]);
}

if(isset($_POST["zanrici"]) && isset($_POST["knjili2"])){
    $zanr = $_POST["zanrici"];
    $upit=$baza->selectDB("SELECT svida,nesvida FROM tip_kategorije WHERE id_tip_kategorije = '$zanr'");
    $lajkovi = mysqli_fetch_assoc($upit);
    header("Location: moderator.php?sv=".$lajkovi["svida"]."&ns=".$lajkovi["nesvida"]);
}
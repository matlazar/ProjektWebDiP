<?php
include 'baza_class.php';
include 'dohvati_virtualno.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
$vrijeme = date('Y-m-d H:i:s', strtotime($br_Sati . " hours"));
if (isset($_GET["korisnik"])) {
    $korisnik = $_GET["korisnik"];
}
if(isset($_POST["upload"])){
    $oznaka = $_POST["oznaka"];
    $userfile = $_FILES['userfile']['tmp_name'];
    $userfile_name = $_FILES['userfile']['name'];
    $userfile_size = $_FILES['userfile']['size'];
    $userfile_type = $_FILES['userfile']['type'];
    $baza->updateDB("INSERT INTO slike(id_slike,naziv,oznaka,id_korisnik) VALUES (DEFAULT,'$userfile_name','$oznaka','$korisnik')");
    $upfile = 'upload/' . $userfile_name;
    move_uploaded_file($userfile, $upfile);
    header("Location: galerija.php");
}
?>
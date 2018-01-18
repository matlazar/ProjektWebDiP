<?php

include 'baza_class.php';
include 'dohvati_virtualno.php';
$baza = new Baza();
$baza->spojiDB();
$br_Sati = dohvati_pomak();
//Izdavac
if (isset($_POST["izdavac"])) {
    $izdavac = $_POST["izdavac"];
    $baza->updateDB("INSERT INTO izdavac (izdavac_id,naziv) VALUES(DEFAULT,'$izdavac')");
    header("Location: crud_csv.php?ok=1");
}

if (isset($_POST["izdavac2"]) && isset($_POST["submitBrisi"])) {
    $izdavac = $_POST["izdavac2"];
    $baza->updateDB("DELETE FROM izdavac WHERE izdavac_id = '$izdavac'");
    header("Location: crud_csv.php?ok=2");
} elseif (isset($_POST["izdavac2"]) && isset($_POST["submitUpdate"]) && $_POST["izdavac3"] !== "") {
    $izdavac = $_POST["izdavac2"];
    $izdavac2 = $_POST["izdavac3"];
    $baza->updateDB("UPDATE izdavac SET naziv = '$izdavac2' WHERE izdavac_id = '$izdavac'");
    header("Location: crud_csv.php?ok=3");
}

//Status
if (isset($_POST["status"])) {
    $status = $_POST["status"];
    $baza->updateDB("INSERT INTO status (status_id,naziv) VALUES(DEFAULT,'$status')");
    header("Location: crud_csv.php?ok=4");
}

if (isset($_POST["status2"]) && isset($_POST["submitBrisi"])) {
    $status = $_POST["status2"];
    $baza->updateDB("DELETE FROM status WHERE status_id = '$status'");
    header("Location: crud_csv.php?ok=5");
} elseif (isset($_POST["status2"]) && isset($_POST["submitUpdate"]) && $_POST["status3"] !== "") {
    $status = $_POST["status2"];
    $status2 = $_POST["status3"];
    $baza->updateDB("UPDATE status SET naziv = '$status2' WHERE status_id = '$status'");
    header("Location: crud_csv.php?ok=6");
}

//autor
if (isset($_POST["ime"]) && isset($_POST["prezime"])) {
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $baza->updateDB("INSERT INTO autor (autor_id,ime,prezime) VALUES(DEFAULT,'$ime','$prezime')");
    header("Location: crud_csv.php?ok=7");
}

if (isset($_POST["autor"]) && isset($_POST["submitBrisi"])) {
    $autor = $_POST["autor"];
    $baza->updateDB("DELETE FROM autor WHERE autor_id = '$autor'");
    header("Location: crud_csv.php?ok=8");
} elseif (isset($_POST["autor"]) && isset($_POST["submitUpdate"]) && ($_POST["ime2"] !== "" || $_POST["prezime2"] !== "")) {
    $autor = $_POST["autor"];
    $ime = $_POST["ime2"];
    $prezime = $_POST["prezime2"];
    if ($ime === "" && $prezime !== "") {
        $baza->updateDB("UPDATE autor SET prezime = '$prezime' WHERE autor_id = '$autor'");
    }elseif($prezime === "" && $ime !== ""){
        $baza->updateDB("UPDATE autor SET ime = '$ime' WHERE autor_id = '$autor'");
    }else{
        $baza->updateDB("UPDATE autor SET ime = '$ime',prezime = '$prezime' WHERE autor_id = '$autor'");
    }
    header("Location: crud_csv.php?ok=9");
}
?>

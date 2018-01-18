<?php
require 'baza_class.php';
$xml = simplexml_load_file("http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=xml") or die("Error: Cannot create object");
$sati = $xml->vrijeme->pomak->brojSati;
$baza = new Baza();
$baza->spojiDB();
$upit = "UPDATE virtualno set br_sati =" . $sati . " WHERE id_virtualno=1";
$baza->updateDB($upit);
header("Location: konfiguracija.php");
?>
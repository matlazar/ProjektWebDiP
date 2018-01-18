<?php
include 'baza_class.php';
$baza = new Baza();
$baza->spojiDB();
$aktivacija = $_GET["aktkod"];
if (isset($aktivacija)) {
    $upitZaVrijeme = $baza->selectDB("SELECT datum_vrijeme FROM korisnik WHERE aktivacijski = '$aktivacija'");
    $vrijeme1 = mysqli_fetch_array($upitZaVrijeme,MYSQLI_BOTH);//ispravi
    $vrijeme2 = date('Y-m-d H:i:s',time());
    $timestamp1 = strtotime($vrijeme1[0]);
    $timestamp2 = strtotime($vrijeme2);
    $razlika = abs($timestamp2 - $timestamp1) / (60 * 60);
    if($razlika > 24){
        echo 'Istekao vam se aktivacijski link, registrirajte se ponovno'.'<br>';
        $baza->updateDB("DELETE FROM korisnik WHERE aktivacijski = '$aktivacija'");
        echo '<a href ="registracija.php">Vrati se na registraciju</a>';
    }else{
        $baza->updateDB("UPDATE korisnik SET status = 1 WHERE aktivacijski = '$aktivacija'");
        header("Location: http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x045/prijava.php?aktivirano=1");
    }
}else{
    echo 'Niste registrirani<br>';
    echo '<a href ="registracija.php">Vrati se na registraciju</a>';
}
?>

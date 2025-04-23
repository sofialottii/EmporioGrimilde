<?php 

require_once("bootstrap.php");

session_start();

/*offcanvas*/
if (isUserLoggedIn()) {
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $sessoUtente = $dbh->getProfilo()[0]["Sesso"];
} else {
    $utente = "Accedi";
    $sessoUtente = "";
}
$templateParams["canvas"] = "contenutoOffCanvas.php";
comandiCanvas();



if (isset($_POST["acquista"])) {
    header("location: acquisto.php");
    exit;
}

if (isset($_POST["creaRecensione"])) {
    header("location: nuovaRecensione.php");
    exit;
}

if (isset($_POST["vediRecensioni"])) {
    header("location: recensioniAdmin.php");
    exit;
} 


$templateParams["titolo"] = "Grimilde's - Home";
$templateParams["nome"] = "contenutoIndex.php";
$templateParams["recensioni"] = $dbh->getRecensioni();

if(empty($templateParams["recensioni"])){
    $templateParams["errore"] = "Non sono presenti recensioni! Sii il primo a scriverne una!";
}

require("../template/base.php");

?>
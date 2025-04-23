<?php 
require_once("bootstrap.php");
session_start();

if(isUserLoggedIn()){
    $templateParams["profilo"] = $dbh->getProfilo();
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $sessoUtente = $dbh->getProfilo()[0]["Sesso"];
}
else{
    header("location: login.php");
    exit;
}

/*canvas*/
$templateParams["canvas"] = "contenutoOffCanvas.php";
comandiCanvas();

$templateParams["titolo"] = "Grimilde's - Ordine " . $_GET["IdSingoloOrdine"]; //title
$templateParams["nome"] = "contenutoOrdine.php";

$templateParams["contenuto"] = $dbh->getElementiOrdine($_GET["IdSingoloOrdine"], $_GET["mail"]);
$templateParams["totale"] = $dbh->getTotaleOrdine($_GET["IdSingoloOrdine"], $_GET["mail"]);

require("../template/base.php");
?>
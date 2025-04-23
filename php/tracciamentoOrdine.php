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


$templateParams["titolo"] = "Grimilde's - Tracciamento Ordine";
$templateParams["nome"] = "contenutoTracciamento.php";
$templateParams["ordine"] = $dbh->getOrdine($_SESSION["E_mail"], $_GET["IDOrdine"]);

$dataTemp = explode(" ",$templateParams["ordine"][0]["DataOra"]);
$dataOrdine = new DateTime($dataTemp[0]);
$dataAttuale = new DateTime();
$differenzaGiorni = $dataAttuale->diff($dataOrdine)->days;

if ($differenzaGiorni <= 0){
    $dbh->cambiaStatoOrdine($_SESSION["E_mail"], $_GET["IDOrdine"], "InPreparazione");
}
else if ($differenzaGiorni == 1){
    $dbh->cambiaStatoOrdine($_SESSION["E_mail"], $_GET["IDOrdine"], "InTransito");
} else if ($differenzaGiorni >= 2) {
    $dbh->cambiaStatoOrdine($_SESSION["E_mail"], $_GET["IDOrdine"], "Consegnato");
}
$templateParams["ordine"] = $dbh->getOrdine($_SESSION["E_mail"], $_GET["IDOrdine"]); 

require("../template/base.php");

?>
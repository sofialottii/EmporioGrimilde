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

$templateParams["titolo"] = "Grimilde's - Preferiti";
$templateParams["nome"] = "listaPreferiti.php";

$templateParams["prodotti"] = $dbh->getProdottiPreferiti();
$templateParams["carrello"] = $dbh->getCarrello($_SESSION["E_mail"]);

require("../template/base.php");

?>
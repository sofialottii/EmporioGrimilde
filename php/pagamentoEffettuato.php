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

$templateParams["titolo"] = "Grimilde's - Conferma Pagamento";
$templateParams["nome"] = "contenuoPagamentoEffettuato.php";

require("../template/base.php");
?>
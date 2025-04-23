<?php 
require_once("bootstrap.php");
session_start();

$templateParams["titolo"] = "Grimilde's - Storico Oridini"; //title
$templateParams["nome"] = "listaOrdini.php";

if(isUserLoggedIn()){
    $templateParams["ordini"] = $dbh->isUtenteAdmin($_SESSION["E_mail"]) ?
    $dbh->getOrdiniAdmin() : $dbh->getOrdini();
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


if(empty($templateParams["ordini"])){
    $templateParams["errore"] = "Non sono stati effettuati ordini!";
}

if(isset($_POST["cancellanotifiche"])){
    $dbh->rimuoviTutteNotifiche();
   header("location: #");
    exit;
}

if(isset($_POST["rimuovi"])){
    $dbh->rimuoviNotifica($_POST["IdNotifica"]);
    header("location: storicoNotifiche.php");
    exit;
}

require("../template/base.php");
?>
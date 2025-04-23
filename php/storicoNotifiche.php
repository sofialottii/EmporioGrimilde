<?php 
require_once("bootstrap.php");
session_start();


$templateParams["titolo"] = "Grimilde's - Notifiche";
$templateParams["nome"] = "contenutoStoricoNotifiche.php";
$utente=$_SESSION["E_mail"];

if(isUserLoggedIn()){
    if($dbh->isUtenteAdmin($_SESSION["E_mail"])){
        $templateParams["notifiche"] = $dbh->getNotificheAdmin();
    }
    else{
        $templateParams["notifiche"] = $dbh->getNotifiche();
    }
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $sessoUtente = $dbh->getProfilo()[0]["Sesso"];

} else{
    header("location: login.php");
    exit;
}

/*canvas*/
$templateParams["canvas"] = "contenutoOffCanvas.php";
comandiCanvas();

if(empty($templateParams["notifiche"])){
    $templateParams["errore"] = "Non ci sono notifiche!";
}

if(isset($_POST["cancellanotifiche"])){
    $dbh->rimuoviTutteNotifiche();
   header("location: #");
    exit;
}

if(isset($_POST["rimuovi"])){
    $dbh->rimuoviNotifica($_POST["IdNotifica"]);
    header("location: #");
    exit;
}

require("../template/base.php");
?>
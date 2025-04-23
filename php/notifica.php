<?php 
    require_once("bootstrap.php");
    session_start();
    
    $templateParams["notifica"] = $dbh->getNotifica($_GET["IdNotifica"]);
    $dbh->cambiaStatoNotifica($_GET["IdNotifica"]);

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

    $templateParams["titolo"] = "Grimilde's - Notifica " . $_GET["IdNotifica"]; //aggiungi nome notifica da db
    $templateParams["nome"] = "contenutoNotifica.php";

    if(isset($_POST["rimuovi"])){
        $dbh->rimuoviNotifica($_POST["IdNotifica"]);
        header("location: storicoNotifiche.php");
        exit;
    }

    require("../template/base.php");
?>
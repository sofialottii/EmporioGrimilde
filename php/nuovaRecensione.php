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


if(isset($_POST["creaRecensione"])){
    if ($dbh->checkRecensioneFattaOggi($_SESSION["E_mail"], date("Y-m-d"))) {
        $templateParams["erroreRecensione"] = "Hai già recensito oggi! Torna domani.";
    } else {
        $testoRecensione = $_POST["testoRecensione"];
        $numeroStelle = $_POST["rating"] ?? 0;
        $dataOggi = date("Y-m-d");
        $dbh->creaRecensione($_SESSION["E_mail"], $numeroStelle, $dataOggi, $testoRecensione);
        /*notifica: */
        $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
        $num = $dbh->getIDNotificaPiuAlta($_SESSION["E_mail"]);
        $dbh->creaNotifica($_SESSION["E_mail"], $num+1, "Recensione Salvata", "$utente, grazie mille per aver
        condiviso la tua esperienza! 💬 Il tuo feedback è prezioso per noi e per la nostra community. Torna domani per lasciare una nuova recensione.", "N");
        $Persone = $dbh->getAllMails();
        foreach($Persone as $Persona){
            if ($Persona["Amministratore"] == 'Y'){
                $num = $dbh->getIDNotificaPiuAlta($Persona["E_mail"]);
                $dbh->creaNotifica($Persona["E_mail"], $num+1, "Nuova recensione", "$utente ha appena pubblicato una
                recensione. Visualizza e gestisci lo storico delle recensioni <a href='recensioniAdmin.php'>a questo link.</a>", "Y");
            }
        }
        header("location: index.php");
        exit;
    }
}



$templateParams["titolo"] = "Grimilde's - Nuova Recensione";
$templateParams["nome"] = "formCreaRecensione.php";

require("../template/base.php");

?>
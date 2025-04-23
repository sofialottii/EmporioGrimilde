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

$templateParams["carrello"] = $dbh->getCarrello($_SESSION["E_mail"]);


if(isset($_POST["pagaConVecchiaCarta"])){
    /*salvo il mio ordine. Creo ogni associazione di "contiene". Svuoto il carrello dell'utente in sessione*/
    $dataOggi = date('Y-m-d H:i:s');
    $importoTotale = prezzoTotale($templateParams["carrello"]);
    $IDOrdine = count($dbh->getNumeroOrdini($_SESSION["E_mail"])) + 1;
    $dbh->creaOrdine($IDOrdine, $dataOggi, $importoTotale, NULL, $_SESSION["E_mail"], "InPreparazione");
    foreach ($templateParams["carrello"] as $associazioneCarrello){
        $dbh->creaAssociazioneContiene($IDOrdine, $dataOggi, intval($associazioneCarrello["IDProdotto"]), intval($associazioneCarrello["QuantitaInCarrello"]));
    }
    $dbh->svuotaCarrello($_SESSION["E_mail"]);
    doNotificaPagamento($utente, $IDOrdine);
    header ("location: pagamentoEffettuato.php?IDOrdine=$IDOrdine");
    exit;
}

if(isset($_POST["pagaConNuovaCarta"])){
    $nomeIntestatarioCarta = $_POST["nome"];
    $cognomeIntestatarioCarta = $_POST["cognome"];
    $numeroCarta = $_POST["numeroCarta"];
    $dataScadenza = $_POST["scadenza"];
    $CVC = $_POST["cvv"];
    $memorizza = isset($_POST["memorizza_carta"]) ? 1 : 0;

    $templateParams["risultatoCartaEsistente"] = $dbh->riceviDatiDalNumeroCarta($_POST["numeroCarta"]);
    $errori = 0;
    if (!empty($templateParams["risultatoCartaEsistente"])){
        $memorizza = 0;
        $errori = checkErroriCarta($templateParams["risultatoCartaEsistente"], $numeroCarta, $CVC, $dataScadenza, $nomeIntestatarioCarta, $cognomeIntestatarioCarta);
        if ($errori >= 1){
            $templateParams["errore"] = "La carta risulta essere presente nel database e i dati non corrispondono. Riprovare.";
        }
    } else if($memorizza == 1){
        $dbh->salvaDati($numeroCarta, $CVC, $dataScadenza, $nomeIntestatarioCarta, $cognomeIntestatarioCarta );
    }
    if ($errori==0){
        /*salvo il mio ordine. Creo ogni associazione di "contiene". Svuoto il carrello dell'utente in sessione*/
        $dataOggi = date('Y-m-d H:i:s');
        $importoTotale = prezzoTotale($templateParams["carrello"]);
        $IDOrdine = count($dbh->getNumeroOrdini($_SESSION["E_mail"])) + 1;
        $dbh->creaOrdine($IDOrdine, $dataOggi, $importoTotale, NULL, $_SESSION["E_mail"], "InPreparazione");
        foreach ($templateParams["carrello"] as $associazioneCarrello){
            $dbh->creaAssociazioneContiene($IDOrdine, $dataOggi, intval($associazioneCarrello["IDProdotto"]), intval($associazioneCarrello["QuantitaInCarrello"]));
        }
        doNotificaPagamento($utente, $IDOrdine);
        $dbh->svuotaCarrello($_SESSION["E_mail"]);
        header ("location: pagamentoEffettuato.php?IDOrdine=$IDOrdine");
        exit;
    }

}

$templateParams["carteSalvate"] = $dbh->getDati();
$totale = prezzoTotale($templateParams["carrello"]);
$templateParams["titolo"] = "Grimilde's - Pagamento";
$templateParams["nome"] = "contenutoPagamento.php";



require("../template/base.php");
?>
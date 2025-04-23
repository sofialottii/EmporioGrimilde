<?php

/* l'utente si è appena loggato, la sessione viene aggiornata. Per
diminuire l'esposizione di dati sensibili, salviamo solo la mail */
function registerLoggedUser($emailUser){
    $_SESSION["E_mail"] = $emailUser;

}

/* controllo se un utente è attualmente loggato */
function isUserLoggedIn(){
    return !empty($_SESSION['E_mail']);
}

function checkPassword($p1, $p2){
    return $p1 == $p2;
}

function logout(){
    session_destroy();
}

/*cambia l'immagine del cuore a seconda che il prodotto sia preferito o meno*/
function checkPreferito($IDprodotto){
    global $dbh;
    $preferito = $dbh->checkProdottoPreferito($IDprodotto);
    if (empty($preferito)){
        return "../utils/img/icons/cuore_vuoto.png";
    } else {
        return "../utils/img/icons/cuore_pieno.png";
    }

}

function getImmagineProfilo($sessoUtente){
    if ($sessoUtente == "Donna"){
        return "../utils/img/icons/utente-donna.png";
    } else if ($sessoUtente == "Uomo"){
        return "../utils/img/icons/utente-uomo.png";
    } else {
        return "../utils/img/icons/utente-altro.png";
    }
}

function prezzoTotale($carrello){
    $totale = 0;
    foreach($carrello as $prodotto){
        $totale += $prodotto["PrezzoProdotto"] * $prodotto["QuantitaInCarrello"];
    }
    return $totale;
}

function checkErroriCarta($datiVecchiaCarta, $numeroCarta, $cvc, $dataScadenza, $nomeIntestatarioCarta, $cognomeIntestatarioCarta){
    $errore = 0;
    if ($datiVecchiaCarta[0]["NumeroCarta"] != $numeroCarta){
        $errore = $errore + 1;
    } else if ($datiVecchiaCarta[0]["CVC"] != $cvc) {
        $errore = $errore + 1;
    } else if ($datiVecchiaCarta[0]["DataScadenza"] != $dataScadenza) {
        $errore = $errore + 1;
    } else if ($datiVecchiaCarta[0]["NomeIntestatarioCarta"] != $nomeIntestatarioCarta) {
        $errore = $errore + 1;
    } else if ($datiVecchiaCarta[0]["CognomeIntestatarioCarta"] != $cognomeIntestatarioCarta) {
        $errore = $errore + 1;
    }
    return $errore;
}

function doNotificaPagamento($utente, $idOrdine){
    global $dbh;
    $m = $_SESSION["E_mail"];
    $num = $dbh->getIDNotificaPiuAlta($m);
    $dbh->creaNotifica($_SESSION["E_mail"], $num+1, "Conferma Ordine", "$utente, grazie per il tuo ordine!🎉
    Stiamo preparando tutto per te. Il tuo ordine verrà consegnato in 48h. <a href='tracciamentoOrdine.php?IDOrdine=$idOrdine'>Segui il tracciamento</a>
    oppure <a href='ordineSingolo.php?IdSingoloOrdine=$idOrdine&mail=$m'>guarda il riepilogo</a>.", "N");
    $Persone = $dbh->getAllMails();
    foreach($Persone as $Persona){
        if ($Persona["Amministratore"] == 'Y'){
            $num = $dbh->getIDNotificaPiuAlta($Persona["E_mail"]);
            $dbh->creaNotifica($Persona["E_mail"], $num+1, "Nuovo Ordine", "$utente ha appena effettuato il suo
            ordine n° $idOrdine. Sbrigati a rifornire i prodotti.", "Y");
        }
    }
}

function comandiCanvas(){
    if (isset($_POST["logout"])) {
    logout();
    header("location: index.php");
    exit;
}
if (isset($_POST["login"])) {
    header("location: login.php");
    exit;
}

if (isset($_POST["registrati"])) {
    header("location: register.php");
    exit;
}

if (isset($_POST["loginAdmin"])) {
    header("location: areaRiservata.php");
    exit;
}
}

?>

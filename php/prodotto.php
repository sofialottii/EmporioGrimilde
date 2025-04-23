<?php
require_once("bootstrap.php");

session_start();

if(isUserLoggedIn()){
    $templateParams["profilo"] = $dbh->getProfilo();
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $sessoUtente = $dbh->getProfilo()[0]["Sesso"];
}
else{
    $utente = "Accedi";
    $sessoUtente = "";
}

/*canvas*/
$templateParams["canvas"] = "contenutoOffCanvas.php";
comandiCanvas();

$idProdotto = $_GET["IDProdotto"];
$templateParams["articolo"] = $dbh->getProdotto($idProdotto);
$templateParams["isUtenteAdmin"] = isUserLoggedIn() ? $dbh->isUtenteAdmin($_SESSION["E_mail"]) : false;
$templateParams["titolo"] = "Grimilde's - ".$templateParams["articolo"][0]["NomeProdotto"];
$templateParams["nome"] = "contenutoProdotto.php";

if (isset($_POST["aggiungiCarrello"])) {
    $nuovaQuantita = $templateParams["articolo"][0]["QuantitaDisponibile"] - $_POST["quantita"];
    $checkProdotto = $dbh->checkProdottoInCarrello($idProdotto);
    if (count($checkProdotto) > 0) {
        $dbh->modificaQuantitaCarrello($idProdotto, $_POST["quantita"]+$checkProdotto[0]["QuantitaInCarrello"]);
        $dbh->cambiaQuantitaProdotto($idProdotto, $nuovaQuantita);
    } else {
        if ($_POST["quantita"] > 0){
            $dbh->aggiungiCarrello($idProdotto, $_POST["quantita"]);
            $dbh->cambiaQuantitaProdotto($idProdotto, $nuovaQuantita);
        }
    }
    if($nuovaQuantita == 0){
        $Persone = $dbh->getAllMails();
        foreach($Persone as $Persona){
            if ($Persona["Amministratore"] == 'Y'){
                $num = $dbh->getIDNotificaPiuAlta($Persona["E_mail"]);
                $dbh->creaNotifica($Persona["E_mail"], $num+1, "Prodotto esaurito", "Il prodotto 00$idProdotto
                è appena stato esaurito. <a href='prodotto.php?IDProdotto=$idProdotto'>Riforniscilo subito.</a>", "Y");
            }
        }
    }
    header("location: acquisto.php");
    exit;
}

if(isset($_POST["carrelloAccedi"])){
    header("location: login.php");
    exit;
}

if(isset($_POST["cambiaRifornimento"])){
    $confermaAggiunta = $_POST["quantitaRifornimento"] == "" ? 0 : $_POST["quantitaRifornimento"];
    $nuovaQuantita = $templateParams["articolo"][0]["QuantitaDisponibile"] + ($confermaAggiunta);
    $dbh->cambiaQuantitaProdotto($idProdotto, $nuovaQuantita);
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $num = $dbh->getIDNotificaPiuAlta($_SESSION["E_mail"]);
    $dbh->creaNotifica($_SESSION["E_mail"], $num+1, "Prodotto rifornito", "$utente, hai appena
    aggiunto $confermaAggiunta Hg. del prodotto $idProdotto al magazzino.", "Y");
        
    header ("location: prodotto.php?IDProdotto=$idProdotto");
    exit;
} else if(isset($_POST["cambiaPrezzo"])){
    $dbh->cambiaPrezzoProdotto($idProdotto, $_POST["nuovoPrezzo"] ?? 0);
    header ("location: prodotto.php?IDProdotto=$idProdotto");
    exit;
} else if(isset($_POST["cambiaVisibilita"])){
    $nuovaVisibilita = $templateParams["articolo"][0]["Visibile"] == 'Y' ? 'N' : 'Y';
    $dbh->cambiaVisibilitaProdotto($idProdotto, $nuovaVisibilita);
    header ("location: prodotto.php?IDProdotto=$idProdotto");
    exit;
}

require("../template/base.php");

?>
<?php 
require_once("bootstrap.php");

session_start();

if(isUserLoggedIn()){
    $templateParams["profilo"] = $dbh->getProfilo();
    $utente = $dbh->getProfilo()[0]["Nome"]." ".$dbh->getProfilo()[0]["Cognome"];
    $sessoUtente = $dbh->getProfilo()[0]["Sesso"];
    $templateParams["carrello"] = $dbh->getCarrello($_SESSION["E_mail"]);
}
else{
    $utente = "Accedi";
    $sessoUtente = "";
}

/*canvas*/
$templateParams["canvas"] = "contenutoOffCanvas.php";
comandiCanvas();


$templateParams["titolo"] = "Grimilde's - Pagina Acquisto";
$templateParams["nome"] = "listaProdotti.php";

/*cercare i prodotti per nome*/
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $cercaProdotto = $_GET["CercaProdotto"] ?? "";
} else {
    $cercaProdotto = "";
}

/*aggiungere o rimuovere prodotto preferito*/
if (isset($_GET['IDProdotto'])) {
    $IDProdotto = $_GET['IDProdotto'];
    $preferito = $dbh->checkProdottoPreferito($IDProdotto);
    if (empty($preferito)){
        $dbh->aggiungiProdottoPreferito($IDProdotto);
    } else {
        $dbh->rimuoviProdottoPreferito($IDProdotto);
    }
    echo checkPreferito($IDProdotto);
    exit;
}

if (isUserLoggedIn() && $dbh->isUtenteAdmin($_SESSION["E_mail"])){
    $templateParams["prodotti"] = $dbh->getProdotti($cercaProdotto);
} else {
    $templateParams["prodotti"] = $dbh->getProdottiUtenti($cercaProdotto);
}

require("../template/base.php");

?>
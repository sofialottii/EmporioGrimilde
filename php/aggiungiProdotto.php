<?php require_once('bootstrap.php');

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


$templateParams["titolo"] = "Grimilde's - Nuovo Prodotto"; 
$templateParams["nome"] = "formNuovoProdotto.php"; 

if(isset($_POST["aggiungi"])){
    $NuovoId = $dbh->getMaxIDProdotto()["maxID"] + 1;
    $img = "../utils/img/".$_FILES["immagine"]["name"];
    $dbh->aggiungiProdotto($NuovoId, $_POST["nome"], $img, $_POST["descrizione"], $_POST["quantita"], $_POST["visibilita"]);
    $dbh->aggiungiProdAlTariffario($NuovoId, 100, intval($_POST["prezzo"]));
    header("location: acquisto.php");
    exit;
}


require("../template/base.php");

?>
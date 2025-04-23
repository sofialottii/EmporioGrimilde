<?php 

require_once("bootstrap.php");

session_start();

if(isset($_POST["accedi"])){
    $errore = false;
    $login_result = $dbh->checkLogin($_POST["E_mail"], $_POST["password"]);
    //login fallito:
    if(count($login_result) == 0){
        $templateParams["errorelogin"] = "Errore! Controllare username e password.";
    } else if (!$dbh->isUtenteAdmin($_POST["E_mail"])) {
        $templateParams["errorelogin"] = "Errore! Credenziali corrette, ma non sei amministratore.";
    }
    //login riuscito:
    else{
        registerLoggedUser($login_result[0]["E_mail"]);

        header("location: index.php");
        exit;
    }

}

if(isset($_POST["home"])){
    header("location: index.php");
    exit;
}

$templateParams["titolo"] = "Grimilde's - Area Riservata";
$templateParams["nome"] = "formAreaRiservata.php";

require("../template/base.php");

?>